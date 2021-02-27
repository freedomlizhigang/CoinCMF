<template>
<div class="ad-list">
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
        <Button size="small" @click="showModel" type="success">添加广告</Button>
    </div>
    <Table border ref="adlist" :columns="list" :data="tablelist" :loading="dataloading" @on-selection-change="changeData">
        <template slot-scope="{ row }" slot="title">
            <div class="clearfix" style="padding:10px;">
                <img :src="row.thumb" width="200" height="auto" alt="" class="f-l" style="padding:10px;background:#eee;margin-right:10px;">
                <a :href="row.url" target="_blank" style="font-size:16px;line-height:2;display:block;">[{{ row.ad_pos.name }}] {{ row.title }}</a>
                <p>{{ row.starttime }} - {{ row.endtime }}</p>
            </div>
        </template>
        <template slot-scope="{ row }" slot="status">
            <Tag color="green" v-if="row.status">正常</Tag>
            <Tag color="volcano" v-if="row.status == false">关闭</Tag>
        </template>
        <template slot-scope="{ row, index }" slot="action">
            <Button type="info" size="small" style="margin-right: 5px;float:left" @click="showEditAd(row.id)">编辑</Button>
            <Button type="error" size="small" @click="remove(index,row.id)">删除</Button>
        </template>
    </Table>
    <!-- 分页 -->
    <div class="table-page">
        <Page size="small" ref="listPage" :total="pages.total" :current="pages.current" :page-size="pages.size" show-elevator show-total @on-change="changePage"></Page>
    </div>
    <!-- 添加的弹出 -->
    <!-- 需要全屏时添加这句 :mask="false" class-name="idw100" -->
    <Drawer :closable="false" :mask-closable="false" :scrollable="true" title="添加广告" width="640" v-model="showModalStatus">
        <Spin size="large" fix v-if="loading"></Spin>
        <Form :model="ad" ref="adValidate" label-position="right" :label-width="80" :rules="adValidate" action="javascript:void(0)">
            <FormItem label="广告位" prop="pos_id">
                <Select v-model="ad.pos_id" :style="{'width':'240px'}">
                    <Option v-for="item in adpos" :value="item.id" :key="item.id">{{ item.name }}</Option>
                </Select>
            </FormItem>
            <FormItem label="名称" prop="title">
                <Input v-model="ad.title" placeholder="输入名称..."></Input>
            </FormItem>
            <FormItem label="上传图片">
                <upload-thumb v-model="ad.thumb" ref="uploadthumb"></upload-thumb>
            </FormItem>
            <FormItem label="URL" prop="url">
                <Input v-model="ad.url" placeholder="输入链接地址..."></Input>
            </FormItem>
            <FormItem label="开始时间">
                <DatePicker v-model="ad.starttime" format="yyyy-MM-dd HH:mm:ss" type="datetime" placeholder="开始时间..." style="width: 200px"></DatePicker>
            </FormItem>
            <FormItem label="结束时间">
                <DatePicker v-model="ad.endtime" format="yyyy-MM-dd HH:mm:ss" type="datetime" placeholder="结束时间..." style="width: 200px"></DatePicker>
            </FormItem>
            <FormItem label="状态">
                <i-switch v-model="ad.status">
                    <span slot="on">正常</span>
                    <span slot="off">禁用</span>
                </i-switch>
            </FormItem>
            <FormItem label="排序">
                <InputNumber :max="9999" :min="0" v-model="ad.sort"></InputNumber>
            </FormItem>
            <FormItem>
                <Button style="margin-right: 8px" @click="showModalStatus = false">取消</Button>
                <Button type="primary" @click="createAd('adValidate')">提交</Button>
            </FormItem>
        </Form>
    </Drawer>
    <!-- 修改的弹出 -->
    <Drawer :closable="false" :mask-closable="false" :scrollable="true" title="修改广告" width="640" v-model="showEditModalStatus">
        <Spin size="large" fix v-if="loading"></Spin>
        <Form :model="ad" ref="adValidate" label-position="right" :label-width="80" :rules="adValidate" action="javascript:void(0)">
            <FormItem label="选择广告位" prop="pos_id">
                <Select v-model="ad.pos_id" :style="{'width':'240px'}">
                    <Option v-for="item in adpos" :value="item.id" :key="item.id">{{ item.name }}</Option>
                </Select>
            </FormItem>
            <FormItem label="名称" prop="title">
                <Input v-model="ad.title" placeholder="输入名称..."></Input>
            </FormItem>
            <FormItem label="上传图片">
                <upload-thumb v-model="ad.thumb" ref="uploadthumb_edit" :defaultList="thumblist"></upload-thumb>
            </FormItem>
            <FormItem label="URL" prop="url">
                <Input v-model="ad.url" placeholder="输入链接地址..."></Input>
            </FormItem>
            <FormItem label="开始时间">
                <DatePicker v-model="ad.starttime" format="yyyy-MM-dd HH:mm:ss" type="datetime" placeholder="开始时间..." style="width: 200px"></DatePicker>
            </FormItem>
            <FormItem label="结束时间">
                <DatePicker v-model="ad.endtime" format="yyyy-MM-dd HH:mm:ss" type="datetime" placeholder="结束时间..." style="width: 200px"></DatePicker>
            </FormItem>
            <FormItem label="状态">
                <i-switch v-model="ad.status">
                    <span slot="on">正常</span>
                    <span slot="off">禁用</span>
                </i-switch>
            </FormItem>
            <FormItem label="排序">
                <InputNumber :max="9999" :min="0" v-model="ad.sort"></InputNumber>
            </FormItem>
            <FormItem>
                <Button style="margin-right: 8px" @click="showEditModalStatus = false">取消</Button>
                <Button type="primary" @click="editAd('adValidate')">提交</Button>
            </FormItem>
        </Form>
    </Drawer>
</div>
</template>

<script>
import UploadThumb from '../../.././components/thumb'
export default {
    name: 'Ad',
    data() {
        return {
            ad_id:0,
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
                    width: 130
                }
            ],
            tablelist: [],
            ad: {
                pos_id: 0,
                title: '',
                thumb: null,
                url: '',
                starttime: '',
                endtime: '',
                sort: 0,
                status: true
            },
            showModalStatus: false,
            showEditModalStatus:false,
            adValidate: {
                pos_id: [
                    { required: true, type: 'integer', message: '广告位必须填写', trigger: 'change' }
                ],
                title: [
                    { required: true, message: '链接名称必须填写', trigger: 'blur' }
                ],
                url: [
                    { required: true, message: '链接 URL 必须填写', trigger: 'blur' }
                ]
            },
            adpos:[],
            thumblist:[],
            selectData:[],
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
            var params = { page: this.pages.current,'size':this.pages.size};
            this.$api.ad.list(params).then(res => {
                this.dataloading = false;
                if (res.code == 200) {
                    this.tablelist = res.result.list;
                    this.pages.total = res.result.count
                    this.$Message.success(res.message);
                }
            });
            this.$api.adpos.list({page:1,size:100000}).then(res => {
                this.dataloading = false;
                if (res.code == 200) {
                    this.adpos = res.result.list;
                }
            });
            return;
        },
        // 展开添加
        showModel() {
            this.showModalStatus = !this.showModalStatus;
            this.ad.pos_id = '';
            this.ad.title = '';
            this.ad.thumb = null;
            this.ad.url = '';
            this.ad.starttime = '';
            this.ad.endtime = '';
            this.ad.sort = 0;
            this.ad.status = true;
        },
        // 添加
        createAd(name) {
            this.$refs[name].validate((valid) => {
                if (valid) {
                    this.loading = true;
                    // 图片
                    if (this.$refs['uploadthumb'].uploadList.length) {
                        this.ad.thumb = this.$refs['uploadthumb'].uploadList[0].url;
                    }
                    else{
                        this.loading = false;
                        this.$Message.error('请上传图片！');
                        return;
                    }
                    // console.log(this.ad)
                    // console.log(this.$refs['uploadthumb'].uploadList)
                    this.$api.ad.create(this.ad).then(res => {
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
        showEditAd:function(id){
            this.ad_id = id;
            this.loading = true;
            this.$api.ad.detail({ad_id:id}).then(res => {
                if (res.code == 200) {
                    this.ad = res.result
                    this.loading = false;
                    this.thumblist = [];
                    if (res.result.thumb != '' && res.result.thumb != null) {
                        this.thumblist.push({ 'name': '图片文件', 'url': res.result.thumb, 'status': 'finished' });
                    }
                }
            })
            this.showEditModalStatus = !this.showEditModalStatus;
        },
        editAd:function(name){
            this.$refs[name].validate((valid) => {
                if (valid) {
                    this.loading = true;
                    // 图片
                    if (this.$refs['uploadthumb_edit'].uploadList.length) {
                        this.ad.thumb = this.$refs['uploadthumb_edit'].uploadList[0].url;
                    }
                    else{
                        this.loading = false;
                        this.$Message.error('请上传图片！');
                        return;
                    }
                    this.ad.ad_id = this.ad_id
                    this.$api.ad.edit(this.ad).then(res => {
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
                this.$api.ad.remove({ ad_id: [id] }).then(res => {
                    if (res.code == 200) {
                    this.$Message.success(res.message);
                    this.tablelist.splice(index, 1);
                    }
                });
                }
            });
        },
        sort:function (id,value) {
            this.$api.ad.sort({ ad_id: id,sort:value }).then(res => {
                if (res.code == 200) {
                    this.$Message.success(res.message);
                }
            });
        },
        // 筛选
        renderTable: function(name) {
            this.dataloading = true;
            this.pages.currentPage = 1;
            var ps = { 'key': this.formItem.key,'page':1 ,size:this.pages.size};
            this.$api.ad.list(ps).then(res => {
                this.dataloading = false;
                if (res.code == 200) {
                this.tablelist = res.result.list;
                this.pages.total = res.result.count
                this.$Message.success(res.message);
                }
            });
            return;
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
                this.$api.ad.remove({ ad_id: ids }).then(res => {
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
