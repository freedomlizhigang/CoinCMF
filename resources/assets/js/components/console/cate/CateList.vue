<template>
  <div class="cate-list">
    <Form :model="formItem" ref="formItem" :inline="true" action="javascript:void(0)">
      <FormItem>
        <Select v-model="formItem.cateid" :style="{'width':'180px'}">
          <Option v-for="item in cateSelect" :value="item.value" :key="item.value">{{ item.label }}</Option>
        </Select>
      </FormItem>
      <FormItem>
        <Button type="primary" @click="renderTable('formItem')">筛选</Button>
      </FormItem>
    </Form>

    <!-- 上传 -->
    <upload-img refname="upload"></upload-img>

    <!-- 编辑器 -->
    <editor-bar v-model="editor.info" :isClear="isClear" @change="change"></editor-bar>

  </div>
</template>

<script>
import EditorBar from '../common/editor'
import UploadImg from '../common/upload'
export default {
    name: 'cate-list',
    data () {
        return {
            cateSelect:[
            ],
            formItem:{
                'cateid':'',
            },
            // 编辑器用的
            editor: {
                info: ''
            },
            isClear: false,
        }
    },
    // 计算
    computed: {
    },
    // 监听
    watch:{
    },
    components: {
        EditorBar,
        UploadImg,
    },
    created: function () {
        // 取数据
        this.getData1();
    },
    methods:{
        // 富文本更新时取值
        change (val) {
            this.editor.info1 = val
            console.log(val)
        },
        getData1:function(){
            var self = this;
            axios.get('/c-api/cate/select').then(function(res){
                // console.log(res.data)
                // self.$Message.success('数据加载成功...');
                self.cateSelect = res.data.data;
                },function(res){
                self.$Message.error('栏目数据加载失败...');
            });
            return;
        },
        // 筛选
        renderTable:function(name) {
            var self = this;
            var ps = {'cateid':self.formItem.cateid};
        },
        // 选中栏目
        selectCateid:function(index){
            // 选择
            if (index.length) {
            this.formItem.cateid = index[0].cateid;
            }
            console.log(index)
        },
    },
}
</script>