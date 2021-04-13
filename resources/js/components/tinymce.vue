<template>
    <div class="tinymce-box">
        <editor :key="tinymceFlag" v-model="tinymce_value" :init="init"></editor>
    </div>
</template>
<script>
    import tinymce from 'tinymce/tinymce'
    import Editor from '@tinymce/tinymce-vue'
    import 'tinymce/themes/silver'
    import 'tinymce/icons/default'
    // 引入你需要的插件
    import 'tinymce/plugins/code';
    import 'tinymce/plugins/link';
    import 'tinymce/plugins/table';
    import 'tinymce/plugins/lists';
    import 'tinymce/plugins/advlist';
    import 'tinymce/plugins/image';
    import 'tinymce/plugins/media';
    export default{
        name: 'TinymceEditor',
        data() {
            return {
                tinymce_value:' ',
                init: {
                    language_url: '/statics/tinymce/langs/zh_CN.js',// 语言包的路径
                    language: 'zh_CN',//语言
                    skin_url: '/statics/tinymce/skins/ui/oxide',// skin路径
                    content_css: '/statics/tinymce/skins/content/default/content.css',
                    height: 300,//编辑器高度
                    branding: true,//是否禁用“Powered by TinyMCE”
                    menubar: false,//顶部菜单栏显示,
                    toolbar: true, //隐藏菜单栏
                    height: 500,
                    toolbar:'code bold italic underline strikethrough forecolor backcolor formatselect fontselect fontsizeselect cut copy paste link image media table bullist numlist  alignleft aligncenter alignright alignjustify outdent indent blockquote subscript superscript removeformat undo redo',
                    plugins: [ 'code','link','table','advlist','lists','image','media'], //选择需加载的插件
                    // 自己处理上传图片
                    images_upload_handler: function (blobInfo, succFun, failFun) {
                        var xhr, formData;
                        var file = blobInfo.blob();//转化为易于理解的file对象
                        xhr = new XMLHttpRequest();
                        xhr.withCredentials = false;
                        xhr.open('POST', '/common/upload/file');
                        xhr.onload = function() {
                            var json;
                            if (xhr.status != 200) {
                                failFun('HTTP Error: ' + xhr.status);
                                return;
                            }
                            json = JSON.parse(xhr.responseText);
                            if (!json || json.code != 200) {
                                failFun('上传失败: ' + json.message);
                                return;
                            }
                            // 成功了的处理
                            succFun(json.result.url);
                        };
                        formData = new FormData();
                        formData.append('imgFile', file, file.name );//此处与源文档不一样
                        xhr.send(formData);
                    },
                    // 文件上传
                    file_picker_callback: function(callback, value, meta) {
                        //要先模拟出一个input用于上传本地文件
                        var input = document.createElement('input');
                            input.setAttribute('type', 'file');
                            //你可以给input加accept属性来限制上传的文件类型
                            input.setAttribute('accept', '.jpg,.png,.gif,.jpeg,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.pdf,.txt,.md,.rar,.zip');
                        input.click();
                        input.onchange = function() {
                            var file = this.files[0];
                            var xhr, formData;
                            console.log(file.name);
                            xhr = new XMLHttpRequest();
                            xhr.withCredentials = false;
                            xhr.open('POST', '/common/upload/file');
                            xhr.onload = function() {
                                var json;
                                if (xhr.status != 200) {
                                    failure('HTTP Error: ' + xhr.status);
                                    return;
                                }
                                json = JSON.parse(xhr.responseText);
                                if (!json || json.code != 200) {
                                    failure('上传失败: ' + json.message);
                                    return;
                                }
                                // 成功了的处理
                                callback(json.result.url);
                            };
                            formData = new FormData();
                            formData.append('imgFile', file, file.name );
                            xhr.send(formData);
                        }
                    },
                    //想要哪一个图标提供本地文件选择功能，参数可为media(媒体)、image(图片)、file(文件)
                    file_picker_types: 'media', 
                    //be used to add custom file picker to those dialogs that have it.
                    file_picker_callback: function(cb, value, meta) {
                        //要先模拟出一个input用于上传本地文件
                        var input = document.createElement('input');
                            input.setAttribute('type', 'file');
                            //你可以给input加accept属性来限制上传的文件类型
                            input.setAttribute('accept', '.mp4,.avi');
                        input.click();
                        input.onchange = function() {
                            var file = this.files[0];
                            var xhr, formData;
                            console.log(file.name);
                            xhr = new XMLHttpRequest();
                            xhr.withCredentials = false;
                            xhr.open('POST', '/common/upload/file');
                            xhr.onload = function() {
                                var json;
                                if (xhr.status != 200) {
                                    failure('HTTP Error: ' + xhr.status);
                                    return;
                                }
                                json = JSON.parse(xhr.responseText);
                                if (!json || json.code != 200) {
                                    failure('上传失败: ' + json.message);
                                    return;
                                }
                                // 成功了的处理
                                cb(json.result.url);
                            };
                            formData = new FormData();
                            formData.append('imgFile', file, file.name );
                            xhr.send(formData);
                        }
                    },
                },
                tinymceFlag:1,
            }
        },
        components:{
            Editor
        },
        model: {
            prop: 'value',
        },
        props: {
            value: {
                type: String,
                default: ''
            }
        },
        mounted() {
            // tinymce.init({});
            this.tinymceFlag++
            this.tinymce_value = this.value
        },
        beforeDestroy(){
            tinymce.remove();
        },
    }
</script>