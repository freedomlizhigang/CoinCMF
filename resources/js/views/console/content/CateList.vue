<template>
  <div class="cate-list">
    <div class="action-btn">
      <Button size="small" @click="showCreate(0)" type="success">添加分类</Button>
    </div>
    <Table border height="650" ref="tableList" row-key="cate_id" :columns="list" :data="tablelist" :loading="dataloading">
      <template slot-scope="{ row }" slot="type">
        <Tag v-if="row.type" color="purple">单页</Tag>
        <Tag v-if="!row.type" color="blue">栏目</Tag>
      </template>
      <template slot-scope="{ row }" slot="link_flag">
        <Tag v-if="row.link_flag" color="cyan">是</Tag>
        <Tag v-if="!row.link_flag" color="orange">否</Tag>
      </template>
      <template slot-scope="{ row }" slot="sort">
        <InputNumber v-model="row.sort" size="small" :min="0" @on-change="sortDetail(row.cate_id,$event)" />
      </template>
    </Table>
    <!-- 需要全屏时添加这句 :mask="false" class-name="idw100" -->
    <Drawer :mask="false" class-name="idw100" :closable="false" :mask-closable="false" :scrollable="true" title="添加分类" width="640" v-model="showModalStatus">
      <cate-add ref="cateAdd" @showCreate="showCreate($event)"></cate-add>
      <div class="drawer-footer">
          <Button style="margin-right: 8px" @click="showModalStatus = false">取消</Button>
          <Button type="primary" :loading="loading" @click="cateCreate()">提交</Button>
      </div>
    </Drawer>
    <Drawer :mask="false" class-name="idw100" :closable="false" :mask-closable="false" :scrollable="true" title="修改分类" width="640" v-model="showEditModalStatus">
      <cate-edit ref="cateEdit" @showEdit="showEdit($event)"></cate-edit>
      <div class="drawer-footer">
          <Button style="margin-right: 8px" @click="showEditModalStatus = false">取消</Button>
          <Button type="primary" :loading="loading" @click="cateEdit()">提交</Button>
      </div>
    </Drawer>
  </div>
</template>

<script>
// import catelist from ".././data/catelist.json";
import CateAdd from './CateAdd'
import CateEdit from './CateEdit'
export default {
  name: 'CateList',
  data() {
    return {
      dataloading: true,
      loading:false,
      list: [
        {
          title: 'ID',
          key: 'cate_id',
          width: 60,
        },
        {
          title: '名称',
          minWidth: 300,
          key: 'name',
          tree: true,
          render: (h, params) => {
            return h('span', {
              style: {
                marginLeft: params.row.left + 'px'
              }
            }, params.row.name)
          }
        },
        {
          title: '类型',
          slot: 'type',
          width: 100,
        },
        {
          title: '外链',
          slot: 'link_flag',
          width: 100,
        },
        {
          title: '排序',
          slot: 'sort',
          width: 150,
        },
        {
          title: '操作',
          key: 'action',
          width: 180,
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
                    this.showEdit(0,params.row.cate_id)
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
                    this.remove(params.row.cate_id)
                  }
                }
              }, '删除')
            ]);
          }
        }
      ],
      tablelist: [],
      cate: {
        cate_id: 0,
        parentid: 0,
        name: '',
        sort: 0
      },
      showModalStatus: false,
      showEditModalStatus: false,
    }
  },
  // 组件
    components: {
        CateAdd,
        CateEdit
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
      this.$api.cate.list().then(res => {
        this.dataloading = false;
        if (res.code == 200) {
          this.tablelist = res.result;
          this.$Message.success(res.message);
        }
      });
      return;
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
    cateCreate(){
      this.$refs['cateAdd'].submitAdd('cateAdd');
    },
    // 展开添加，0打开编辑，1开loading，2 关loading，3全关闭，
    showEdit(show,cate_id) {
      if (show == 0) {
        this.$refs['cateEdit'].getData(cate_id);
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
    cateEdit(){
      this.$refs['cateEdit'].submitAdd('cateEdit');
    },
    // 删除
    remove: function(id) {
      // 弹出确认框
      this.$Modal.confirm({
        title: '警告',
        content: '<p>此操作不可恢复，三思而后行...</p>',
        onOk: () => {
          this.$api.cate.remove({ cate_id: id }).then(res => {
            if (res.code == 200) {
              this.$Message.success(res.message);
              this.getTableList();
            }
          });
        }
      });
    },
    sortDetail: function(id, sort) {
      this.$api.cate.sort({ cate_id: id, sort: sort }).then(res => {
        if (res.code == 200) {
          this.$Message.success(res.message);
          this.getTableList();
        }
      });
    }
  }
}
</script>
