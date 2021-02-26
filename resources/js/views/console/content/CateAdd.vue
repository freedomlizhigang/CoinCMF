<template>
<div class="article-add pb60">
    <Form :model="formItem" ref="articleAdd" label-position="right" :rules="artValidate" :label-width="80" action="javascript:void(0)">
        <FormItem label="父栏目" prop="parentid">
            <Select v-model="formItem.parentid" :style="{'width':'240px'}">
                <Option :value="0" :key="0">一级栏目</Option>
                <Option v-for="item in cateSelect" :value="item.value" :key="item.value">{{ item.label }}</Option>
            </Select>
        </FormItem>
        <FormItem label="栏目名称" prop="name">
            <Input v-model="formItem.name"></Input>
        </FormItem>
        <FormItem label="标题" prop="title">
            <Input v-model="formItem.title"></Input>
        </FormItem>
        <FormItem label="关键字" prop="keyword">
            <Input v-model="formItem.keyword"></Input>
        </FormItem>
        <FormItem label="描述" prop="describe">
            <Input type="textarea" v-model="formItem.describe" :autosize="{minRows:4,maxRows:8}"></Input>
        </FormItem>
        <!-- 上传 -->
        <FormItem label="缩略图">
            <upload-thumb v-model="formItem.thumb" ref="uploadthumb"></upload-thumb>
        </FormItem>
        <FormItem label="栏目内容">
            <tinymce-editor ref="editContent"></tinymce-editor>
        </FormItem>
        <FormItem label="单页面">
            <i-switch v-model="formItem.type" size="large" @on-change="typeChange">
                <span slot="open">是</span>
                <span slot="close">否</span>
            </i-switch>
        </FormItem>
        <FormItem label="栏目模板">
            <Input v-model="formItem.cate_tpl"></Input>
        </FormItem>
        <FormItem label="文章模板">
            <Input v-model="formItem.art_tpl"></Input>
        </FormItem>
        <FormItem label="是否显示">
            <i-switch v-model="formItem.display" size="large" @on-change="displayChange">
                <span slot="open">是</span>
                <span slot="close">否</span>
            </i-switch>
        </FormItem>
        <FormItem label="是否外链">
            <i-switch v-model="formItem.link_flag" size="large" @on-change="linkChange">
                <span slot="open">是</span>
                <span slot="close">否</span>
            </i-switch>
        </FormItem>
        <FormItem label="外链" v-if="linkshow">
            <Input v-model="formItem.url" placeholder="输入外部链接地址..."></Input>
        </FormItem>
        <FormItem label="排序" prop="sort">
            <InputNumber :max="9999" :min="0" v-model="formItem.sort"></InputNumber>
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
    name: 'CateAdd',
    data() {
        return {
            cateSelect: [
            ],
            formItem: {
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
            artValidate: {
                parentid: [
                    { required: true, type:'integer', message: '栏目必须填写', trigger: 'change' }
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
            },
            disabled: false
        }
    },
    // 组件
    components: {
        UploadThumb,
        TinymceEditor
    },
    created: function() {
        // 取数据
        this.getData1();
    },
    methods: {
        typeChange (status) {
            this.formItem.type = status;
        },
        displayChange (status) {
            this.formItem.display = status;
        },
        linkChange(status){
            this.formItem.link_flag = status;
            this.linkshow = status
        },
        // 提交保存
        submitAdd(name) {
            this.$refs[name].validate((valid) => {
                if (!valid) {
                    this.$Message.error('请检查输入的信息是否正确！');
                } else {
                    // 图片
                    if (this.$refs['uploadthumb'].uploadList.length) {
                        this.formItem.thumb = this.$refs['uploadthumb'].uploadList[0].url;
                    } else {
                        // this.$Message.error('请上传图片！');
                        // return;
                    }
                    // 富文本
                    this.formItem.content = this.$refs['editContent'].tinymce_value
                    this.$api.cate.create(this.formItem).then(res => {
                        // console.log(res)
                        if (res.code == 200) {
                            this.$Message.success(res.message);
                            // 关掉弹出
                            this.$emit('showCreate',false);
                        }
                    });
                    return;
                }
            })
        },
        getData1: function() {
            var self = this;
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
