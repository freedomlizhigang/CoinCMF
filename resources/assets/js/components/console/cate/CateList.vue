<template>
  <div class="cate-list">
    <Form :model="formItem" ref="formItem" :inline="true">
      <FormItem>
        <Select v-model="formItem.cateid" :style="{'width':'180px'}">
          <Option v-for="item in cateSelect" :value="item.value" :key="item.value">{{ item.label }}</Option>
        </Select>
      </FormItem>
      <FormItem>
        <Button type="primary" @click="renderTable('formItem')">筛选</Button>
      </FormItem>
    </Form>
  </div>
</template>

<script>
export default {
  name: 'cate-list',
  data () {
    return {
      cateSelect:[

      ],
      formItem:{
        'cateid':'',
      },
    }
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
