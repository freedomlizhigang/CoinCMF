<template>
  <div class="menutree">
      <!-- 批量操作 -->
    <div class="action-btn">
      <Button size="small" @click="addMenu" type="success">添加一级菜单</Button>
    </div>
    <div class="menutree-left">
        <Table border height="650" ref="roleList" row-key="menu_id" :columns="list" :data="menutree" :loading="dataloading">
          <template slot-scope="{ row }" slot="sort">
            <InputNumber v-model="row.sort" size="small" :min="0" @on-change="sortDetail(row.menu_id,$event)" />
          </template>
          <template slot-scope="{ row }" slot="display">
            <Tag v-if="row.display" color="cyan">显示</Tag>
            <Tag v-if="!row.display" color="orange">隐藏</Tag>
          </template>
        </Table>
    </div>
    <!-- 需要全屏时添加这句 :mask="false" class-name="idw100" -->
    <Drawer :closable="false" :mask-closable="false" :scrollable="true" title="添加角色" width="640" v-model="showModalStatus">
      <Spin size="large" fix v-if="loading"></Spin>
      <Form ref="menuData" :model="menuData" :rules="menuValidate" action="javascript:void(0)">
        <FormItem label="父级菜单" prop="parentid">
            <Select clearable v-model="menuData.parentid">
              <Option value="0" key="0">一级菜单</Option>
              <Option v-for="item in menuSelect" :value="item.value" :key="item.value">{{ item.label }}</Option>
            </Select>
        </FormItem>
        <FormItem label="菜单名称" prop="name">
            <Input v-model="menuData.name" placeholder="请输入权限菜单名称..."></Input>
        </FormItem>
        <FormItem label="菜单URL" prop="url">
            <Input v-model="menuData.url" placeholder="请输入权限菜单URL..."></Input>
        </FormItem>
        <FormItem label="菜单标签" prop="label">
            <Input v-model="menuData.label" placeholder="请输入权限菜单标签..."></Input>
        </FormItem>
        <FormItem label="菜单图标">
            <Input v-model="menuData.icon" placeholder="请输入权限菜单图标..."></Input>
        </FormItem>
        <FormItem label="显示状态">
            <i-switch v-model="menuData.display">
                <span slot="on">显示</span>
                <span slot="off">隐藏</span>
            </i-switch>
        </FormItem>
        <FormItem label="排序">
            <InputNumber :max="9999" :min="0" v-model="menuData.sort"></InputNumber>
        </FormItem>
        <FormItem>
            <Button style="margin-right: 8px" @click="handleReset('menuData')">取消</Button>
            <Button type="primary" @click="handleSubmit('menuData')">提交</Button>
        </FormItem>
    </Form>
    </Drawer>
  </div>
</template>

<script>
export default {
  data() {
    return {
      dataloading: true,
      menuData: {
        id: 0,
        parentid: 0,
        name: '',
        url: '',
        label: '',
        icon: '',
        display: true,
        sort: 0
      },
      menuValidate: {
        name: [
          { required: true, message: '菜单名称必须填写', trigger: 'blur' }
        ],
        url: [
          { required: true, message: '菜单地址必须填写', trigger: 'blur' }
        ],
        label: [
          { required: true, message: '菜单标签必须填写', trigger: 'blur' }
        ]
      },
      menutree: [],
      list: [
        {
          title: '名称',
          minWidth: 300,
          key: 'title',
          tree: true,
        },
        {
          title: '排序',
          width: 100,
          slot: 'sort',
        },
        {
          title: '显示',
          width: 100,
          slot: 'display',
        },
        {
          title: '操作',
          key: 'action',
          width: 200,
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
                    this.append(params.row)
                  }
                }
              }, '子菜单'),
              h('Button', {
                style: {
                  marginRight: '8px',
                },
                props: {
                  type: 'info',
                  size: 'small'
                },
                on: {
                  click: () => {
                    this.detail(params.row)
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
                    this.remove(params.row)
                  }
                }
              }, '删除')
            ]);
          }
        }
      ],
      menuSelect: [],
      showModalStatus: false,
      loading: false,
    }
  },
  created: function() {
    this.getMenuTree();
  },
  methods: {
    handleSubmit(name) {
      this.$refs[name].validate((valid) => {
        if (valid) {
          this.loading = true;
          // 判断是添加还是修改
          if (this.menuData.id == 0) {
            this.$api.menu.create(this.menuData).then(res => {
              if (res.code == 200) {
                this.menuData = res.result;
                // 更新左侧的树
                this.getMenuTree();
                this.loading = false;
                this.$Message.success('添加权限菜单成功...');
                this.showModalStatus = !this.showModalStatus
              } else {
                this.loading = false;
                this.$Message.error(res.message);
              }
            });
          } else {
            this.menuData.menu_id = this.menuData.id;
            this.$api.menu.edit(this.menuData).then(res => {
              if (res.code == 200) {
                // 更新左侧的树
                this.getMenuTree();
                this.loading = false;
                this.$Message.success('修改权限菜单成功...');
                this.showModalStatus = !this.showModalStatus
              } else {
                this.loading = false;
                this.$Message.error(res.message);
              }
            });
          }
        }
      })
    },
    handleReset(name) {
      this.showModalStatus = !this.showModalStatus
      this.$refs[name].resetFields();
    },
    getMenuTree: function() {
      var self = this
      this.$api.menu.tree().then(res => {
        this.menutree = res.result
        this.dataloading = false
      });
    },
    // 单条选中
    detail(data) {
      this.showModalStatus = !this.showModalStatus
      this.$api.menu.select().then(res => {
        if (res.code == 200) {
          this.menuSelect = res.result;
        }
      });
      this.$api.menu.detail({ 'menu_id': data.menu_id }).then(res => {
        if (res.code == 200) {
          this.menuData = res.result;
          this.$Message.success('在右侧修改内容并提交...');
        } else {
          this.$Message.error(res.message);
        }
      });
    },
    // 添加
    append(data) {
      this.showModalStatus = !this.showModalStatus
      // 取到parentid，其它置空
      this.menuData = {
        id: 0,
        parentid: data.menu_id,
        name: '',
        url: '',
        label: '',
        icon: '',
        display: true,
        sort: 0
      };
    },
    // 添加一级菜单
    addMenu() {
      this.showModalStatus = !this.showModalStatus;
      // 取到parentid，其它置空
      this.menuData = {
        id: 0,
        parentid: 0,
        name: '',
        url: '',
        label: '',
        icon: '',
        display: true,
        sort: 0
      };
    },
    // 修改
    remove(data) {
      // 弹出提示
      this.$Modal.confirm({
        title: '警告',
        content: '<p>确认删除此菜单及所有下级菜单吗？</p><p>此操作不可恢复，三思而后行...</p>',
        onOk: () => {
          this.$api.menu.remove({ 'menu_id': data.menu_id }).then(res => {
            if (res.code == 200) {
              this.$Message.success(res.message);
              // 更新左侧的树
              this.getMenuTree();
            } else {
              this.$Message.error(res.message);
            }
          });
        },
        onCancel: () => {
        }
      });
    },
    sortDetail(id,value){
      this.$api.menu.sort({ menu_id: id, sort: value }).then(res => {
        if (res.code == 200) {
          this.$Message.success(res.message);
          this.getMenuTree();
        }
      });
    }
  }
}
</script>
