<template>
  <div class="department-list">
    <!-- 批量操作 -->
    <div class="action-btn">
      <Button size="small" @click="showModel" type="success">添加部门</Button>
    </div>
    <Table border height="650" ref="departmentList" row-key="department_id" :columns="list" :data="tablelist" :loading="dataloading"></Table>
    <!-- 添加的弹出 -->
    <!-- 需要全屏时添加这句 :mask="false" class-name="idw100" -->
    <Drawer :closable="false" :mask-closable="false" :scrollable="true" title="添加部门" width="640" v-model="showModalStatus">
      <Spin size="large" fix v-if="loading"></Spin>
      <Form :label-width="80" :model="department" ref="departmentValidate" :rules="departmentValidate" action="javascript:void(0)">
            <FormItem label="上级部门" prop="parentid">
                <Select clearable v-model="department.parentid">
                  <Option value="0" key="0">一级部门</Option>
                  <Option v-for="item in departmentSelect" :value="item.id" :key="item.id">{{ item.name }}</Option>
                </Select>
            </FormItem>
            <FormItem label="部门名称" prop="name">
                <Input v-model="department.name" placeholder="输入部门名称..."></Input>
            </FormItem>
            <FormItem label="部门状态">
                <i-switch v-model="department.status">
                    <span slot="on">正常</span>
                    <span slot="off">禁用</span>
                </i-switch>
            </FormItem>
            <FormItem>
              <Button style="margin-right: 8px" @click="showModalStatus = false">取消</Button>
              <Button type="primary" @click="createDepartment('departmentValidate')">提交</Button>
            </FormItem>
        </Form>
    </Drawer>
    <Drawer :closable="false" :mask-closable="false" :scrollable="true" title="修改部门" width="640" v-model="showEditStatus">
      <Spin size="large" fix v-if="loading"></Spin>
      <Form :label-width="80" :model="department" ref="departmentValidate" :rules="departmentValidate" action="javascript:void(0)">
          <FormItem label="上级部门" prop="parentid">
              <Select clearable v-model="department.parentid">
                <Option value="0" key="0">一级部门</Option>
                <Option v-for="item in departmentSelect" :value="item.id" :key="item.id">{{ item.name }}</Option>
              </Select>
          </FormItem>
          <FormItem label="部门名称" prop="name">
              <Input v-model="department.name" placeholder="输入部门名称..."></Input>
          </FormItem>
          <FormItem label="部门状态">
              <i-switch v-model="department.status">
                  <span slot="on">正常</span>
                  <span slot="off">禁用</span>
              </i-switch>
          </FormItem>
          <FormItem>
            <Button style="margin-right: 8px" @click="showEditStatus = false">取消</Button>
            <Button type="primary" @click="editName('departmentValidate')">提交</Button>
          </FormItem>
      </Form>
    </Drawer>
    <!-- 用户弹出 -->
    <Drawer :closable="false" :mask-closable="false" :scrollable="true" title="修改权限" width="640" v-model="showAdminStatus">
      <Spin size="large" fix v-if="loading"></Spin>
      <Table border :columns="adminTableList" ref="adminList" :data="adminlist" :loading="dataloading"></Table>
      <div class="drawer-footer">
        <Button style="margin-right: 8px" @click="showAdminStatus = false">关闭</Button>
      </div>
    </Drawer>
  </div>
</template>

<script>
export default {
  name: 'DepartmentList',
  data() {
    return {
      loading: true,
      dataloading: true,
      list: [
        {
            title: 'Id',
            key: 'department_id',
            width: 60,
        },
        {
          title: '名称',
          minWidth: 300,
          key: 'title',
          tree: true,
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
                    this.changeStatus(params.row.department_id, value)
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
                  type: 'success',
                  size: 'small'
                },
                on: {
                  click: () => {
                    this.showAdmin(params.row.department_id)
                  }
                }
              }, '用户'),
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
                    this.showEditModal(params.row.department_id)
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
                    this.remove(params.index, params.row.department_id)
                  }
                }
              }, '删除')
            ]);
          }
        }
      ],
      tablelist: [],
      department: {
        parentid:0,
        name: '',
        status: true
      },
      showModalStatus: false,
      showEditStatus: false,
      showAdminStatus: false,
      departmentValidate: {
        name: [
          { required: true, message: '部门名称必须填写', trigger: 'blur' }
        ]
      },
      department_id:0,
      departmentSelect:[],
      adminlist:[],
      adminTableList:[
        {
          title: '用户名',
          key: 'name'
        },
        {
          title: '手机号',
          key: 'phone'
        },
        {
          title: '操作',
          key: 'action',
          width: 80,
          align: 'left',
          render: (h, params) => {
            return h('div', [
              h('Button', {
                props: {
                  type: 'error',
                  size: 'small'
                },
                on: {
                  click: () => {
                    this.removeAdmin(params.index, params.row.id)
                  }
                }
              }, '移出')
            ]);
          }
        }
      ],
    }
  },
  created: function() {
    // 取数据
    this.getTableList();
  },
  methods: {
    getTableList: function() {
      this.$api.department.tree().then(res => {
        this.dataloading = false;
        if (res.code == 200) {
          this.tablelist = res.result
          this.$Message.success(res.message);
        }
      });
      return;
    },
    // 展开添加
    showModel() {
      this.showModalStatus = !this.showModalStatus;
      this.department = {
        parentid:0,
        name: '',
        status: true
      };
      this.department_id = 0;
      this.$api.department.select().then(res => {
        if (res.code == 200) {
          this.departmentSelect = res.result;
        }
        this.loading = false;
      });
    },
    // 添加
    createDepartment(name) {
      this.$refs[name].validate((valid) => {
        if (valid) {
          this.loading = true;
          this.$api.department.create({parentid: this.department.parentid, name: this.department.name, status: this.department.status }).then(res => {
            if (res.code == 200) {
              this.department.name = '';
              this.getTableList();
            }
            this.loading = false;
            this.showModalStatus = !this.showModalStatus;
          });
        } else {
          this.$Message.error('请检查输入的信息是否正确！');
          this.loading = false
        }
      })
    },
    showEditModal(value) {
      this.department_id = value;
      this.showEditStatus = !this.showEditStatus;
      // 取树形菜单
      this.$api.department.detail({ department_id: value }).then(res => {
        if (res.code == 200) {
          this.department.name = res.result.name;
          this.department.parentid = res.result.parentid;
          this.department.status = res.result.status;
          this.$Message.success(res.message);
        }
      });
      this.$api.department.select().then(res => {
        if (res.code == 200) {
          this.departmentSelect = res.result;
        }
        this.loading = false;
      });
    },
    // 修改名称
    editName: function(name) {
      this.$refs[name].validate((valid) => {
        if (valid) {
          this.loading = true;
          this.$api.department.edit({ parentid: this.department.parentid, department_id: this.department_id, name: this.department.name, status: this.department.status }).then(res => {
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
          this.$api.department.remove({ department_id: id }).then(res => {
            if (res.code == 200) {
              this.$Message.success(res.message);
              this.getTableList();
            }
          });
        }
      });
    },
    // 修改状态
    changeStatus: function(index, value) {
      this.$api.department.status({ department_id: index, status: value }).then(res => {
        if (res.code == 200) {
          this.$Message.success(res.message);
        }
      });
    },
    showAdmin: function(id){
      this.showAdminStatus = !this.showAdminStatus;
      this.$api.department.adminlist({department_id:id}).then(res => {
        this.dataloading = false;
        this.loading = false;
        if (res.code == 200) {
          this.adminlist = res.result;
          this.$Message.success(res.message);
        }
      });
      return;
    },
    // 删除
    removeAdmin: function(index, id) {
      // 弹出确认框
      this.$Modal.confirm({
        title: '警告',
        content: '<p>此操作不可恢复，三思而后行...</p>',
        onOk: () => {
          this.$api.department.removeadmin({ admin_id: id }).then(res => {
            if (res.code == 200) {
              this.$Message.success(res.message);
              this.adminlist.splice(index, 1);
            }
          });
        }
      });
    },
  }
}
</script>
