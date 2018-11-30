<button type="button" class="layui-btn" id="test1">
    <i class="layui-icon">&#xe67c;</i>上传图片
</button>
<p id="demoText"><img src="{{ $slot }}" width="120px" height="90px" alt=""></p>
<style>
    #demoText {
        overflow: hidden;
        width: 120px;
        height: 90px;
        border: #f0f0f0 solid 1px;
        margin-top: 10px;
    }
</style>
<script>
layui.use(['layer','upload'],function(){
  var upload = layui.upload;
  var layer = layui.layer;

  //执行实例
  var uploadInst = upload.render({
    elem: '#test1' //绑定元素
    ,url: "{{ url('api/common/upload') }}" //上传接口
    ,accept: 'images' //允许上传的文件类型
    ,exts: 'jpg|png|gif|bmp|jpeg' //允许上传的文件类型
    ,field: 'imgFile' //设定文件域的字段名
    ,size: 2048 //最大允许上传的文件大小
    ,multiple: false //是否允许多文件上传
    ,number: 1 //设置同时可上传的文件数量
    ,data:{
        "thumb":1,
        "thumbWidth":120,
        "thumbHeight":120
    }
    ,done: function(res){
        // console.log(res)
        $('#demoText').html("<img src='" + res.url + "' width='120px' height='90px' />");
        layer.msg('图片上传成功！',{icon:1,offset:'auto'})
    }
    ,error: function(){
        layer.msg('图片上传失败！',{icon:2,offset:'auto'})
    }
  });
});
</script>