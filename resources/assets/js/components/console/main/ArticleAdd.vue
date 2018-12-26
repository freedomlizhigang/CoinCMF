<template>
  <div class="article-add">
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
            <upload-thumb v-model="formItem.thumb" ref="uploadthumb"></upload-thumb>
        </FormItem>
        <FormItem label="上传视频">
            <upload-video ref="uploadvideo"></upload-video>
        </FormItem>
        <FormItem label="文章内容">
            <editor-bar v-model="editor.info" :isClear="isClear" @change="change"></editor-bar>
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
    name: 'article-add',
    data () {
        return {
            cateSelect:[
            ],
            formItem:{
                'cate_id':'',
                'title':'',
                'describe':'',
                'thumb':'',
                'video':'',
                'content':'',
            },
            // 编辑器用的
            editor: {
                info: ''
            },
            isClear: false,
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
    // 计算
    computed: {

    },
    // 监听
    watch:{

    },
    created: function () {
        // 取数据
        this.getData1();
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
                    this.$api.article.create(this.formItem).then(res=>{
                        // console.log(res)
                        if(res.code == 200)
                        {
                            this.$Message.success(res.msg);
                            this.$router.push('/console/art/index');
                        }
                    });
                    return;
                }
            })
        },
        // 富文本更新时取值
        change (val) {
            this.editor.info = val
            // console.log(val)
        },
        getData1:function(){
            var self = this;
            this.$api.cate.select().then(res=>{
                if(res.code == 200)
                {
                    self.cateSelect = res.data;
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
