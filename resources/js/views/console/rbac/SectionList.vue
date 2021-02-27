<template>
  <div class="section-list">
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
      <Button size="small" @click="showModel" type="success">添加部门</Button>
    </div>
    <Table border :columns="list" :data="tablelist" ref="sectionList" @on-selection-change="changeData" :loading="dataloading"></Table>
    <!-- 分页 -->
    <div class="table-page">
      <Page size="small" ref="listPage" :total="pages.total" :current="pages.current" :page-size="pages.size" show-elevator show-total @on-change="changePage"></Page>
    </div>
    <!-- 添加的弹出 -->
    <!-- 需要全屏时添加这句 :mask="false" class-name="idw100" -->
    <Drawer :closable="false" :mask-closable="false" :scrollable="true" title="添加部门" width="640" v-model="showModalStatus">
      <Spin size="large" fix v-if="loading"></Spin>
      <Form :label-width="80" :model="section" ref="sectionValidate" :rules="sectionValidate" action="javascript:void(0)">
            <FormItem label="部门名称" prop="name">
                <Input v-model="section.name" placeholder="输入部门名称..."></Input>
            </FormItem>
            <FormItem label="部门状态">
                <i-switch v-model="section.status">
                    <span slot="on">正常</span>
                    <span slot="off">禁用</span>
                </i-switch>
            </FormItem>
            <FormItem>
              <Button style="margin-right: 8px" @click="showModalStatus = false">取消</Button>
              <Button type="primary" @click="createSection('sectionValidate')">提交</Button>
            </FormItem>
        </Form>
    </Drawer>
    <Drawer :closable="false" :mask-closable="false" :scrollable="true" title="修改部门" width="640" v-model="showEditStatus">
      <Spin size="large" fix v-if="loading"></Spin>
      <Form :label-width="80" :model="section" ref="sectionValidate" :rules="sectionValidate" action="javascript:void(0)">
          <FormItem label="部门名称" prop="name">
              <Input v-model="section.name" placeholder="输入部门名称..."></Input>
          </FormItem>
          <FormItem label="部门状态">
              <i-switch v-model="section.status">
                  <span slot="on">正常</span>
                  <span slot="off">禁用</span>
              </i-switch>
          </FormItem>
          <FormItem>
            <Button style="margin-right: 8px" @click="showEditStatus = false">取消</Button>
            <Button type="primary" @click="editName('sectionValidate')">提交</Button>
          </FormItem>
      </Form>
    </Drawer>
  </div>
</template>

<script>
export default {
  name: 'SectionList',
  data() {
    return {
      loading: true,
      dataloading: true,
      formItem: {
        'key': ''
      },
      pages: {
        current: 1,
        total: 0,
        size: 10,
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
          width: 150,
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
      section: {
        name: '',
        status: true
      },
      showModalStatus: false,
      showEditStatus: false,
      sectionValidate: {
        name: [
          { required: true, message: '部门名称必须填写', trigger: 'blur' }
        ]
      },
      selectData:[],
      section_id:0,
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
      this.$api.section.list(params).then(res => {
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
      this.section = {
        name: '',
        status: true
      };
      this.section_id = 0;
    },
    // 添加
    createSection(name) {
      this.$refs[name].validate((valid) => {
        if (valid) {
          this.loading = true;
          this.$api.section.create({ name: this.section.name, status: this.section.status }).then(res => {
            if (res.code == 200) {
              this.section.name = '';
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
      this.section_id = value;
      this.showEditStatus = !this.showEditStatus;
      // 取树形菜单
      this.$api.section.detail({ section_id: value }).then(res => {
        if (res.code == 200) {
          this.loading = false;
          this.section.name = res.result.name;
          this.section.status = res.result.status;
          this.$Message.success(res.message);
        }
      });
    },
    // 修改名称
    editName: function(name) {
      this.$refs[name].validate((valid) => {
        if (valid) {
          this.loading = true;
          this.$api.section.edit({ section_id: this.section_id, name: this.section.name, status: this.section.status }).then(res => {
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
          this.$api.section.remove({ section_id: [id] }).then(res => {
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
          this.$api.section.remove({ section_id: ids }).then(res => {
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
      this.$api.section.status({ section_id: index, status: value }).then(res => {
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
      this.$api.section.list(ps).then(res => {
        this.dataloading = false;
        if (res.code == 200) {
          this.tablelist = res.result.list;
          this.pages.total = res.result.count
          this.$Message.success(res.message);
        }
      });
      return;
    }
  }
}
</script>
