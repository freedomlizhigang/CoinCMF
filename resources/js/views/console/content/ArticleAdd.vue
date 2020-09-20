<template>
  <div class="article-add">
    <Form :model="formItem" ref="articleAdd" label-position="right" :rules="artValidate" :label-width="80" action="javascript:void(0)">
        <FormItem label="选择栏目" prop="cate_id">
            <Select v-model="formItem.cate_id" :style="{'width':'240px'}">
                <Option v-for="item in cateSelect" :value="item.value" :key="item.value">{{ item.label }}</Option>
            </Select>
        </FormItem>
        <FormItem label="文章标题" prop="title">
            <Input v-model="formItem.title"></Input>
        </FormItem>
        <FormItem label="关键字" prop="keywords">
            <Input v-model="formItem.keywords"></Input>
        </FormItem>
        <FormItem label="文章描述" prop="describe">
            <Input type="textarea" v-model="formItem.describe" :autosize="{minRows:4,maxRows:8}"></Input>
        </FormItem>
        <!-- 上传 -->
        <FormItem label="上传缩略图">
            <upload-thumb v-model="formItem.thumb" ref="uploadthumb"></upload-thumb>
        </FormItem>
        <FormItem label="文章内容">
          <tinymce-editor ref="editContent"></tinymce-editor>
        </FormItem>
        <FormItem label="文章模板">
            <Input v-model="formItem.tpl" style="width: 200px"></Input>
        </FormItem>
        <FormItem label="是否推荐">
            <i-switch v-model="formItem.push_flag" size="large" @on-change="pushChange">
                <span slot="open">是</span>
                <span slot="close">否</span>
            </i-switch>
        </FormItem>
        <FormItem label="来源">
            <Input v-model="formItem.source"></Input>
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
        <FormItem label="发布时间">
            <DatePicker v-model="formItem.publish_at" format="yyyy-MM-dd HH:mm:ss" type="datetime" placeholder="发布时间..." style="width: 200px"></DatePicker>
        </FormItem>
        <FormItem>
            <Button>重置</Button>
            <Button type="primary" @click="submitAdd('articleAdd')" style="margin-left: 8px">提交</Button>
        </FormItem>
    </Form>
  </div>
</template>

<script>
import UploadThumb from '../../.././components/thumb'
import TinymceEditor from '../../.././components/tinymce'
export default {
  name: 'ArticleAdd',
  data() {
    return {
      cateSelect: [
      ],
      formItem: {
        'cate_id': '',
        'title': '',
        'keywords':'',
        'describe': '',
        'thumb': '',
        'content': '',
        'tpl':'show',
        'push_flag':false,
        'source':'',
        'link_flag': false,
        'url':'',
        'sort':0,
        'publish_at':''
      },
      artValidate: {
        cate_id: [
          { required: true, type: 'integer', message: '栏目必须填写', trigger: 'change' }
        ],
        title: [
          { required: true, message: '标题必须填写', trigger: 'blur' }
        ]
      },
      linkshow:false
    }
  },
  // 组件
  components: {
    UploadThumb,
    TinymceEditor
  },
  // 计算
  computed: {
  },
  // 监听
  watch: {
  },
  created: function() {
    // 取数据
    this.getData1();
  },
  methods: {
    pushChange (status) {
        this.formItem.push_flag = status;
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
          }
          // 富文本
          this.formItem.content = this.$refs['editContent'].tinymce_value
          this.$api.article.create(this.formItem).then(res => {
            // console.log(res)
            if (res.code == 200) {
              this.$Message.success(res.message);
              this.$router.push('/article/list');
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
    // 选中栏目
    selectCateid: function(index) {
      // 选择
      if (index.length) {
        this.formItem.cate_id = index[0].cateid;
      }
      // console.log(index)
    }
  }
}
</script>
