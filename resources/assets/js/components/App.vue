<style scoped>
    .layout{
        background: #f5f7f9;
        position: relative;
        overflow: hidden;
    }
    .layout-header-bar{
        background: #fff;
        box-shadow: 0 1px 1px rgba(0,0,0,.1);
    }
    .menu-item span{
        display: inline-block;
        overflow: hidden;
        width: 69px;
        text-overflow: ellipsis;
        white-space: nowrap;
        vertical-align: bottom;
        transition: width .2s ease .2s;
    }
    .menu-item i{
        transform: translateX(0px);
        transition: font-size .2s ease, transform .2s ease;
        vertical-align: middle;
        font-size: 16px;
    }
    .collapsed-menu span{
        width: 0px;
        transition: width .2s ease;
    }
    .collapsed-menu i{
        transform: translateX(5px);
        transition: font-size .2s ease .2s, transform .2s ease .2s;
        vertical-align: middle;
        font-size: 22px;
    }
    .logo-img {
      padding: 10px 0; display: block; text-align: center; background-color: #363E4F;
    }
    .menu-avatar {
      text-align: right;
    }
    .layout-footer-center{
      text-align: center;
    }
</style>

<template>
  <div id="app">
    <div class="layout">
      <Layout :style="{height:'100vh'}">
          <Sider breakpoint="md" collapsible :collapsed-width="78" v-model="isCollapsed">
            <div class="logo-img"><img src="/img/logo.png" alt=""></div>
            <Menu active-name="1-2" theme="dark" width="auto" :class="menuitemClasses" accordion :open-names="['1']">
              <Submenu :name="menu.name" v-for="menu in menuData" :key="menu.id">
                  <template slot="title">
                      <Icon type="ios-paper" />
                      {{ menu.name }}
                  </template>
                  <MenuItem :name="submenu.name" v-for="submenu in menu.submenu" :key="submenu.id" :to="'/console/' + submenu.url">{{ submenu.name }}</MenuItem>
              </Submenu>
            </Menu>
            <div slot="trigger"></div>
          </Sider>
          <Layout>
              <Header class="layout-header-bar">
                <Row>
                  <Col span="18" :xs="24" :sm="18">
                    <Breadcrumb>
                      <BreadcrumbItem v-for="item in breadCrumbList" :to="item.to">{{ item.name }}</BreadcrumbItem>
                    </Breadcrumb>
                  </Col>
                  <Col span="6" :xs="0" :sm="6" class-name="menu-avatar">
                    <Dropdown @on-click="handleDropDownClick($event)">
                      <a href="javascript:void(0)">
                        <Avatar src="https://i.loli.net/2017/08/21/599a521472424.jpg" /> 李大仙
                        <Icon type="ios-arrow-down"></Icon>
                      </a>
                      <DropdownMenu slot="list">
                          <DropdownItem name="example">个人资料</DropdownItem>
                          <DropdownItem name="logout">退出</DropdownItem>
                      </DropdownMenu>
                    </Dropdown>
                  </Col>
                </Row>
              </Header>
              <Content :style="{margin: '15px', padding:'15px', background: '#fff', minHeight: '220px'}">
                  <router-view></router-view>
              </Content>
              <Footer class="layout-footer-center">2018-2021 &copy; 山木枝</Footer>
          </Layout>
      </Layout>
    </div>
  </div>
</template>

<script>
  import router from './../router'
  export default {
    data () {
      return {
        isCollapsed: false,
        menuData:[],
        breadCrumbList:[]
      };
    },
    computed: {
      menuitemClasses: function () {
        return [
          'menu-item',
          this.isCollapsed ? 'collapsed-menu' : ''
        ]
      },
    },
    created:function(){
      this.getMenuData();
      // 更新面包屑
      this.breadCrumbList = [
        {'to':'/','name':'首页'},
      ];
      router.afterEach((to, from) => {
        // 路由结束后的通知，从后台获取数据
        this.breadCrumbList = [
          {'to':'/','name':'首页'},
          {'to':to.path,'name':"fdsa"}
        ];
      })
    },
    methods:{
      handleDropDownClick: function (name) {
        router.push(name);
      },
      getMenuData:function(){
          this.$http.get('c-api/menu/list').then(function(res){
            // console.log(res.json())
            this.menuData = res.json().data;
          },function(res){
            this.$Message.error('数据加载失败...');
          });
          return this.menuData;
      },
    }
  }
</script>
