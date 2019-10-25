<template>
  <div class="log-list">
    <Row>
        <Col :xs="24" :sm="12">
            <Form :model="formItem" ref="formItem" :inline="true" action="javascript:void(0)">
                <FormItem>
                    <Select v-model="formItem.admin_id" :style="{'width':'180px'}">
                        <Option v-for="item in adminList" :value="item.id" :key="item.id">{{ item.name }}</Option>
                    </Select>
                </FormItem>
                <FormItem>
                    <Button type="primary" @click="renderTable('formItem')">筛选</Button>
                </FormItem>
            </Form>
        </Col>
        <Col :xs="24" :sm="12">
            <Button @click="clearLog()" type="default" class="f-r">清除日志</Button>
        </Col>
    </Row>
    <Table border :columns="columns" ref="tableList" :data="tablelist" :loading="dataloading" class="mt10"></Table>
    <div style="margin: 10px;overflow: hidden">
        <div style="float: right;">
            <Page ref="listPage" :total="pages.total" :current="pages.current" :page-size="pages.size" show-elevator show-total @on-change="changePage()"></Page>
        </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'log-list',
  data () {
    return {
        dataloading: true,
        formItem:{
            admin_id:0
        },
        pages:{
            current:1,
            total:0,
            size:10
        },
        columns: [
          {
              title: 'Id',
              key: 'id',
              width:80,
          },
          {
            title: '用户名',
            width:100,
            key: 'user',
          },
          {
            title: '操作方式',
            width:100,
            key: 'method',
          },
          {
            title: '操作',
            width:150,
            key: 'action_name',
          },
          {
            title: '操作地址',
            minWidth:200,
            key: 'url',
          }
        ],
        tablelist: [],
        adminList: [],
    }
  },
  created: function () {
    // 取数据
    this.getTableList();
    // 管理员信息
    var params = {};
    this.$api.admin.list(params).then(res=>{
        if(res.code == 200)
        {
            this.adminList = res.data;
        }
    });
  },
  methods:{
    getTableList:function(){
        var params = {page:this.pages.current,size:this.pages.size};
        this.$api.log.list(params).then(res=>{
            this.dataloading = false;
            if(res.code == 200)
            {
                this.tablelist = res.data.list;
                this.pages.total = res.data.total
                this.$Message.success(res.msg);
            }
        });
    },
    // 翻页
    changePage() {
        this.pages.current = this.$refs['listPage'].currentPage;
        this.getTableList();
    },
    // 清除日志
    clearLog(){
        // 弹出确认框
        this.$Modal.confirm({
            title: '警告',
            content: '<p>确认清除七天前的所有日志吗？</p><p>此操作不可恢复，三思而后行...</p>',
            onOk: () => {
                this.$api.log.clear().then(res=>{
                    if(res.code == 200)
                    {
                        this.$Message.success(res.msg);
                    }
                });
            },
            onCancel: () => {
            }
        });
    },
    // 筛选
    renderTable(name){
        var params = {page:1,size:this.pages.size,admin_id:this.formItem.admin_id};
        this.$api.log.list(params).then(res=>{
            this.dataloading = false;
            if(res.code == 200)
            {
                this.tablelist = res.data.list;
                this.pages.current = 1;
                this.pages.total = res.data.total
                this.$Message.success(res.msg);
            }
        });
    },
  },
}
</script>
