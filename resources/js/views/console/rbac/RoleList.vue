<template>
  <div class="role-list">
    <Row>
        <Col :xs="24" :sm="12">
            <Form :model="formItem" ref="formItem" :inline="true" action="javascript:void(0)">
                <FormItem>
                    <Input v-model="formItem.key" placeholder="输入关键词查找..."></Input>
                </FormItem>
                <FormItem>
                    <Button type="primary" @click="renderTable('formItem')">查找</Button>
                </FormItem>
            </Form>
        </Col>
    </Row>
    <!-- 批量操作 -->
    <div class="action-btn">
      <Button size="small" @click="deleteData" style="margin-right: 8px" type="error">批量删除</Button>
      <Button size="small" @click="showModel" type="success">添加角色</Button>
    </div>
    <Table border :columns="list" ref="roleList" :data="tablelist" @on-selection-change="changeData" :loading="dataloading"></Table>
    <!-- 分页 -->
    <div class="table-page">
      <Page size="small" ref="listPage" :total="pages.total" :current="pages.current" :page-size="pages.size" show-elevator show-total @on-change="changePage"></Page>
    </div>
    <!-- 添加的弹出 -->
    <!-- 需要全屏时添加这句 :mask="false" class-name="idw100" -->
    <Drawer :closable="false" :mask-closable="false" :scrollable="true" title="添加角色" width="640" v-model="showModalStatus">
      <Spin size="large" fix v-if="loading"></Spin>
      <Form :label-width="80" :model="role" ref="roleValidate" :rules="roleValidate" action="javascript:void(0)">
          <FormItem label="角色名称" prop="name">
              <Input v-model="role.name" placeholder="输入角色名称..."></Input>
          </FormItem>
          <FormItem label="角色状态">
              <i-switch v-model="role.status">
                  <span slot="on">正常</span>
                  <span slot="off">禁用</span>
              </i-switch>
          </FormItem>
          <FormItem>
            <Button style="margin-right: 8px" @click="showModalStatus = false">取消</Button>
            <Button type="primary" @click="createRole('roleValidate')">提交</Button>
          </FormItem>
      </Form>
    </Drawer>
    <Drawer :closable="false" :mask-closable="false" :scrollable="true" title="修改角色" width="640" v-model="showEditStatus">
      <Spin size="large" fix v-if="loading"></Spin>
      <Form :label-width="80" :model="role" ref="roleValidate" :rules="roleValidate" action="javascript:void(0)">
          <FormItem label="角色名称" prop="name">
              <Input v-model="role.name" placeholder="输入角色名称..."></Input>
          </FormItem>
          <FormItem label="角色状态">
              <i-switch v-model="role.status">
                  <span slot="on">正常</span>
                  <span slot="off">禁用</span>
              </i-switch>
          </FormItem>
          <FormItem>
            <Button style="margin-right: 8px" @click="showEditStatus = false">取消</Button>
            <Button type="primary" @click="editRole('roleValidate')">提交</Button>
          </FormItem>
      </Form>
    </Drawer>
    <!-- 权限的弹出 -->
    <Drawer :closable="false" :mask-closable="false" :scrollable="true" title="修改权限" width="640" v-model="showPrivStatus">
      <Spin size="large" fix v-if="loading"></Spin>
      <Tree :data="privTree" ref="privSelect" show-checkbox multiple></Tree>
      <div class="drawer-footer">
        <Button style="margin-right: 8px" @click="showPrivStatus = false">取消</Button>
        <Button type="primary" @click="updatePriv">提交</Button>
      </div>
    </Drawer>
  </div>
</template>

<script>
export default {
  name: 'RoleList',
  data() {
    return {
      loading: false,
      dataloading: true,
      role_id: 0,
      formItem: {
        'key': ''
      },
      pages: {
        current: 1,
        total: 0,
        size:10
      },
      list: [
        {
            type: 'selection',
            width: 60,
            align: 'center'
        },
        {
          title: 'Id',
          key: 'id',
          width: 60,
        },
        {
          title: '名称',
          minWidth: 300,
          key: 'name'
        },
        {
          title: '状态',
          key: 'status',
          width: 150,
          render: (h, params) => {
            return h('div', [
              h('i-switch', {
                props: {
                  value: params.row.status // 控制开关的打开或关闭状态，官网文档属性是value
                },
                on: {
                  'on-change': (value) => {
                    this.changeStatus(params.row.id, value)
                  }
                }
              }, '开关')
            ]);
          }
        },
        {
          title: '操作',
          key: 'action',
          width: 190,
          align: 'left',
          render: (h, params) => {
            return h('div', [
              h('Button', {
                style: {
                  marginRight: '8px'
                },
                props: {
                  type: 'info',
                  size: 'small'
                },
                on: {
                  click: () => {
                    this.showEditModal(params.row.id)
                  }
                }
              }, '修改'),
              h('Button', {
                style: {
                  marginRight: '8px'
                },
                props: {
                  type: 'primary',
                  size: 'small'
                },
                on: {
                  click: () => {
                    this.showPrivModal(params.row.id)
                  }
                }
              }, '权限'),
              h('Button', {
                props: {
                  type: 'error',
                  size: 'small'
                },
                on: {
                  click: () => {
                    this.remove(params.index, params.row.id)
                  }
                }
              }, '删除')
            ]);
          }
        }
      ],
      tablelist: [],
      role: {
        name: '',
        status: true
      },
      showEditStatus: false,
      showModalStatus: false,
      showPrivStatus: false,
      roleValidate: {
        name: [
          { required: true, message: '角色名称必须填写', trigger: 'blur' }
        ]
      },
      privTree: [],
      selectData: [],
    }
  },
  created: function() {
    // 取数据
    this.getTableList();
  },
  methods: {
    changePage() {
      this.pages.current = this.$refs['listPage'].currentPage;
      this.getTableList();
    },
    getTableList: function() {
      var params = { page: this.pages.current};
      this.$api.role.list(params).then(res => {
        this.dataloading = false;
        if (res.code == 200) {
          this.tablelist = res.result.list;
          this.pages.total = res.result.count
          this.$Message.success(res.message);
        }
      });
      return;
    },
    // 选择id
    changeData: function(index) {
      this.selectData = index
    },
    // 展开添加
    showModel() {
      this.showModalStatus = !this.showModalStatus;
      this.role_id = 0
      this.role = {
        name: '',
        status: true
      }
    },
    showEditModal(value) {
      this.role_id = value;
      this.showEditStatus = !this.showEditStatus;
      // 取树形菜单
      this.$api.role.detail({ role_id: value }).then(res => {
        if (res.code == 200) {
          this.role.name = res.result.name;
          this.role.status = res.result.status;
          this.$Message.success(res.message);
        }
      });
    },
    showPrivModal(value) {
      this.role_id = value;
      this.showPrivStatus = !this.showPrivStatus;
      // 取树形菜单
      this.$api.role.priv({ role_id: value }).then(res => {
        if (res.code == 200) {
          this.privTree = res.result;
          this.$Message.success(res.message);
        }
      });
    },
    // 添加
    createRole(name) {
      this.$refs[name].validate((valid) => {
        if (valid) {
          this.loading = true
          this.$api.role.create({ name: this.role.name, status: this.role.status }).then(res => {
            if (res.code == 200) {
              this.showModalStatus = !this.showModalStatus;
              this.role.name = '';
              this.getTableList();
            }
          });
          this.loading = false
        } else {
          this.$Message.error('请检查输入的信息是否正确！');
          this.loading = false
        }
      })
    },
    // 修改名称
    editRole: function(name) {
      this.$refs[name].validate((valid) => {
        if (valid) {
          this.loading = true;
          this.$api.role.edit({ role_id: this.role_id, name: this.role.name, status: this.role.status }).then(res => {
            if (res.code == 200) {
              this.$Message.success(res.message);
              this.showEditStatus = !this.showEditStatus;
              this.getTableList();
            }
            this.loading = false;
          }).finally(res => {
            this.loading = false;
          });
        } else {
          this.$Message.error('请检查输入的信息是否正确！');
          this.loading = false
        }
      })
    },
    // 删除
    remove: function(index, id) {
      // 弹出确认框
      this.$Modal.confirm({
        title: '警告',
        content: '<p>此操作不可恢复，三思而后行...</p>',
        onOk: () => {
          this.$api.role.remove({ role_id: [id] }).then(res => {
            if (res.code == 200) {
              this.$Message.success(res.message);
              this.tablelist.splice(index, 1);
            }
          });
        }
      });
    },
    // 修改状态
    changeStatus: function(index, value) {
      this.$api.role.status({ role_id: index, status: value }).then(res => {
        if (res.code == 200) {
          this.$Message.success(res.message);
        }
      });
    },
    // 筛选
    renderTable: function(name) {
      this.dataloading = true;
      this.pages.currentPage = 1;
      var ps = { 'key': this.formItem.key,'page':1 };
      this.$api.role.list(ps).then(res => {
        this.dataloading = false;
        if (res.code == 200) {
          this.tablelist = res.result.list;
          this.pages.total = res.result.count
          this.$Message.success(res.message);
        }
      });
      return;
    },
    updatePriv: function() {
      this.loading = true
      var node = this.$refs['privSelect'].getCheckedAndIndeterminateNodes()
      var menu_id = [];
      node.forEach((item, index) => {
        menu_id.push(item.menu_id)
      });
      // 提交
      this.$api.role.updatepriv({ role_id: this.role_id, menu_id: menu_id }).then(res => {
        if (res.code == 200) {
          this.$Message.success(res.message);
        }
        this.loading = false
        this.showPrivStatus = !this.showPrivStatus;
      });
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
          this.$api.role.remove({ role_id: ids }).then(res => {
            if (res.code == 200) {
              this.$Message.success(res.message);
              this.getTableList();
            }
          });
        }
      });
    },
  }
}
</script>
