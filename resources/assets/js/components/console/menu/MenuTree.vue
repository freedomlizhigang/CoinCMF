<template>
    <div class="menutree">
        <Row>
            <Col :xs="24" :sm="7">
            <div class="menutree-left">
                <Button type="default" long @click="addMenu()">添加一级菜单</Button>
                <Tree :data="menutree" ref="menutree" :render="renderMenu" class="mt10"></Tree>
            </div>
            </Col>
            <Col :xs="24" :sm="1" class="menutree-border"></Col>
            <Col :xs="24" :sm="16">
                <Form ref="menuData" :model="menuData" :rules="menuValidate">
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
                        <Button type="primary" @click="handleSubmit('menuData')">提交</Button>
                        <Button style="margin-left: 8px" @click="handleReset('menuData')">重置</Button>
                    </FormItem>
                </Form>
            </Col>
        </Row>
    </div>
</template>

<style>
    .menutree-left {
        max-height: 70vh;
        overflow-y: auto;
        overflow-x: hidden;
    }
    .menutree-border {
        border-left: #EEEEEE dashed 1px;
        height: 100vh;
    }
</style>

<script>
    export default {
        data () {
            return {
                menuData:{
                    id:0,
                    parentid:0,
                    name:'',
                    url:'',
                    label:'',
                    icon:'',
                    display:true,
                    sort:0
                },
                menuValidate: {
                    name: [
                        { required: true, message: '菜单名称必须填写', trigger: 'blur' }
                    ],
                    url: [
                        { required: true, message: '菜单地址必须填写', trigger: 'blur' },
                    ],
                    label: [
                        { required: true, message: '菜单标签必须填写', trigger: 'blur' }
                    ]
                },
                menutree: [],
                btnDetail: {
                    type: 'info',
                    size: 'small',
                },
                btnEdit: {
                    type: 'primary',
                    size: 'small',
                },
                btnRemove: {
                    type: 'default',
                    size: 'small',
                }
            }
        },
        created:function(){
          this.getMenuTree();
        },
        methods: {
            handleSubmit(name) {
                this.$refs[name].validate((valid) => {
                    if (valid) {
                        // 判断是添加还是修改
                        if (this.menuData.id == 0) {
                            this.$api.menu.create(this.menuData).then(res=>{
                                if (res.code == 200) {
                                    this.menuData = res.data;
                                    // 更新左侧的树
                                    this.getMenuTree();
                                    this.$Message.success('添加权限菜单成功...');
                                }
                                else
                                {
                                    this.$Message.error(res.msg);
                                }
                            });
                        }
                        else
                        {
                            console.log(this.menuData)
                            this.$api.menu.edit(this.menuData).then(res=>{
                                if (res.code == 200) {
                                    // 更新左侧的树
                                    this.getMenuTree();
                                    this.$Message.success('修改权限菜单成功...');
                                }
                                else
                                {
                                    this.$Message.error(res.msg);
                                }
                            });
                        }
                    }
                })
            },
            handleReset(name) {
                this.$refs[name].resetFields();
            },
            getMenuTree:function(){
                var self = this
                this.$api.menu.tree().then(res=>{
                  this.menutree = res.data
                });
            },
            // 追加一个添加子栏目的按钮，和删除子栏目的按钮
            renderMenu (h, { root, node, data }) {
                return h('span', {
                    style: {
                        display: 'inline-block',
                        width: '100%'
                    }
                }, [
                    h('span', [
                        h('Icon', {
                            props: {
                                type: 'ios-paper-outline'
                            },
                            style: {
                                marginRight: '8px'
                            }
                        }),
                        h('span', data.title)
                    ]),
                    h('span', {
                        style: {
                            display: 'inline-block',
                            float: 'right',
                            marginRight: '32px'
                        }
                    }, [
                        h('Button', {
                            props: Object.assign({}, this.btnDetail, {
                                icon: 'ios-build-outline'
                            }),
                            style: {
                                marginRight: '8px'
                            },
                            on: {
                                click: () => { this.detail(data) }
                            }
                        }),
                        h('Button', {
                            props: Object.assign({}, this.btnEdit, {
                                icon: 'ios-add'
                            }),
                            style: {
                                marginRight: '8px'
                            },
                            on: {
                                click: () => { this.append(data) }
                            }
                        }),
                        h('Button', {
                            props: Object.assign({}, this.btnRemove, {
                                icon: 'ios-remove'
                            }),
                            on: {
                                click: () => { this.remove(root, node, data) }
                            }
                        })
                    ])
                ]);
            },
            // 单条选中
            detail (data) {
                this.$api.menu.detail({'menu_id':data.menu_id}).then(res=>{
                    if (res.code == 200) {
                        this.menuData = res.data;
                        this.$Message.success('在右侧修改内容并提交...');
                    }
                    else
                    {
                        this.$Message.error(res.msg);
                    }
                });
            },
            // 添加
            append (data) {
                // 取到parentid，其它置空
                this.menuData = {
                    id:0,
                    parentid:data.menu_id,
                    name:'',
                    url:'',
                    label:'',
                    icon:'',
                    display:true,
                    sort:0
                };
                this.$Message.success('在右侧输入内容并提交...');
            },
            // 添加一级菜单
            addMenu() {
                // 取到parentid，其它置空
                this.menuData = {
                    id:0,
                    parentid:0,
                    name:'',
                    url:'',
                    label:'',
                    icon:'',
                    display:true,
                    sort:0
                };
                this.$Message.success('在右侧输入内容并提交...');
            },
            // 修改
            remove (root, node, data) {
                // 弹出提示
                this.$Modal.confirm({
                    title: '警告',
                    content: '<p>确认删除此菜单及所有下级菜单吗？</p><p>此操作不可恢复，三思而后行...</p>',
                    onOk: () => {
                        this.$api.menu.remove({'menu_id':data.menu_id}).then(res=>{
                            if(res.code == 200)
                            {
                                // 更新左侧的树
                                this.getMenuTree();
                            }
                            else
                            {
                                this.$Message.error(res.msg);
                            }
                        });
                    },
                    onCancel: () => {
                    }
                });
            },
        }
    }
</script>