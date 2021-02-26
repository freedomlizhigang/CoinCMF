<template>
  <div class="type-list">
    <div class="action-btn">
      <Button size="small" @click="showCreate(0)" type="success">添加分类</Button>
    </div>
    <Table border height="650" ref="tableList" row-key="type_id" :columns="list" :data="tablelist" :loading="dataloading">
      <template slot-scope="{ row }" slot="sort">
        <InputNumber v-model="row.sort" size="small" :min="0" @on-change="sortDetail(row.type_id,$event)" />
      </template>
    </Table>
    <!-- 需要全屏时添加这句 :mask="false" class-name="idw100" -->
    <Drawer :closable="false" :mask-closable="false" :scrollable="true" title="分类管理" width="640" v-model="showModalStatus">
      <Spin size="large" fix v-if="loading"></Spin>
      <Form :label-width="80" :model="type" ref="typeValidate" :rules="typeValidate" action="javascript:void(0)">
            <FormItem label="分类名称" prop="name">
                <Input v-model="type.name" placeholder="输入分类名称..."></Input>
            </FormItem>
            <FormItem label="排序">
                <InputNumber :max="9999" :min="0" v-model="type.sort"></InputNumber>
            </FormItem>
            <FormItem>
              <Button style="margin-right: 8px" @click="showModalStatus = false">取消</Button>
              <Button type="primary" @click="typeCreateEdit('typeValidate')">提交</Button>
          </FormItem>
        </Form>
    </Drawer>
  </div>
</template>

<script>
export default {
  name: 'TypeList',
  data() {
    return {
      loading: true,
      dataloading: true,
      list: [
        {
          title: 'ID',
          key: 'type_id',
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
                  type: 'primary',
                  size: 'small'
                },
                style: {
                  marginRight: '5px'
                },
                on: {
                  click: () => {
                    this.showCreate(params.row.type_id)
                  }
                }
              }, '添加'),
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
                    this.showEdit(params.row.type_id)
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
                    this.remove(params.row.type_id)
                  }
                }
              }, '删除')
            ]);
          }
        }
      ],
      tablelist: [],
      type: {
        type_id: 0,
        parentid: 0,
        name: '',
        sort: 0
      },
      showModalStatus: false,
      typeValidate: {
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
      this.$api.type.list().then(res => {
        this.dataloading = false;
        if (res.code == 200) {
          this.tablelist = res.result;
          this.$Message.success(res.message);
        }
      });
      return;
    },
    // 展开添加
    showCreate(parentid) {
      this.showModalStatus = !this.showModalStatus;
      this.type.parentid = parentid;
      this.type.type_id = 0;
      this.type.name = '';
      this.type.sort = 0;
      this.loading = false;
    },
    // 添加||修改
    typeCreateEdit(name) {
      this.$refs[name].validate((valid) => {
        if (valid) {
          this.loading = true;
          // 判断是添加还是修改
          if (this.type.type_id === 0) {
            this.$api.type.create({ parentid: this.type.parentid, name: this.type.name, sort: this.type.sort }).then(res => {
              if (res.code == 200) {
                this.type.parentid = 0;
                this.type.type_id = 0;
                this.getTableList();
              }
              this.loading = false;
              this.$nextTick(() => { this.loading = true; });
              this.showModalStatus = !this.showModalStatus;
            }).finally(res => {
              this.loading = false;
              this.$nextTick(() => { this.loading = true; });
            });
          } else {
            this.$api.type.edit({ type_id: this.type.type_id, name: this.type.name, sort: this.type.sort }).then(res => {
              if (res.code == 200) {
                this.type.parentid = 0;
                this.type.type_id = 0;
                this.getTableList();
              }
              this.loading = false;
              this.$nextTick(() => { this.loading = true; });
              this.showModalStatus = !this.showModalStatus;
            }).finally(res => {
              this.loading = false;
              this.$nextTick(() => { this.loading = true; });
            });
          }
        } else {
          this.$Message.error('请检查输入的信息是否正确！');
          this.loading = false
          this.$nextTick(() => { this.loading = true; });
        }
      })
    },
    // 展开修改
    showEdit: function(id) {
      this.$api.type.detail({ type_id: id }).then(res => {
        if (res.code == 200) {
          this.showModalStatus = !this.showModalStatus;
          this.type = res.result;
          this.type.type_id = res.result.id;
          this.loading = false;
          // this.$nextTick(() => { this.loading = true; });
        }
      });
    },
    // 删除
    remove: function(id) {
      // 弹出确认框
      this.$Modal.confirm({
        title: '警告',
        content: '<p>此操作不可恢复，三思而后行...</p>',
        onOk: () => {
          this.$api.type.remove({ type_id: id }).then(res => {
            if (res.code == 200) {
              this.$Message.success(res.message);
              this.getTableList();
            }
          });
        }
      });
    },
    sortDetail: function(id, sort) {
      this.$api.type.sort({ type_id: id, sort: sort }).then(res => {
        if (res.code == 200) {
          this.$Message.success(res.message);
          this.getTableList();
        }
      });
    }
  }
}
</script>
