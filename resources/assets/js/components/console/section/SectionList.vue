<template>
  <div class="section-list">
    <Row>
        <Col :xs="24" :sm="12">
            <Form :model="formItem" ref="formItem" :inline="true" action="javascript:void(0)">
                <FormItem>
                    <Input v-model="formItem.key" placeholder="输入关键词查找..."></Input>
                </FormItem>
                <FormItem>
                    <Button type="primary" @click="renderTable('formItem')">筛选</Button>
                </FormItem>
            </Form>
        </Col>
        <Col :xs="24" :sm="12">
            <Button type="success" class="f-r">添加部门</Button>
        </Col>
    </Row>
    <Table :columns="list" ref="selection" :data="tablelist"></Table>
  </div>
</template>

<script>
export default {
    name: 'section-list',
    data () {
        return {
            formItem:{
            'key':'',
            },
            list: [
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
                    title: '名称',
                    minWidth:300,
                    key: 'name',
                    render: (h, params) => {
                        return h('div', [
                            h('Input', {
                                props: {
                                    value: params.row.name,
                                },
                                on: {
                                    'on-blur': (value) => {
                                        this.editName(params.row.id,value.target.value)
                                    }
                                }
                            }, '排序')
                        ]);
                    }
                },
                {
                    title: '状态',
                    key: 'status',
                    width:150,
                    render: (h, params) => {
                      return h('div', [
                          h('i-switch', {
                              props: {
                                value: params.row.status  //控制开关的打开或关闭状态，官网文档属性是value
                              },
                              on: {
                                'on-change': (value) => {
                                    this.changeStatus(params.row.id,value)
                                }
                              }
                          }, '开关')
                      ]);
                    }
                },
                {
                    title: '操作',
                    key: 'action',
                    width:80,
                    align: 'left',
                    render: (h, params) => {
                        return h('div', [
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
          this.$api.section.list().then(res=>{
            if(res.code == 200)
            {
                this.tablelist = res.data;
                this.$Message.success(res.msg);
            }
            else
            {
                this.$Message.error(res.msg);
            }
          });
          return;
        },
        editName:function(index,value){
            this.$api.section.edit({section_id:index,name:value}).then(res=>{
                if(res.code == 200)
                {
                    this.$Message.success(res.msg);
                }
                else
                {
                    this.$Message.error(res.msg);
                }
            });
        },
        remove:function(index){
            this.$api.section.remove({section_id:index}).then(res=>{
                if(res.code == 200)
                {
                    this.$Message.success(res.msg);
                }
            });
        },
        changeStatus:function(index,value){
            this.$api.section.status({section_id:index,status:value}).then(res=>{
                if(res.code == 200)
                {
                    this.$Message.success(res.msg);
                }
                else
                {
                    this.$Message.error(res.msg);
                }
            });
        },
        // 筛选
        renderTable:function(name) {
          var ps = {'key':this.formItem.key};
          console.log(ps)
          this.$api.section.list(ps).then(res=>{
            if(res.code == 200)
            {
                this.tablelist = res.data;
                this.$Message.success(res.msg);
            }
            else
            {
                this.$Message.error(res.msg);
            }
          });
          return;
        }
    },
}
</script>
