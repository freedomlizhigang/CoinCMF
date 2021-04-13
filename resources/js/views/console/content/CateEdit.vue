<template>
<div class="cate-edit pb60">
    <Form :model="formItemEdit" ref="cateEdit" label-position="right" :rules="cateEditValidate" :label-width="80" action="javascript:void(0)">
        <FormItem label="父栏目" prop="parentid">
            <Select v-model="formItemEdit.parentid" clearable :style="{'width':'240px'}">
                <Option :value="0" :key="0">一级栏目</Option>
                <Option v-for="item in cateSelect" :value="item.value" :key="item.value">{{ item.label }}</Option>
            </Select>
        </FormItem>
        <FormItem label="栏目名称" prop="name">
            <Input v-model="formItemEdit.name"></Input>
        </FormItem>
        <FormItem label="标题" prop="title">
            <Input v-model="formItemEdit.title"></Input>
        </FormItem>
        <FormItem label="关键字" prop="keyword">
            <Input v-model="formItemEdit.keyword"></Input>
        </FormItem>
        <FormItem label="描述" prop="describe">
            <Input type="textarea" v-model="formItemEdit.describe" :autosize="{minRows:4,maxRows:8}"></Input>
        </FormItem>
        <!-- 上传 -->
        <FormItem label="缩略图">
            <upload-thumb v-model="formItemEdit.thumb" ref="uploadthumb" :defaultList="thumblist"></upload-thumb>
        </FormItem>
        <FormItem label="栏目内容">
            <tinymce-editor ref="editContent"></tinymce-editor>
        </FormItem>
        <FormItem label="单页面">
            <i-switch v-model="formItemEdit.type" size="large" @on-change="typeChange">
                <span slot="open">是</span>
                <span slot="close">否</span>
            </i-switch>
        </FormItem>
        <FormItem label="栏目模板">
            <Input v-model="formItemEdit.cate_tpl"></Input>
        </FormItem>
        <FormItem label="文章模板">
            <Input v-model="formItemEdit.art_tpl"></Input>
        </FormItem>
        <FormItem label="是否显示">
            <i-switch v-model="formItemEdit.display" size="large" @on-change="displayChange">
                <span slot="open">是</span>
                <span slot="close">否</span>
            </i-switch>
        </FormItem>
        <FormItem label="是否外链">
            <i-switch v-model="formItemEdit.link_flag" size="large" @on-change="linkChange">
                <span slot="open">是</span>
                <span slot="close">否</span>
            </i-switch>
        </FormItem>
        <FormItem label="外链" v-if="linkshow">
            <Input v-model="formItemEdit.url" placeholder="输入外部链接地址..."></Input>
        </FormItem>
        <FormItem label="排序" prop="sort">
            <InputNumber :max="9999" :min="0" v-model="formItemEdit.sort"></InputNumber>
        </FormItem>
        <FormItem>
    </FormItem>
</Form>
</div>
</template>

<script>
import UploadThumb from '../../.././components/thumb'
import TinymceEditor from '../../.././components/tinymce'
export default {
    name: 'CateEdit',
    data() {
        return {
            cate_id: 0,
            cateSelect: [
            ],
            formItemEdit: {
                'parentid': 0,
                'name': '',
                'title': '',
                'keyword': '',
                'describe': '',
                'thumb': '',
                'content': '',
                'link_flag': false,
                'url': '',
                'cate_tpl': 'list',
                'art_tpl': 'show',
                'display': true,
                'type': false,
                'sort': 0,
            },
            linkshow:false,
            // 有文件时用的
            thumblist: [],
            cateEditValidate: {
                parentid: [
                    { required: true,type:'integer', message: '栏目必须填写', trigger: 'change' }
                ],
                name: [
                    { required: true, message: '名称必须填写', trigger: 'blur' }
                ],
                title: [
                    { required: true, message: '标题必须填写', trigger: 'blur' }
                ],
                describe: [
                    { required: false, message: '描述不能超过255个字符', max: 255, trigger: 'blur' }
                ],
                cate_tpl: [
                    { required: true, message: '栏目模板必须填写', trigger: 'blur' }
                ],
                art_tpl: [
                    { required: true, message: '文章模板必须填写', trigger: 'blur' }
                ],
                sort: [
                    { required: true, type: 'integer', message: '排序必须填写', trigger: 'blur' }
                ],
            }
        }
    },
    // 组件
    components: {
        UploadThumb,
        TinymceEditor
    },
    created: function() {
    },
    methods: {
        typeChange (status) {
            this.formItemEdit.type = status;
        },
        displayChange (status) {
            this.formItemEdit.display = status;
        },
        linkChange(status){
            this.formItemEdit.link_flag = status;
            this.linkshow = status
        },
        // 提交保存
        submitAdd(name) {
            this.$refs[name].validate((valid) => {
                this.$emit('showEdit',1);
                if (!valid) {
                    this.$Message.error('请检查输入的信息是否正确！');
                    this.$emit('showEdit',2);
                } else {
                    // 图片
                    if (this.$refs['uploadthumb'].uploadList.length) {
                        this.formItemEdit.thumb = this.$refs['uploadthumb'].uploadList[0].url;
                    } else {
                        // this.$Message.error('请上传图片！');
                        // return;
                    }
                    // 富文本
                    this.formItemEdit.content = this.$refs['editContent'].tinymce_value
                    const params = this.formItemEdit
                    params.category_id = this.cate_id;
                    // console.log(params)
                    this.$api.cate.edit(params).then(res => {
                        // console.log(res)
                        if (res.code == 200) {
                            this.$Message.success(res.message);
                            this.$emit('showEdit',3);
                        }
                        this.$emit('showEdit',2);
                    });
                    return;
                }
            })
        },
        getData: function(cate_id) {
            var self = this;
            self.cate_id = cate_id;
            // 更新编辑器
            this.$api.cate.detail({ 'category_id': cate_id }).then(res => {
                if (res.code == 200) {
                    this.formItemEdit = res.result;
                    if (res.result.thumb != '' && res.result.thumb != null) {
                        this.thumblist.push({ 'name': '图片文件', 'url': res.result.thumb, 'status': 'finished' });
                    }
                    this.linkshow = this.formItemEdit.link_flag
                    // 更新编辑器
                    this.$refs['editContent'].tinymce_value = res.result.content
                }
            });
            this.$api.cate.select().then(res => {
                if (res.code == 200) {
                    self.cateSelect = res.result;
                }
            });
            return;
        },
    }
}
</script>
