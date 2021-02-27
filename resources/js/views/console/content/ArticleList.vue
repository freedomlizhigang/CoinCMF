<template>
  <div class="article-list">
    <Form :model="formItem" ref="formItem" :inline="true" action="javascript:void(0)">
      <FormItem>
        <Select v-model="formItem.cateid" clearable :style="{'width':'180px'}">
            <Option v-for="item in cateSelect" :value="item.value" :key="item.value">{{ item.label }}</Option>
        </Select>
      </FormItem>
      <FormItem>
        <DatePicker v-model="formItem.datetime" type="datetimerange" format="yyyy-MM-dd" style="width: 260px" placeholder="开始时间 - 结束时间"></DatePicker>
      </FormItem>
      <FormItem>
        <Input v-model="formItem.key" placeholder="输入关键字查询..."></Input>
      </FormItem>
      <FormItem>
        <Button type="primary" @click="renderTable('formItem')">筛选</Button>
      </FormItem>
    </Form>
    <div class="action-btn">
      <Button size="small" @click="deleteData" style="margin-right: 8px" type="error">批量删除</Button>
      <Button size="small" @click="showCreate(0)" type="success">添加文章</Button>
    </div>
    <Table border :columns="columns1" ref="selection" @on-selection-change="changeData" :data="tablelist" :loading="dataloading">
      <template slot-scope="{ row }" slot="push">
        <Tag v-if="row.push_flag" color="cyan">是</Tag>
        <Tag v-if="!row.push_flag" color="orange">否</Tag>
      </template>
      <template slot-scope="{ row }" slot="hits">
        <Tag color="geekblue">{{ row.hits }}</Tag>
      </template>
    </Table>
    <!-- 分页 -->
    <div class="table-page">
      <Page size="small" ref="listPage" :total="pages.total" :current="pages.current" :page-size="pages.size" show-elevator show-total @on-change="changePage"></Page>
    </div>
    <!-- 需要全屏时添加这句 :mask="false" class-name="idw100" -->
    <Drawer :mask="false" class-name="idw100" :closable="false" :mask-closable="false" :scrollable="true" title="添加文章" width="640" v-model="showModalStatus">
      <article-add ref="articleAdd" @showCreate="showCreate($event)"></article-add>
      <div class="drawer-footer">
          <Button style="margin-right: 8px" @click="showModalStatus = false">取消</Button>
          <Button type="primary" :loading="loading" @click="articleCreate()">提交</Button>
      </div>
    </Drawer>
    <Drawer :mask="false" class-name="idw100" :closable="false" :mask-closable="false" :scrollable="true" title="修改文章" width="640" v-model="showEditModalStatus">
      <article-edit ref="articleEdit" @showEdit="showEdit($event)"></article-edit>
      <div class="drawer-footer">
          <Button style="margin-right: 8px" @click="showEditModalStatus = false">取消</Button>
          <Button type="primary" :loading="loading" @click="articleEdit()">提交</Button>
      </div>
    </Drawer>
  </div>
</template>

<script>
import ArticleAdd from './ArticleAdd'
import ArticleEdit from './ArticleEdit'
export default {
  name: 'ArticleList',
  data() {
    return {
      dataloading: true,
      loading:false,
      cateSelect: [],
      formItem: {
        'key': '',
        'cateid': '',
        'datetime': ['','']
      },
      pages: {
        current: 1,
        total: 0,
        size: 10
      },
      columns1: [
        {
          type: 'selection',
          width: 60,
          align: 'center',
        },
        {
          title: 'Id',
          key: 'id',
          width: 70,
        },
        {
          title: '标题',
          minWidth: 300,
          key: 'title'
        },
        {
          title: '栏目',
          width: 150,
          key: 'catename'
        },
        {
          title: '推荐',
          width: 70,
          slot: 'push'
        },
        {
          title: '点击',
          width: 100,
          slot: 'hits'
        },
        {
          title: '操作',
          key: 'action',
          width: 130,
          align: 'left',
          render: (h, params) => {
            return h('div', [
              h('Button', {
                props: {
                  type: 'info',
                  size: 'small'
                },
                style: {
                  marginRight: '5px'
                },
                on: {
                  click: () => {
                    this.showEdit(0,params.row.id)
                  }
                }
              }, '修改'),
              h('Button', {
                props: {
                  type: 'error',
                  size: 'small'
                },
                on: {
                  click: () => {
                    this.remove(params.row.id)
                  }
                }
              }, '删除')
            ]);
          }
        }
      ],
      tablelist: [],
      selectData: [],
      showModalStatus: false,
      showEditModalStatus: false,
    }
  },
  // 组件
  components: {
      ArticleAdd,
      ArticleEdit
  },
  // 计算
  computed: {
  },
  // 监听
  watch: {
  },
  created: function() {
    // 取数据
    this.getTableList();
  },
  methods: {
    getTableList: function() {
      var self = this;
      this.$api.cate.select().then(res => {
        if (res.code == 200) {
          self.cateSelect = res.result;
        }
      });
      var starttime = self.formItem.datetime[0] != '' ? self.formItem.datetime[0].getTime() : '';
      var endtime = self.formItem.datetime[1] != '' ? self.formItem.datetime[1].getTime() : '';
      var ps = { page: this.pages.current, size: this.pages.size, 'key': self.formItem.key, 'cateid': self.formItem.cateid, 'starttime': starttime, 'endtime': endtime };
      this.$api.article.list(ps).then(res => {
        this.dataloading = false;
        if (res.code == 200) {
          self.tablelist = res.result.list;
          this.pages.total = res.result.total
          this.$Message.success(res.message);
        }
      });
      return;
    },
    changePage() {
      this.pages.current = this.$refs['listPage'].currentPage;
      this.getTableList();
    },
    // 展开添加，0打开编辑，1开loading，2 关loading，3全关闭，
    showCreate(show) {
      if (show == 0) {
        this.showModalStatus = !this.showModalStatus;
      }
      if (show == 1) {
        this.loading = true;
      }
      if (show == 2) {
        this.loading = false;
      }
      if (show == 3) {
        this.loading = false;
        this.showModalStatus = !this.showModalStatus;
        this.getTableList();
      }
    },
    // 提交创建
    articleCreate(){
      this.$refs['articleAdd'].submitAdd('articleAdd');
    },
    // 展开添加，0打开编辑，1开loading，2 关loading，3全关闭，
    showEdit(show,article_id) {
      if (show == 0) {
        this.$refs['articleEdit'].getData(article_id);
        this.showEditModalStatus = !this.showEditModalStatus;
      }
      if (show == 1) {
        this.loading = true;
      }
      if (show == 2) {
        this.loading = false;
      }
      if (show == 3) {
        this.loading = false;
        this.showEditModalStatus = !this.showEditModalStatus;
        this.getTableList();
      }
    },
    // 提交创建
    articleEdit(){
      this.$refs['articleEdit'].submitAdd('articleEdit');
    },
    remove: function(index) {
      // 弹出确认框
      this.$Modal.confirm({
        title: '警告',
        content: '<p>此操作不可恢复，三思而后行...</p>',
        onOk: () => {
          this.$api.article.remove({ article_id: index }).then(res => {
            if (res.code == 200) {
              this.$Message.success(res.message);
              this.tablelist.splice(index, 1);
              this.getTableList();
            }
          });
        }
      });
    },
    // 选择文章id
    changeData: function(index) {
      this.selectData = index
    },
    // 批量删除
    deleteData: function() {
      // 弹出确认框
      this.$Modal.confirm({
        title: '警告',
        content: '<p>此操作不可恢复，三思而后行...</p>',
        onOk: () => {
          var ids = [];
          this.selectData.forEach((item, index) => {
            ids.push(item.id);
          })
          this.$api.article.deleteall({ ids: ids }).then(res => {
            if (res.code == 200) {
              this.$Message.success(res.message);
              this.getTableList();
            }
          });
        }
      });
    },
    // 筛选
    renderTable: function(name) {
      var self = this;
      var starttime = self.formItem.datetime[0] != '' ? self.formItem.datetime[0].getTime() : '';
      var endtime = self.formItem.datetime[1] != '' ? self.formItem.datetime[1].getTime() : '';
      var ps = { page: 1, size: this.pages.size, 'key': self.formItem.key, 'cateid': self.formItem.cateid, 'starttime': starttime, 'endtime': endtime };
      this.$api.article.list(ps).then(res => {
        this.dataloading = false;
        if (res.code == 200) {
          self.tablelist = res.result.list;
          this.pages.total = res.result.total
          this.$Message.success(res.message);
        }
      });
      return;
    }
  }
}
</script>
