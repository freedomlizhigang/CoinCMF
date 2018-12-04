<template>
  <div class="article-list">
    <Form :model="formItem" ref="formItem" :inline="true" action="javascript:void(0)">
      <FormItem>
        <Select v-model="formItem.cateid" :style="{'width':'180px'}">
          <Option v-for="item in cateSelect" :value="item.value" :key="item.value">{{ item.label }}</Option>
        </Select>
      </FormItem>
      <FormItem>
        <DatePicker v-model="formItem.datetime" type="datetimerange" format="yyyy-MM-dd HH:mm" style="width: 260px" placeholder="开始时间 - 结束时间"></DatePicker>
      </FormItem>
      <FormItem>
        <Input v-model="formItem.key" placeholder="Enter something..."></Input>
      </FormItem>
      <FormItem>
        <Button type="primary" @click="renderTable('formItem')">筛选</Button>
      </FormItem>
    </Form>
    <Table :columns="columns1" ref="selection" @on-selection-change="changeData" :data="tablelist"></Table>
    <Button @click="deleteData" type="error" class="mt10">删除</Button>
  </div>
</template>

<script>
export default {
  name: 'article-list',
  data () {
    return {
      cateSelect:[],
      formItem:{
        'key':'',
        'cateid':'',
        'datetime':''
      },
      columns1: [
          {
              type: 'selection',
              width: 60,
              align: 'center',
              fixed: 'left'
          },
          {
              title: 'Id',
              key: 'id',
              width:80,
              fixed: 'left'
          },
          {
              title: 'Title',
              minWidth:300,
              key: 'title'
          },
          {
              title: 'Hits',
              width:100,
              key: 'hits'
          },
          {
              title: 'Cate',
              width:150,
              key: 'catename'
          },
          {
            title: 'Sort',
            key: 'sort',
            width:150,
            render: (h, params) => {
              return h('div', [
                  h('InputNumber', {
                      props: {
                        min: 0,
                        value: params.row.sort,
                        size: 'small',
                        number: true
                      },
                      on: {
                        'on-change': () => {
                          this.sort(params.row.id)
                        }
                      }
                  }, '排序')
              ]);
            }
          },
          {
            title: 'Action',
            key: 'action',
            width:200,
            align: 'left',
            render: (h, params) => {
                return h('div', [
                    h('Button', {
                        props: {
                            type: 'primary',
                            size: 'small'
                        },
                        style: {
                            marginRight: '5px'
                        },
                        on: {
                            click: () => {
                                this.show(params.row.id)
                            }
                        }
                    }, '查看'),
                    h('Button', {
                        props: {
                            type: 'error',
                            size: 'small'
                        },
                        on: {
                            click: () => {
                                this.remove(params.row.id)
                            }
                        }
                    }, '删除')
                ]);
            }
          }
      ],
      tablelist: [],
      selectData:[],
    }
  },
  // 计算
  computed: {
    /*formItem2: function () {
      console.log(this.formItem.input + ' ' + this.formItem.inputss);
      return this.formItem.input + ' ' + this.formItem.inputss;
    }*/
  },
  // 监听
  watch:{
    // 尝试监听一个对象
    /*formItem:{
      handler(newName, oldName) {
        this.formItem.inputss = newName.input;
      },
      deep: true
    }*/
  },
  created: function () {
    // 取数据
    this.getTableList();
  },
  methods:{
    getTableList:function(){
      var self = this;
      axios.get('/c-api/cate/select').then(function(res){
        // console.log(res.data)
        // self.$Message.success('数据加载成功...');
        self.cateSelect = res.data.data;
      },function(res){
        self.$Message.error('栏目数据加载失败...');
      });
      axios.get('/c-api/article/list').then(function(res){
        // console.log(res.data)
        self.$Message.success('文章数据加载成功...');
        self.tablelist = res.data.data;
      },function(res){
        self.$Message.error('数据加载失败...');
      });
      return;
    },
    show:function(index){
      console.log('show:' + index);
    },
    remove:function(index){
      console.log('remove:' + index)
    },
    sort:function(index){
      console.log('sort:' + index)
    },
    changeData:function(index){
      this.selectData = index
    },
    deleteData:function(){
      this.selectData.forEach((item,index)=>{
        console.log(item.id)
      })
    },
    // 筛选
    renderTable:function(name) {
      var self = this;
      var starttime = self.formItem.datetime[0] != '' ? self.formItem.datetime[0].getTime() : '';
      var endtime = self.formItem.datetime[1] != '' ? self.formItem.datetime[1].getTime() : '';
      var ps = {'key':self.formItem.key,'cateid':self.formItem.cateid,'starttime':starttime,'endtime':endtime};
      axios.get('/c-api/article/list',{params:ps}).then(function(res){
        // console.log(res.data)
        self.$Message.success('文章数据加载成功...');
        self.tablelist = res.data.data;
      },function(res){
        self.$Message.error('数据加载失败...');
      });
      return;
    }
  },
}
</script>
