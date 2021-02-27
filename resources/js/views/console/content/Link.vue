<template>
<div class="link-list">
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
        <Button size="small" @click="showModel" type="success">添加链接</Button>
    </div>
    <Table border ref="linklist" :columns="list" :data="tablelist" :loading="dataloading" @on-selection-change="changeData">
        <template slot-scope="{ row }" slot="title">
            <div class="clearfix">
                <img :src="row.thumb" width="200" height="auto" alt="" class="f-l">
                <a :href="row.url" target="_blank">{{ row.title }}</a>
            </div>
        </template>
        <template slot-scope="{ row }" slot="status">
            <Tag color="green" v-if="row.status">正常</Tag>
            <Tag color="volcano" v-if="row.status == false">关闭</Tag>
        </template>
        <template slot-scope="{ row, index }" slot="action">
            <Button type="info" size="small" style="margin-right: 5px;float:left" @click="showEditLink(row.id)">编辑</Button>
            <Button type="error" size="small" @click="remove(index,row.id)">删除</Button>
        </template>
    </Table>
    <!-- 分页 -->
    <div class="table-page">
        <Page size="small" ref="listPage" :total="pages.total" :current="pages.current" :page-size="pages.size" show-elevator show-total @on-change="changePage"></Page>
    </div>
    <!-- 添加的弹出 -->
    <!-- 需要全屏时添加这句 :mask="false" class-name="idw100" -->
    <Drawer :closable="false" :mask-closable="false" :scrollable="true" title="添加链接" width="640" v-model="showModalStatus">
        <Spin size="large" fix v-if="loading"></Spin>
        <Form :model="link" ref="linkValidate" label-position="right" :label-width="80" :rules="linkValidate" action="javascript:void(0)">
            <FormItem label="名称" prop="title">
                <Input v-model="link.title" placeholder="输入名称..."></Input>
            </FormItem>
            <FormItem label="上传图片">
                <upload-thumb v-model="link.thumb" ref="uploadthumb"></upload-thumb>
            </FormItem>
            <FormItem label="URL" prop="url">
                <Input v-model="link.url" placeholder="输入链接地址..."></Input>
            </FormItem>
            <FormItem label="状态">
                <i-switch v-model="link.status">
                    <span slot="on">正常</span>
                    <span slot="off">禁用</span>
                </i-switch>
            </FormItem>
            <FormItem label="排序">
                <InputNumber :max="9999" :min="0" v-model="link.sort"></InputNumber>
            </FormItem>
            <FormItem>
                <Button style="margin-right: 8px" @click="showModalStatus = false">取消</Button>
                <Button type="primary" @click="createLink('linkValidate')">提交</Button>
            </FormItem>
        </Form>
    </Drawer>
    <!-- 修改的弹出 -->
    <Drawer :closable="false" :mask-closable="false" :scrollable="true" title="修改链接" width="640" v-model="showEditModalStatus">
        <Spin size="large" fix v-if="loading"></Spin>
        <Form :model="link" ref="linkValidate" label-position="right" :label-width="80" :rules="linkValidate" action="javascript:void(0)">
            <FormItem label="名称" prop="title">
                <Input v-model="link.title" placeholder="输入名称..."></Input>
            </FormItem>
            <FormItem label="上传图片">
                <upload-thumb v-model="link.thumb" ref="uploadthumb_edit" :defaultList="thumblist"></upload-thumb>
            </FormItem>
            <FormItem label="URL" prop="url">
                <Input v-model="link.url" placeholder="输入链接地址..."></Input>
            </FormItem>
            <FormItem label="状态">
                <i-switch v-model="link.status">
                    <span slot="on">正常</span>
                    <span slot="off">禁用</span>
                </i-switch>
            </FormItem>
            <FormItem label="排序">
                <InputNumber :max="9999" :min="0" v-model="link.sort"></InputNumber>
            </FormItem>
            <FormItem>
                <Button style="margin-right: 8px" @click="showEditModalStatus = false">取消</Button>
                <Button type="primary" @click="editLink('linkValidate')">提交</Button>
            </FormItem>
        </Form>
    </Drawer>
</div>
</template>

<script>
import UploadThumb from '../../.././components/thumb'
export default {
    name: 'Link',
    data() {
        return {
            link_id:0,
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
                    slot: 'title',
                },
                {
                    title: '排序',
                    width: 100,
                    key: 'sort',
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
                    title: '状态',
                    slot: 'status',
                    width: 90
                },
                {
                    title: '操作',
                    slot: 'action',
                    width: 130,
                }
            ],
            tablelist: [],
            link: {
                title: '',
                thumb: null,
                url: '',
                sort: 0,
                status: true
            },
            showModalStatus: false,
            showEditModalStatus:false,
            linkValidate: {
                title: [
                    { required: true, message: '链接名称必须填写', trigger: 'blur' }
                ],
                url: [
                    { required: true, message: '链接 URL 必须填写', trigger: 'blur' }
                ],
            },
            thumblist:[],
            selectData: [],
        }
    },
    created: function() {
        // 取数据
        this.getTableList();
    },
    // 组件
    components: {
        UploadThumb
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
        var params = { page: this.pages.current, size:this.pages.size};
        this.$api.link.list(params).then(res => {
            this.dataloading = false;
            if (res.code == 200) {
                this.tablelist = res.result.list;
                this.pages.total = res.result.count
                this.$Message.success(res.message);
            }
        });
        return;
    },
    // 展开添加
    showModel() {
        this.showModalStatus = !this.showModalStatus;
        this.link.title = '';
        this.link.thumb = null;
        this.link.url = '';
        this.link.sort = 0;
        this.link.status = true;
    },
    // 添加
    createLink(name) {
        this.$refs[name].validate((valid) => {
            this.loading = true;
            if (valid) {
                // 图片
                if (this.$refs['uploadthumb'].uploadList.length) {
                    this.link.thumb = this.$refs['uploadthumb'].uploadList[0].url;
                } else {
                    // this.$Message.error('请上传图片！');
                    // return;
                }
                this.$api.link.create(this.link).then(res => {
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
    showEditLink:function(id){
        this.link_id = id;
        this.loading = true;
        this.$api.link.detail({link_id:id}).then(res => {
            if (res.code == 200) {
                this.link = res.result
                this.loading = false;
            }
            this.thumblist = [];
            if (res.result.thumb != '' && res.result.thumb != null) {
                this.thumblist.push({ 'name': '图片文件', 'url': res.result.thumb, 'status': 'finished' });
            }
        })
        this.showEditModalStatus = true;
    },
    editLink:function(name){
        this.$refs[name].validate((valid) => {
            this.loading = true;
            if (valid) {
                // 图片
                if (this.$refs['uploadthumb_edit'].uploadList.length) {
                    this.link.thumb = this.$refs['uploadthumb_edit'].uploadList[0].url;
                } else {
                    // this.$Message.error('请上传图片！');
                    // return;
                }
                this.link.link_id = this.link_id
                this.$api.link.edit(this.link).then(res => {
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
            this.$api.link.remove({ link_id: [id] }).then(res => {
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
            this.$api.link.remove({ link_id: ids }).then(res => {
                if (res.code == 200) {
                    this.$Message.success(res.message);
                    this.getTableList();
                }
            });
            }
        });
    },
    sort:function (id,value) {
        this.$api.link.sort({ link_id: id,sort:value }).then(res => {
            if (res.code == 200) {
                this.$Message.success(res.message);
            }
        });
    },
    // 筛选
    renderTable: function(name) {
        this.dataloading = true;
        this.pages.currentPage = 1;
        var ps = { 'key': this.formItem.key,'page':1 ,size: this.pages.size };
        this.$api.link.list(ps).then(res => {
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
