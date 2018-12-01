<template>
  <div class="hello">
    <Table :columns="columns1" ref="selection" @on-selection-change="changeData" :data="data1"></Table>
    <Button @click="deleteData">Delete all selected</Button>
  </div>
</template>

<script>
export default {
  name: 'hello',
  data () {
    return {
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
  created: function () {
    // 取数据
    this.getData1();
  },
  methods:{
    getData1:function(){
      this.$http.get('c-api/article/list').then(function(res){
        // console.log(res.json())
        this.$Message.success('数据加载成功...');
        this.data1 = res.json().data;
      },function(res){
        this.$Message.error('数据加载失败...');
      });
      return this.data1;
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
    }
  },
}
</script>
