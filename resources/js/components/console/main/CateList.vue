<template>
  <div class="cate-list">
    <Row>
        <Col :xs="24">
            <Button @click="showCreate(0)" type="success" class="f-r">添加栏目</Button>
        </Col>
    </Row>
    <Table height="600" :columns="columns" ref="tableList" :data="tablelist" :loading="dataloading" class="mt10"></Table>
    <!-- 添加的弹出 -->
    <Modal v-model="showModalStatus" title="添加栏目" @on-ok="cateCreateEdit('cateValidate')" :loading="loading">
        <Form :model="cate" ref="cateValidate" :rules="cateValidate" action="javascript:void(0)">
            <FormItem label="栏目名称" prop="name">
                <Input v-model="cate.name" placeholder="输入栏目名称..."></Input>
            </FormItem>
            <FormItem label="排序">
                <InputNumber :max="9999" :min="0" v-model="cate.sort"></InputNumber>
            </FormItem>
        </Form>
    </Modal>
  </div>
</template>

<script>
export default {
  name: 'cate-list',
  data () {
    return {
        loading: true,
        dataloading: true,
        columns: [
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
                return  h('span', {
                        style: {
                            marginLeft:params.row.left + 'px',
                        }
                    },params.row.name)
            }
          },
          {
            title: '排序',
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
                        'on-change': (value) => {
                          this.sort(params.row.id,value)
                        }
                      }
                  }, '排序')
              ]);
            }
          },
          {
            title: '操作',
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
                                this.showCreate(params.row.id)
                            }
                        }
                    }, '添加'),
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
                                this.showEdit(params.row.id)
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
        cate:{
            cate_id:0,
            parentid:0,
            name:'',
            sort:0,
        },
        showModalStatus:false,
        cateValidate: {
            name: [
                { required: true, message: '名称必须填写', trigger: 'blur' }
            ]
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
    this.getTableList();
  },
  methods:{
    getTableList:function(){
        this.$api.cate.list().then(res=>{
            // console.log(res)
            this.dataloading = false;
            if(res.code == 200)
            {
                this.tablelist = res.data;
                this.$Message.success(res.msg);
            }
        });
        return;
    },
    // 展开添加
    showCreate(parentid){
        this.showModalStatus = !this.showModalStatus;
        this.cate.parentid = parentid;
        this.cate.cate_id = 0;
        this.cate.name = '';
        this.cate.sort = 0;
    },
    // 添加||修改
    cateCreateEdit(name){
        this.$refs[name].validate((valid) => {
            if (valid) {
                // 判断是添加还是修改
                if (this.cate.cate_id === 0) {
                    this.$api.cate.create({parentid:this.cate.parentid,name:this.cate.name,sort:this.cate.sort}).then(res=>{
                        if(res.code == 200)
                        {
                            this.cate.parentid = 0;
                            this.cate.cate_id = 0;
                            this.getTableList();
                        }
                        this.loading = false;
                        this.$nextTick(()=>{this.loading = true;});
                        this.showModalStatus = !this.showModalStatus;
                    });
                }
                else
                {
                    this.$api.cate.edit({cate_id:this.cate.cate_id,name:this.cate.name,sort:this.cate.sort}).then(res=>{
                        if(res.code == 200)
                        {
                            this.cate.parentid = 0;
                            this.cate.cate_id = 0;
                            this.getTableList();
                        }
                        this.loading = false;
                        this.$nextTick(()=>{this.loading = true;});
                        this.showModalStatus = !this.showModalStatus;
                    });
                }
            } else {
                this.$Message.error('请检查输入的信息是否正确！');
                this.loading = false
                this.$nextTick(() => {this.loading = true;});
            }
        })
    },
    // 展开修改
    showEdit:function(id){
        this.$api.cate.detail({cate_id:id}).then(res=>{
            if(res.code == 200)
            {
                this.showModalStatus = !this.showModalStatus;
                this.cate = res.data;
                this.cate.cate_id = res.data.id;
                this.loading = false;
                this.$nextTick(()=>{this.loading = true;});
            }
        });
    },
    // 删除
    remove:function(id){
        // 弹出确认框
        this.$Modal.confirm({
            title: '警告',
            content: '<p>此操作不可恢复，三思而后行...</p>',
            onOk: () => {
                this.$api.cate.remove({cate_id:id}).then(res=>{
                    if(res.code == 200)
                    {
                        this.$Message.success(res.msg);
                        this.getTableList();
                    }
                });
            }
        });
    },
    sort:function(id,sort){
        this.$api.cate.sort({cate_id:id,sort:sort}).then(res=>{
            if(res.code == 200)
            {
                this.$Message.success(res.msg);
            }
        });
    },
  },
}
</script>
