<template>
    <div class="uploader">
        <div id="uploader" class="wu-example">
            <!--用来存放文件信息-->
            <div id="thelist" class="uploader-list"></div>
            <div class="btns">
                <div id="picker">选择文件</div>
                <button id="ctlBtn" class="btn btn-default">开始上传</button>
            </div>
        </div>
    </div>
</template>

<!-- 上传用的 js -->
<script>

// 导出项目
export default {
  name: 'Uploader',
  mounted() {
    var uploader = WebUploader.create({
      // 自动上传
      auto: true,
      fileVal: 'imgFile',
      // 文件接收服务端。
      server: '/common/upload/file',
      // 选择文件的按钮。可选。
      // 内部根据当前运行是创建，可能是input元素，也可能是flash.
      pick: '#picker',
      // 不压缩image, 默认如果是jpeg，文件上传前会压缩一把再上传！
      resize: false,
      // 开起分片上传。
      chunked: true,
      accept: {
        title: 'Images',
        extensions: 'mp4',
        mimeTypes: 'video/*'
      }
    });
    // 成功以后加入input中
    uploader.on('uploadSuccess', function(file, req) {
      console.log(req);
    });
  }
}
</script>
