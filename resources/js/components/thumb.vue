<template>
    <div class="upload-img">
        <div class="upload-list" v-for="item in uploadList">
            <template v-if="item.status === 'finished'">
                <img :src="item.url">
                <div class="upload-list-cover">
                    <Icon type="ios-trash-outline" @click.native="handleRemove(item)"></Icon>
                </div>
            </template>
            <template v-else>
                <Progress v-if="item.showProgress" :percent="item.percentage" hide-info></Progress>
            </template>
        </div>
        <!-- 上传，限制张数 -->
        <Upload
            ref="upload-thumb"
            :show-upload-list="false"
            :default-file-list="defaultList"
            :on-success="handleSuccess"
            :format="['jpg','jpeg','png','gif']"
            :max-size="2048"
            :on-format-error="handleFormatError"
            :on-exceeded-size="handleMaxSize"
            :before-upload="handleBeforeUpload"
            multiple
            type="drag"
            name="imgFile"
            :data="postData"
            action="/common/upload/file"
            style="display: inline-block;width:58px;">
            <div style="width: 58px;height:58px;line-height: 58px;">
                <Icon type="ios-camera" size="20"></Icon>
            </div>
        </Upload>
        <Alert>上传图片格式为'jpg','jpeg','png','gif'，大小不超过2M，请自己处理好宽高比例</Alert>
    </div>


</template>

<script>
export default {
  name: 'UploadThumb',
  data() {
    return {
      // 已经上传成功的所有文件结果
      uploadList: [],
      postData: {
        'thumb': 0,
        'thumbWidth': '200',
        'thumbWidth': '200'
      }
    }
  },
  props: {
    defaultList: {
      type: Array,
      default: function() {
        return [];
      }
    }
  },
  mounted() {
    this.uploadList = this.$refs['upload-thumb'].fileList;
  },
  watch: {
    defaultList(curVal, oldVal) {
      if (curVal) {
        this.uploadList = curVal;
      }
    }
  },
  created: function() {
  },
  methods: {
    handleClearFiles() {
      // 再次点击上传之前，清空之前已上传文件
      this.$refs.upload.clearFiles()
    },
    // 移除的回调
    handleRemove(file) {
      // console.log(file)
      let fileList = this.$refs['upload-thumb'].fileList;
      let fileIndex = fileList.indexOf(file);
      this.$refs['upload-thumb'].fileList.splice(fileIndex, 1);
      this.defaultList.splice(fileIndex, 1);
    },
    // 上传成功的回调
    handleSuccess(res, file) {
      // console.log(res)
      if (res.code == 200) {
        file.name = res.result.filename;
        file.url = res.result.url;
        // 更新显示的
        this.uploadList = this.$refs['upload-thumb'].fileList;
      } else {
        this.$Notice.warning({
          title: '上传失败',
          desc: '请检查网络及上传的内容是否符合要求！'
        });
      }
    },
    // 检查文件格式
    handleFormatError(file) {
      this.$Notice.warning({
        title: '文件格式不正确',
        desc: '文件 ' + file.name + ' 格式不正确, 请插入jpg/jpeg/png/gif图片。'
      });
    },
    // 检查大小
    handleMaxSize(file) {
      this.$Notice.warning({
        title: '文件大小超出限制',
        desc: '文件 ' + file.name + ' 太大，最大就不要超过2M！'
      });
    },
    // 上传前检查数量
    handleBeforeUpload() {
      const check = this.uploadList.length < 1;
      if (!check) {
        this.$Notice.warning({
          title: '已经超出最大可上传数量！'
        });
      }
      return check;
    }
  }
}
</script>


<style>
    .upload-list{
        display: inline-block;
        width: 60px;
        height: 60px;
        text-align: center;
        line-height: 60px;
        border: 1px solid transparent;
        border-radius: 4px;
        overflow: hidden;
        background: #fff;
        position: relative;
        box-shadow: 0 1px 1px rgba(0,0,0,.2);
        margin-right: 4px;
    }
    .upload-list img{
        width: 100%;
        height: 100%;
    }
    .upload-list-cover{
        display: none;
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(0,0,0,.6);
    }
    .upload-list:hover .upload-list-cover{
        display: block;
    }
    .upload-list-cover i{
        color: #fff;
        font-size: 20px;
        cursor: pointer;
        margin: 0 2px;
    }
</style>
