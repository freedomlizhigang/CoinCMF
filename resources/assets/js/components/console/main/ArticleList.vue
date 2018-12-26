<template>
  <div class="article-list">
    <Form :model="formItem" ref="formItem" :inline="true" action="javascript:void(0)">
      <FormItem>
        <Select v-model="formItem.cateid" :style="{'width':'180px'}">
            <Option value="" key="全部">全部</Option>
            <Option v-for="item in cateSelect" :value="item.value" :key="item.value">{{ item.label }}</Option>
        </Select>
      </FormItem>
      <FormItem>
        <DatePicker v-model="formItem.datetime" type="datetimerange" format="yyyy-MM-dd HH:mm" style="width: 260px" placeholder="开始时间 - 结束时间"></DatePicker>
      </FormItem>
      <FormItem>
        <Input v-model="formItem.key" placeholder="输入关键字查询..."></Input>
      </FormItem>
      <FormItem>
        <Button type="primary" @click="renderTable('formItem')">筛选</Button>
      </FormItem>
    </Form>
    <Table :columns="columns1" ref="selection" @on-selection-change="changeData" :data="tablelist" :loading="dataloading"></Table>
    <div style="margin: 10px;overflow: hidden">
        <Button @click="deleteData" type="error">删除</Button>
        <div style="float: right;">
            <Page ref="listPage" :total="pages.total" :current="pages.current" :page-size="pages.size" show-elevator show-total @on-change="changePage()"></Page>
        </div>
    </div>
  </div>
</template>

<script>
export default {
    name: 'article-list',
    data () {
        return {
            dataloading: true,
            cateSelect:[],
            formItem:{
                'key':'',
                'cateid':'',
                'datetime':''
            },
            pages:{
                current:1,
                total:0,
                size:10
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
              /*{
                  title: 'Hits',
                  width:100,
                  key: 'hits'
              },*/
              {
                  title: 'Cate',
                  width:150,
                  key: 'catename'
              },
              /*{
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
              },*/
              {
                title: 'Action',
                key: 'action',
                width:130,
                align: 'left',
                render: (h, params) => {
                    return h('div', [
                        h('Button', {
                            props: {
                                type: 'info',
                                size: 'small'
                            },
                            style: {
                                marginRight: '5px'
                            },
                            on: {
                                click: () => {
                                    this.edit(params.row.id)
                                }
                            }
                        }, '修改'),
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
    },
    // 监听
    watch:{
    },
    created: function () {
        // 取数据
        this.getTableList();
    },
    methods:{
        getTableList:function(){
            var self = this;
            this.$api.cate.select().then(res=>{
                if(res.code == 200)
                {
                    self.cateSelect = res.data;
                }
            });
            var params = {page:this.pages.current,size:this.pages.size};
            this.$api.article.list(params).then(res=>{
                this.dataloading = false;
                if(res.code == 200)
                {
                    self.tablelist = res.data.list;
                    this.pages.total = res.data.total
                    this.$Message.success(res.msg);
                }
            });
            return;
        },
        changePage(){
            this.pages.current = this.$refs['listPage'].currentPage;
            this.getTableList();
        },
        edit:function(index){
            this.$router.push('/console/art/edit/' + index);
        },
        remove:function(index){
            // 弹出确认框
            this.$Modal.confirm({
                title: '警告',
                content: '<p>此操作不可恢复，三思而后行...</p>',
                onOk: () => {
                    this.$api.article.remove({article_id:index}).then(res=>{
                        if(res.code == 200)
                        {
                            this.$Message.success(res.msg);
                            this.tablelist.splice(index, 1);
                        }
                    });
                }
            });
        },
        sort:function(index){
            console.log('sort:' + index)
        },
        // 选择文章id
        changeData:function(index){
            this.selectData = index
        },
        // 批量删除
        deleteData:function(){
            // 弹出确认框
            this.$Modal.confirm({
                title: '警告',
                content: '<p>此操作不可恢复，三思而后行...</p>',
                onOk: () => {
                    var ids = [];
                    this.selectData.forEach((item,index)=>{
                        ids.push(item.id);
                    })
                    this.$api.article.deleteall({ids:ids}).then(res=>{
                        if(res.code == 200)
                        {
                            this.$Message.success(res.msg);
                            this.getTableList();
                        }
                    });
                }
            });
        },
        // 筛选
        renderTable:function(name) {
            var self = this;
            var starttime = self.formItem.datetime[0] != '' ? self.formItem.datetime[0].getTime() : '';
            var endtime = self.formItem.datetime[1] != '' ? self.formItem.datetime[1].getTime() : '';
            var ps = {page:1,size:this.pages.size,'key':self.formItem.key,'cateid':self.formItem.cateid,'starttime':starttime,'endtime':endtime};
            this.$api.article.list(ps).then(res=>{
                this.dataloading = false;
                if(res.code == 200)
                {
                    self.tablelist = res.data.list;
                    this.pages.total = res.data.total
                    this.$Message.success(res.msg);
                }
            });
            return;
        }
    },
}
</script>
