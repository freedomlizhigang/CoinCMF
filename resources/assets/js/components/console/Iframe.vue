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
<div class="layout">
    <Layout :style="{height:'100vh'}">
      <Sider breakpoint="md" collapsible :collapsed-width="78" v-model="isCollapsed" :style="{zIndex:'1'}">
        <div class="logo-img"><img src="/img/logo.png" alt=""></div>
        <Menu active-name="1-2" theme="dark" width="auto" :class="menuitemClasses" accordion>
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
                    <Avatar src="https://i.loli.net/2017/08/21/599a521472424.jpg" /> {{ username }}
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
          <!-- 标题 + 按钮组 -->
          <Card :bordered="false" class="clearfix" :style="{margin: '15px',marginBottom:'0',padding:'0 0 10px 0'}">
            <h4 class="f-l" :style="{color:'#515A6E'}">{{ title }}</h4>
            <div class="f-r">
              <Button :icon="item.icon" :to="'/console/' + item.url" v-for="item in btns">{{ item.name }}</Button>
            </div>
          </Card>
          <Content :style="{margin: '15px', padding:'15px', background: '#fff', minHeight: '220px', overflow:'hidden'}">
              <router-view></router-view>
          </Content>
          <Footer class="layout-footer-center">2018-2021 &copy; 山木枝</Footer>
      </Layout>
    </Layout>
</div>
</template>
<script>
    import router from '../.././router'
    import store from '../.././vuex/store'
    import { LOGOUT,LOGIN } from '../.././vuex/mutation_types'
    export default {
        data () {
          return {
            isCollapsed: false,  // 侧栏开关
            menuData:[],  // 左侧菜单
            breadCrumbList:[], // 面包屑
            title:'首页', // 标题
            btns:[], // 功能按钮组
          };
        },
        computed: {
            // 登录状态
            username() {
                return store.getters.user_id != 0 ? store.getters.user_name : '未登陆'
            },
            menuitemClasses: function () {
                return [
                    'menu-item',
                    this.isCollapsed ? 'collapsed-menu' : ''
                ]
          },
        },
        created:function(){
          this.getMenuData();
          var self = this
          // 初始化面包屑及标题+按钮组
          axios.get('/c-api/breadcrumb/list',{params:{'label':this.$route.name}}).then(function(res){
            if (res.data.code == 200) {
              self.breadCrumbList = res.data.data.breadcrumb;
              self.title = res.data.data.title;
              self.btns = res.data.data.btns;
            }
            else
            {
              self.$Message.error(res.data.msg);
            }
          },function(res){
            self.$Message.error('面包屑数据加载失败...');
          });
          // 路由结束后更新面包屑及标题+按钮组
          router.afterEach((to, from) => {
            axios.get('/c-api/breadcrumb/list',{params:{'label':to.name}}).then(function(res){
              if (res.data.code == 200) {
                self.breadCrumbList = res.data.data.breadcrumb;
                self.title = res.data.data.title;
                self.btns = res.data.data.btns;
              }
              else
              {
                self.$Message.error(res.data.msg);
              }
            },function(res){
              self.$Message.error('面包屑数据加载失败...');
            });
          })
        },
        methods:{
          handleDropDownClick: function (name) {
            if (name == 'logout') {
                store.commit(LOGOUT)
                // 跳转到登录
                router.push('/console/login');
            }
          },
          getMenuData:function(){
              var self = this
              axios.get('/c-api/menu/list').then(function(res){
                // console.log(res.data)
                self.menuData = res.data.data;
              },function(res){
                self.$Message.error('数据加载失败...');
              });
              return self.menuData;
          },
        }
  }
</script>