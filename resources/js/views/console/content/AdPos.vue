<template>
<div class="adpos-list">
    <Form :model="formItem" ref="formItem" :inline="true" action="javascript:void(0)">
        <FormItem>
            <Input v-model="formItem.key" placeholder="输入关键词查找..."></Input>
        </FormItem>
        <FormItem>
            <Button type="primary" @click="renderTable('formItem')">查找</Button>
        </FormItem>
    </Form>
    <div class="action-btn">
        <Button size="small" @click="deleteData" style="margin-right: 8px" type="error">批量删除</Button>
        <Button size="small" @click="showModel" type="success">添加广告位</Button>
    </div>
    <Table border ref="adposlist" :columns="list" :data="tablelist" :loading="dataloading" @on-selection-change="changeData">
        <template slot-scope="{ row }" slot="is_mobile">
            <Tag color="green" v-if="row.is_mobile">手机</Tag>
            <Tag color="blue" v-if="row.is_mobile == false">电脑</Tag>
        </template>
        <template slot-scope="{ row, index }" slot="action">
            <Button type="info" size="small" style="margin-right: 5px;float:left" @click="showEditAdpos(row.id)">编辑</Button>
            <Button type="error" size="small" @click="remove(index,row.id)">删除</Button>
        </template>
    </Table>
    <!-- 分页 -->
    <div class="table-page">
        <Page size="small" ref="listPage" :total="pages.total" :current="pages.current" :page-size="pages.size" show-elevator show-total @on-change="changePage"></Page>
    </div>
    <!-- 添加的弹出 -->
    <!-- 需要全屏时添加这句 :mask="false" class-name="idw100" -->
    <Drawer :closable="false" :mask-closable="false" :scrollable="true" title="添加广告位" width="640" v-model="showModalStatus">
        <Spin size="large" fix v-if="loading"></Spin>
        <Form :model="adpos" ref="adposValidate" label-position="right" :label-width="80" :rules="adposValidate" action="javascript:void(0)">
            <FormItem label="名称" prop="name">
                <Input v-model="adpos.name" placeholder="输入名称..."></Input>
            </FormItem>
            <FormItem label="手机">
                <i-switch v-model="adpos.is_mobile">
                    <span slot="on">是</span>
                    <span slot="off">否</span>
                </i-switch>
            </FormItem>
            <FormItem>
                <Button style="margin-right: 8px" @click="showModalStatus = false">取消</Button>
                <Button type="primary" @click="createAdpos('adposValidate')">提交</Button>
            </FormItem>
        </Form>
    </Drawer>
    <!-- 修改的弹出 -->
    <Drawer :closable="false" :mask-closable="false" :scrollable="true" title="修改广告位" width="640" v-model="showEditModalStatus">
        <Spin size="large" fix v-if="loading"></Spin>
        <Form :model="adpos" ref="adposValidate" label-position="right" :label-width="80" :rules="adposValidate" action="javascript:void(0)">
            <FormItem label="名称" prop="name">
                <Input v-model="adpos.name" placeholder="输入名称..."></Input>
            </FormItem>
            <FormItem label="手机">
                <i-switch v-model="adpos.is_mobile">
                    <span slot="on">是</span>
                    <span slot="off">否</span>
                </i-switch>
            </FormItem>
            <FormItem>
                <Button style="margin-right: 8px" @click="showEditModalStatus = false">取消</Button>
                <Button type="primary" @click="editAdpos('adposValidate')">提交</Button>
            </FormItem>
        </Form>
    </Drawer>
</div>
</template>

<script>
export default {
    name: 'AdPos',
    data() {
        return {
        adpos_id:0,
        loading: false,
        dataloading: true,
        formItem: {
            'key': ''
        },
        pages: {
            current: 1,
            total: 0,
            size: 10
        },
        list: [
            {
                type: 'selection',
                width: 60,
                align: 'center',
            },
            {
                title: 'Id',
                key: 'id',
                width: 60,
            },
            {
                title: '名称',
                minWidth: 300,
                key: 'name',
            },
            {
                title: '类型',
                slot: 'is_mobile',
                width: 90
            },
            {
                title: '操作',
                slot: 'action',
                width: 130,
            }
        ],
        tablelist: [],
        adpos: {
            name: '',
            is_mobile: false,
        },
        showModalStatus: false,
        showEditModalStatus:false,
        adposValidate: {
            name: [
                { required: true, message: '名称必须填写', trigger: 'blur' }
            ]
        },
        selectData: []
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
            this.$api.adpos.list(params).then(res => {
                this.dataloading = false;
                if (res.code == 200) {
                    this.tablelist = res.result.list;
                    this.pages.total = res.result.count
                    this.$Message.success(res.message);
                }
            });
            return;
        },
        // 选择文章id
        changeData: function(index) {
            this.selectData = index
        },
        // 展开添加
        showModel() {
            this.showModalStatus = !this.showModalStatus;
            this.adpos.name = '';
            this.adpos.is_mobile = false;
        },
        // 添加
        createAdpos(name) {
            this.$refs[name].validate((valid) => {
                this.loading = true;
                if (valid) {
                    this.$api.adpos.create(this.adpos).then(res => {
                        if (res.code == 200) {
                            this.getTableList();
                            this.showModalStatus = !this.showModalStatus;
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
        showEditAdpos:function(id){
            this.adpos_id = id;
            this.loading = true;
            this.$api.adpos.detail({adpos_id:id}).then(res => {
                if (res.code == 200) {
                    this.adpos = res.result
                }
                this.loading = false;
            })
            this.showEditModalStatus = true;
        },
        editAdpos:function(name){
            this.$refs[name].validate((valid) => {
                this.loading = true;
                if (valid) {
                    this.adpos.adpos_id = this.adpos_id
                    this.$api.adpos.edit(this.adpos).then(res => {
                        if (res.code == 200) {
                            this.getTableList();
                            this.showEditModalStatus = !this.showEditModalStatus;
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
                    this.$api.adpos.remove({ adpos_id: [id] }).then(res => {
                        if (res.code == 200) {
                            this.$Message.success(res.message);
                            this.tablelist.splice(index, 1);
                        }
                    });
                }
            });
        },
        sort:function (id,value) {
            this.$api.adpos.sort({ adpos_id: id,sort:value }).then(res => {
                if (res.code == 200) {
                    this.$Message.success(res.message);
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
                this.$api.adpos.remove({ adpos_id: ids }).then(res => {
                    if (res.code == 200) {
                    this.$Message.success(res.message);
                    this.getTableList();
                    }
                });
                }
            });
        },
        // 筛选
        renderTable: function(name) {
            this.dataloading = true;
            this.pages.currentPage = 1;
            var ps = { 'key': this.formItem.key,'page':1 };
            this.$api.adpos.list(ps).then(res => {
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
