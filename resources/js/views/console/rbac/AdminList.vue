<template>
  <div class="admin-list">
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
      <Button size="small" @click="showCreate" type="success">添加管理员</Button>
    </div>
    <Table border :columns="list" ref="roleList" :data="tablelist" @on-selection-change="changeData" :loading="dataloading"></Table>
    <!-- 分页 -->
    <div class="table-page">
      <Page size="small" ref="listPage" :total="pages.total" :current="pages.current" :page-size="pages.size" show-elevator show-total @on-change="changePage"></Page>
    </div>
    <!-- 添加的弹出 -->
    <!-- 需要全屏时添加这句 :mask="false" class-name="idw100" -->
    <Drawer :closable="false" :mask-closable="false" :scrollable="true" title="添加管理员" width="640" v-model="showCreateStatus">
      <Spin size="large" fix v-if="loading"></Spin>
      <Form :label-width="80" :model="adminInfo" ref="adminCreateValidate" :rules="adminCreateValidate" action="javascript:void(0)">
        <FormItem label="部门" prop="section_id">
            <Select clearable v-model="adminInfo.section_id">
                <Option v-for="item in sectionList" :value="item.id" :key="item.id">{{ item.name }}</Option>
            </Select>
        </FormItem>
        <FormItem label="角色">
            <CheckboxGroup v-model="adminInfo.role_ids" @on-change="roleCheck">
                <Checkbox v-for="item in roleList" :key="item.id" :label="item.id">{{ item.name }}</Checkbox>
            </CheckboxGroup>
        </FormItem>
        <FormItem label="用户名" prop="name">
            <Input v-model="adminInfo.name" placeholder="输入用户名..."></Input>
        </FormItem>
        <FormItem label="姓名" prop="realname">
            <Input v-model="adminInfo.realname" placeholder="输入姓名..."></Input>
        </FormItem>
        <FormItem label="手机号">
            <Input v-model="adminInfo.phone" placeholder="输入手机号..."></Input>
        </FormItem>
        <FormItem label="邮箱">
            <Input v-model="adminInfo.email" placeholder="输入邮箱..."></Input>
        </FormItem>
        <FormItem label="密码" prop="password">
            <Input v-model="adminInfo.password" type="password" placeholder="输入密码..."></Input>
        </FormItem>
        <FormItem label="确认密码">
            <Input v-model="adminInfo.password_confirmation" type="password" placeholder="确认密码..."></Input>
        </FormItem>
        <FormItem>
          <Button style="margin-right: 8px" @click="showCreateStatus = false">取消</Button>
          <Button type="primary" @click="createAdmin('adminCreateValidate')">提交</Button>
        </FormItem>
      </Form>
    </Drawer>
    <!-- 修改资料 -->
    <Drawer :closable="false" :mask-closable="false" :scrollable="true" title="修改资料" width="640" v-model="showEditInfoStatus">
      <Spin size="large" fix v-if="loading"></Spin>
      <Form :label-width="80" :model="adminInfo" ref="adminEditValidate" :rules="adminEditValidate" action="javascript:void(0)">
          <FormItem label="部门" prop="section_id">
              <Select clearable v-model="adminInfo.section_id">
                  <Option v-for="item in sectionList" :value="item.id" :key="item.id">{{ item.name }}</Option>
              </Select>
          </FormItem>
          <FormItem label="角色">
              <CheckboxGroup v-model="adminInfo.role_ids" @on-change="roleCheck">
                  <Checkbox v-for="item in roleList" :key="item.id" :label="item.id">{{ item.name }}</Checkbox>
              </CheckboxGroup>
          </FormItem>
          <FormItem label="用户名" prop="name">
              <Input v-model="adminInfo.name" disabled placeholder="输入用户名..."></Input>
          </FormItem>
          <FormItem label="姓名" prop="realname">
              <Input v-model="adminInfo.realname" placeholder="输入姓名..."></Input>
          </FormItem>
          <FormItem label="手机号">
              <Input v-model="adminInfo.phone" placeholder="输入手机号..."></Input>
          </FormItem>
          <FormItem label="邮箱">
              <Input v-model="adminInfo.email" placeholder="输入邮箱..."></Input>
          </FormItem>
          <FormItem>
            <Button style="margin-right: 8px" @click="showEditInfoStatus = false">取消</Button>
            <Button type="primary" @click="updateAdmin('adminEditValidate')">提交</Button>
          </FormItem>
      </Form>
    </Drawer>
    <!-- 修改密码 -->
    <Drawer :closable="false" :mask-closable="false" :scrollable="true" title="修改资料" width="640" v-model="showEditPwdStatus">
      <Spin size="large" fix v-if="loading"></Spin>
      <Form :label-width="80" :model="adminPwd" ref="adminPasswordValidate" :rules="adminPasswordValidate" action="javascript:void(0)">
          <FormItem label="密码" prop="password">
              <Input v-model="adminPwd.password" type="password" placeholder="输入密码..."></Input>
          </FormItem>
          <FormItem label="确认密码">
              <Input v-model="adminPwd.password_confirmation" type="password" placeholder="确认密码..."></Input>
          </FormItem>
          <FormItem>
            <Button style="margin-right: 8px" @click="showEditPwdStatus = false">取消</Button>
            <Button type="primary" @click="updatePassword('adminPasswordValidate')">提交</Button>
          </FormItem>
      </Form>
    </Drawer>
  </div>
</template>

<script>
export default {
  name: 'AdminList',
  data() {
    return {
      loading: false,
      dataloading: true,
      admin_id: 0,
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
          title: '用户名',
          minWidth: 120,
          key: 'name'
        },
        {
          title: '姓名',
          width: 100,
          key: 'realname'
        },
        {
          title: '电话',
          width: 150,
          key: 'phone'
        },
        {
          title: '邮箱',
          width: 180,
          key: 'email'
        },
        {
          title: '最后登录时间',
          width: 180,
          key: 'lasttime'
        },
        {
          title: '最后登录IP',
          width: 120,
          key: 'lastip'
        },
        {
          title: '状态',
          key: 'status',
          width: 100,
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
                  type: 'primary',
                  size: 'small'
                },
                on: {
                  click: () => {
                    this.showEditInfo(params.row.id)
                  }
                }
              }, '修改'),
              h('Button', {
                style: {
                  marginRight: '8px'
                },
                props: {
                  type: 'warning',
                  size: 'small'
                },
                on: {
                  click: () => {
                    this.showEditPwd(params.row.id)
                  }
                }
              }, '改密'),
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
      roleList: [],
      sectionList: [],
      adminInfo: {
        section_id: 0,
        role_ids: [],
        name: '',
        realname: '',
        phone: '',
        email: '',
        password: '',
        password_confirmation: ''
      },
      adminPwd: {
        password: '',
        password_confirmation: ''
      },
      showCreateStatus: false,
      showEditInfoStatus: false,
      showEditPwdStatus: false,
      adminCreateValidate: {
        name: [
          { required: true, message: '用户名必须填写', trigger: 'blur' },
          { type: 'string', min: 2, max: 15, message: '用户名 3 - 15 位长度', trigger: 'blur' }
        ],
        realname: [
          { required: true, message: '姓名必须填写', trigger: 'blur' },
          { type: 'string', min: 2, max: 15, message: '姓名 3 - 15 位长度', trigger: 'blur' }
        ],
        section_id: [
          { required: true, message: '部门必须选择', trigger: 'change', type: 'number' }
        ],
        password: [
          { required: true, message: '密码必须填写', trigger: 'blur' },
          { type: 'string', min: 6, max: 15, message: '密码 6 - 15 位长度', trigger: 'blur' }
        ]
      },
      adminEditValidate: {
        realname: [
          { required: true, message: '姓名必须填写', trigger: 'blur' },
          { type: 'string', min: 2, max: 15, message: '姓名 3 - 15 位长度', trigger: 'blur' }
        ],
        section_id: [
          { required: true, message: '部门必须选择', trigger: 'blur', type: 'number' }
        ]
      },
      adminPasswordValidate: {
        password: [
          { required: true, message: '密码必须填写', trigger: 'blur' },
          { type: 'string', min: 6, max: 15, message: '密码 6 - 15 位长度', trigger: 'blur' }
        ]
      },
      role_ids: [],
      selectData:[],
    }
  },
  created: function() {
    // 取数据
    this.getTableList();
    this.getSectionRole();
  },
  methods: {
    changePage() {
      this.pages.current = this.$refs['listPage'].currentPage;
      this.getTableList();
    },
    // 选择id
    changeData: function(index) {
      this.selectData = index
    },
    getTableList: function() {
      var params = { page: this.pages.current,size:this.pages.size};
      this.$api.admin.list(params).then(res => {
        this.dataloading = false;
        if (res.code == 200) {
          this.tablelist = res.result.list;
          this.pages.total = res.result.count
          this.$Message.success(res.message);
        }
      });
      return;
    },
    // 获取部门及角色列表
    getSectionRole() {
      var params = { page: this.pages.current,'size':10000};
      this.$api.role.list().then(res => {
        if (res.code == 200) {
          this.roleList = res.result.list;
        }
      });
      this.$api.section.list().then(res => {
        if (res.code == 200) {
          this.sectionList = res.result.list;
        }
      });
    },
    // 展开添加
    showCreate() {
      this.showCreateStatus = !this.showCreateStatus;
      this.admin_id = 0;
      this.adminInfo = {
        section_id: 0,
        role_ids: [],
        name: '',
        realname: '',
        phone: '',
        email: '',
        password: '',
        password_confirmation: ''
      };
    },
    // 选中角色时
    roleCheck(data) {
      this.role_ids = data;
    },
    // 添加
    createAdmin(name) {
      this.$refs[name].validate((valid) => {
        if (valid) {
          this.loading = true;
          this.$api.admin.create({ section_id: this.adminInfo.section_id, role_ids: this.role_ids, name: this.adminInfo.name, realname: this.adminInfo.realname, phone: this.adminInfo.phone, email: this.adminInfo.email, password: this.adminInfo.password, password_confirmation: this.adminInfo.password_confirmation }).then(res => {
            if (res.code == 200) {
              this.adminInfo.name = '';
              this.adminInfo.section_id = 0;
              this.showCreateStatus = !this.showCreateStatus;
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
    // 展开修改
    showEditInfo(value) {
      this.admin_id = value;
      this.showEditInfoStatus = !this.showEditInfoStatus;
      this.loading = true;
      // 取信息
      this.$api.admin.detail({ admin_id: value }).then(res => {
        if (res.code == 200) {
          this.adminInfo = res.result;
          this.role_ids = res.result.role_ids;
          this.$Message.success(res.message);
        }
        this.loading = false;
      });
    },
    // 展开修改密码
    showEditPwd(value) {
      this.admin_id = value;
      this.showEditPwdStatus = !this.showEditPwdStatus;
    },
    // 修改名称
    updateAdmin: function(name) {
      this.$refs[name].validate((valid) => {
        if (valid) {
          this.loading = true;
          this.$api.admin.editinfo({ admin_id: this.admin_id, section_id: this.adminInfo.section_id, role_ids: this.role_ids, realname: this.adminInfo.realname, phone: this.adminInfo.phone, email: this.adminInfo.email }).then(res => {
            if (res.code == 200) {
              this.$Message.success(res.message);
              this.showEditInfoStatus = !this.showEditInfoStatus;
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
    // 修改密码
    updatePassword: function(name) {
      this.$refs[name].validate((valid) => {
        if (valid) {
          this.loading = true;
          this.$api.admin.editpassword({ admin_id: this.admin_id, password: this.adminPwd.password, password_confirmation: this.adminPwd.password_confirmation }).then(res => {
            if (res.code == 200) {
              this.$Message.success(res.message);
              this.showEditPwdStatus = !this.showEditPwdStatus;
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
          this.$api.admin.remove({ admin_id: [id] }).then(res => {
            if (res.code == 200) {
              this.$Message.success(res.message);
              this.tablelist.splice(index, 1);
            }
          });
        }
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
          this.$api.admin.remove({ admin_id: ids }).then(res => {
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
      this.$api.admin.status({ admin_id: index, status:value }).then(res => {
        if (res.code == 200) {
          this.$Message.success(res.message);
        }
      });
    },
    // 筛选
    renderTable: function(name) {
      this.dataloading = true;
      this.pages.current = 1;
      var ps = { 'key': this.formItem.key,'page':1,size:this.pages.size};
      this.$api.admin.list(ps).then(res => {
        if (res.code == 200) {
          this.tablelist = res.result.list;
          this.pages.total = res.result.count
          this.$Message.success(res.message);
        }
        this.dataloading = false;
      });
      return;
    }
  }
}
</script>
