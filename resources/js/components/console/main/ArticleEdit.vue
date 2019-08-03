<template>
  <div class="article-edit">
     <Form :model="formItem" ref="articleAdd" label-position="right" :rules="artValidate" :label-width="80" action="javascript:void(0)">
        <FormItem label="选择栏目" prop="cateid">
            <Select v-model="formItem.cate_id" :style="{'width':'240px'}">
                <Option v-for="item in cateSelect" :value="item.value" :key="item.value">{{ item.label }}</Option>
            </Select>
        </FormItem>
        <FormItem label="文章标题" prop="title">
            <Input v-model="formItem.title"></Input>
        </FormItem>
        <FormItem label="文章描述" prop="describe">
            <Input type="textarea" v-model="formItem.describe" :autosize="{minRows:4,maxRows:8}"></Input>
        </FormItem>
        <!-- 上传 -->
        <FormItem label="上传缩略图">
            <upload-thumb v-model="formItem.thumb" ref="uploadthumb" :defaultList="thumblist"></upload-thumb>
        </FormItem>
        <FormItem label="上传视频">
            <upload-video ref="uploadvideo" :defaultList="videolist"></upload-video>
        </FormItem>
        <FormItem label="文章内容">
            <editor-bar v-model="editor.info" ref="editContent" :isClear="isClear" @change="change"></editor-bar>
        </FormItem>
        <FormItem>
            <Button>重置</Button>
            <Button type="primary" @click="submitAdd('articleAdd')" style="margin-left: 8px">提交</Button>
        </FormItem>
    </Form>
  </div>
</template>

<script>
import UploadThumb from '../common/thumb'
import UploadVideo from '../common/video'
import EditorBar from '../common/editor'
export default {
    name: 'article-edit',
    data () {
        return {
            art_id:0,
            cateSelect:[
            ],
            formItem:{
                'cate_id':'',
                'title':'',
                'describe':'',
                'thumb':'',
                'video':'',
                'content':'',
                'sort':0,
            },
            // 编辑器用的
            editor: {
                info: ''
            },
            isClear: true,
            // 有文件时用的
            thumblist:[],
            videolist:[],
            artValidate: {
                cate_id: [
                    { required: true, type:'integer' , message: '栏目必须填写', trigger: 'change' }
                ],
                title: [
                    { required: true, message: '标题必须填写', trigger: 'blur' },
                ],
                describe: [
                    { required: true, message: '描述必须填写', trigger: 'blur' },
                    { required: true, message: '描述不能超过255个字符', max:255 , trigger: 'blur' }
                ]
            },
        }
    },
    // 组件
    components: {
        EditorBar,
        UploadThumb,
        UploadVideo,
    },
    created: function () {
        this.art_id = this.$route.params.id;
        // 取数据
        this.getData();
    },
    methods:{
        // 提交保存
        submitAdd(name){
            this.$refs[name].validate((valid) => {
                if (!valid) {
                    this.$Message.error('请检查输入的信息是否正确！');
                }
                else
                {
                    // 图片
                    if (this.$refs['uploadthumb'].uploadList.length) {
                        this.formItem.thumb = this.$refs['uploadthumb'].uploadList[0].url;
                    }
                    else
                    {
                        // this.$Message.error('请上传图片！');
                        // return;
                    }
                    // 视频
                    if (this.$refs['uploadvideo'].videoList.length) {
                        this.formItem.video = this.$refs['uploadvideo'].videoList[0].url;
                    }
                    else
                    {
                        // this.$Message.error('请上传视频！');
                        // return;
                    }
                    // 富文本
                    this.formItem.content = this.editor.info
                    var params = this.formItem;
                    params.article_id = this.art_id;
                    this.$api.article.edit(params).then(res=>{
                        if(res.code == 200)
                        {
                            this.$Message.success(res.msg);
                            this.$router.go(-1);
                        }
                    });
                    return;
                }
            })
        },
        // 富文本更新时取值
        change (val) {
            this.editor.info = val
        },
        getData:function(){
            var self = this;
            this.$api.cate.select().then(res=>{
                if(res.code == 200)
                {
                    self.cateSelect = res.data;
                }
            });
            this.$api.article.detail({'article_id':this.art_id}).then(res=>{
                if(res.code == 200)
                {
                    self.formItem = res.data;
                    if (res.data.video != '' && res.data.video != null) {
                        this.videolist.push({'name':'视频文件','url':res.data.video});
                    }
                    if (res.data.thumb != '' && res.data.thumb != null) {
                        this.thumblist.push({'name':'图片文件','url':res.data.thumb,'status':'finished'});
                    }
                    // 更新编辑器
                    this.editor.info = res.data.content;
                    this.$refs['editContent'].editor.txt.html(res.data.content)
                }
            });
            return;
        },
        // 选中栏目
        selectCateid:function(index){
            // 选择
            if (index.length) {
                this.formItem.cate_id = index[0].cateid;
            }
            console.log(index)
        },
    },
}
</script>
