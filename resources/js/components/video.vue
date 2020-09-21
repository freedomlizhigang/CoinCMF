<template>
    <div class="upload-video">
        <!-- 上传，限制张数 -->
        <Upload
            ref="upload-video"
            :default-file-list="defaultList"
            :on-success="handleSuccess"
            :format="['mp4']"
            :max-size="20480"
            :on-format-error="handleFormatError"
            :on-exceeded-size="handleMaxSize"
            :before-upload="handleBeforeUpload"
            name="imgFile"
            :data="postData"
            accept="video/*"
            action="/common/upload/file">
            <Button icon="ios-cloud-upload-outline">选择视频文件</Button>
        </Upload>
        <Alert type="warning" class="mt10">上传视频格式为mp4，大小不超过20M，请自己处理好其它宽、高、清晰度问题</Alert>
    </div>
</template>

<script>
export default {
  name: 'UploadVideo',
  data() {
    return {
      // 已经上传成功的所有文件结果
      videoList: [],
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
    this.videoList = this.$refs['upload-video'].fileList;
  },
  watch: {
    defaultList(curVal, oldVal) {
      if (curVal) {
        this.videoList = curVal;
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
      const fileList = this.$refs['upload-thumb'].fileList;
      this.$refs['upload-thumb'].fileList.splice(fileList.indexOf(file), 1);
    },
    // 上传成功的回调
    handleSuccess(res, file) {
      if (res.code == 200) {
        file.name = res.result.filename;
        file.url = res.result.url;
        this.videoUrl = file.url;
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
        desc: '文件 ' + file.name + ' 格式不正确, 请插入mp4格式的视频。'
      });
    },
    // 检查大小
    handleMaxSize(file) {
      this.$Notice.warning({
        title: '文件大小超出限制',
        desc: '文件 ' + file.name + ' 太大，最大就不要超过20M！'
      });
    },
    // 上传前检查数量
    handleBeforeUpload() {
      const check = this.videoList.length < 1;
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

