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
    <Drawer :mask="false" class-name="idw100" :closable="false" :mask-closable="false" :scrollable="true" title="分类管理" width="640" v-model="showModalStatus">
      <cate-add ref="cateAdd" @childChangeShow="showCreate"></cate-add>
      <div class="drawer-footer">
          <Button style="margin-right: 8px" @click="showModalStatus = false">取消</Button>
          <Button type="primary" @click="cateCreate('cateValidate')">提交</Button>
      </div>
    </Drawer>
  </div>
</template>

<script>
// import catelist from ".././data/catelist.json";
import CateAdd from './CateAdd'
export default {
  name: 'CateList',
  data() {
    return {
      dataloading: true,
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
                    this.showEdit(params.row.cate_id)
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
      cateValidate: {
                parentid: [
                    { required: true, type:'integer', message: '栏目必须填写', trigger: 'change' }
                ],
                name: [
                    { required: true, message: '名称必须填写', trigger: 'blur' }
                ],
                title: [
                    { required: true, message: '标题必须填写', trigger: 'blur' }
                ],
                describe: [
                    { required: false, message: '描述不能超过255个字符', max: 255, trigger: 'blur' }
                ],
                cate_tpl: [
                    { required: true, message: '栏目模板必须填写', trigger: 'blur' }
                ],
                art_tpl: [
                    { required: true, message: '文章模板必须填写', trigger: 'blur' }
                ],
                sort: [
                    { required: true, type: 'integer', message: '排序必须填写', trigger: 'blur' }
                ],
            },
    }
  },
  // 组件
    components: {
        CateAdd
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
        // console.log(res)
        this.dataloading = false;
        if (res.code == 200) {
          this.tablelist = res.result;
          this.$Message.success(res.message);
        }
      });
      // this.dataloading = false;
      // this.tablelist = catelist;
      // this.$Message.success("获取成功");
      return;
    },
    // 展开添加
    showCreate(parentid) {
      this.showModalStatus = !this.showModalStatus;
    },
    cateCreate(name){
      this.$refs['cateAdd'].submitAdd('articleAdd');
      // this.showModalStatus = !this.showModalStatus;
    },
    edit: function(index) {
      this.$router.push('/cate/edit/' + index);
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
