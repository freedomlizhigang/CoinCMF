<template>
  <div class="article-list">
    <Form :model="formItem" ref="formItem" :inline="true">
      <FormItem>
        <Select v-model="formItem.cateid">
            <Option value="beijing">New York</Option>
            <Option value="shanghai">London</Option>
            <Option value="shenzhen">Sydney</Option>
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
    <Table :columns="columns1" ref="selection" @on-selection-change="changeData" :data="data1"></Table>
    <Button @click="deleteData">Delete all selected</Button>
  </div>
</template>

<script>
export default {
  name: 'article-list',
  data () {
    return {
      cateSelect:{},
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
                  }, 'Delete')
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
                    }, 'View'),
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
                    }, 'Delete')
                ]);
            }
          }
      ],
      data1: [],
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
    this.getData1();
  },
  methods:{
    getData1:function(){
      var self = this;
      axios.get('/c-api/cate/select').then(function(res){
        console.log(res.data)
        self.$Message.success('数据加载成功...');
        self.cateSelect = res.data.data;
      },function(res){
        self.$Message.error('数据加载失败...');
      });
      axios.get('/c-api/article/list').then(function(res){
        // console.log(res.data)
        self.$Message.success('数据加载成功...');
        self.data1 = res.data.data;
      },function(res){
        self.$Message.error('数据加载失败...');
      });
      return self.data1;
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
      var ps = {'key':self.formItem.key,'cateid':self.formItem.cateid,'starttime':self.formItem.datetime[0].getTime(),'endtime':self.formItem.datetime[1].getTime()};
      axios.get('/c-api/article/list',{params:ps}).then(function(res){
        // console.log(res.data)
        self.$Message.success('数据加载成功...');
        self.data1 = res.data.data;
      },function(res){
        self.$Message.error('数据加载失败...');
      });
      return self.data1;
    }
  },
}
</script>
