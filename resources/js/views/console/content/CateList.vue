<template>
  <div class="cate-list">
    <div class="right_top clearfix">
        <div class="f-r">
          <Button class="right_top_btns" to="/cate/create">添加栏目</Button>
        </div>
      </div>
    <Table border height="600" :columns="columns" ref="tableList" :data="tablelist" :loading="dataloading" class="mt10"></Table>
  </div>
</template>

<script>
import catelist from ".././data/catelist.json";
export default {
  name: 'CateList',
  data() {
    return {
      dataloading: true,
      columns: [
        {
          title: 'Id',
          key: 'id',
          width: 80,
          fixed: 'left'
        },
        {
          title: '名称',
          minWidth: 300,
          key: 'name',
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
          width: 75,
          key: 'type',
          render: (h, params) => {
            return h('span', {}, params.row.type ? '单页' : '栏目')
          }
        },
        {
          title: '外链',
          width: 75,
          key: 'link_flag',
          render: (h, params) => {
            return h('span', {}, params.row.link_flag ? '是' : '否')
          }
        },
        {
          title: '排序',
          key: 'sort',
          width: 150,
          render: (h, params) => {
            return h('div', [
              h('InputNumber', {
                props: {
                  min: 0,
                  value: params.row.sort,
                  size: 'small',
                  number: true,
                  activeChange:false
                },
                on: {
                  'on-change': (value) => {
                    this.sort(params.row.id, value)
                  }
                }
              }, '排序')
            ]);
          }
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
                    this.edit(params.row.id)
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
      cate: {
        cate_id: 0,
        parentid: 0,
        name: '',
        sort: 0
      },
      showModalStatus: false,
      cateValidate: {
        name: [
          { required: true, message: '名称必须填写', trigger: 'blur' }
        ]
      }
    }
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
      // this.$api.cate.list().then(res => {
      //   // console.log(res)
      //   this.dataloading = false;
      //   if (res.code == 200) {
      //     this.tablelist = res.result;
      //     this.$Message.success(res.message);
      //   }
      // });
      this.dataloading = false;
      this.tablelist = catelist;
      this.$Message.success("获取成功");
      return;
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
          // this.$api.cate.remove({ cate_id: id }).then(res => {
          //   if (res.code == 200) {
          //     this.$Message.success(res.message);
          //     this.getTableList();
          //   }
          // });
        }
      });
    },
    sort: function(id, sort) {
      // this.$api.cate.sort({ cate_id: id, sort: sort }).then(res => {
      //   if (res.code == 200) {
      //     this.$Message.success(res.message);
      //   }
      // });
    }
  }
}
</script>
