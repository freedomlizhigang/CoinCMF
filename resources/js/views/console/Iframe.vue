<template>
<div class="layout">
    <Layout :style="{height:'100vh'}">
        <Sider breakpoint="md" :collapsed-width="78" v-model="isCollapsed" :style="{zIndex:'900'}">
            <div class="logo-img">
                <a href="/#/index/index"><img src="/statics/console/img/logo.png" alt=""></a>
            </div>
            <Menu active-name="1-2" width="auto" :class="menuitemClasses" accordion>
                <!-- 一级分类 -->
                <div :name="one.name" theme="light" v-for="one in menuData" :key="one.id">
                    <div class="left_one">
                        <Icon type="ios-more" />
                        {{ one.name }}
                    </div>
                    <!-- 二级分类 -->
                    <Submenu :name="two.name" theme="light" v-for="two in one.submenu" :key="two.id">
                        <template slot="title">
                        <Icon :type="two.icon" />
                            {{ two.name }}
                        </template>
                        <!-- 三级分类 -->
                        <MenuItem :name="there.name" v-for="there in two.there" :key="there.id" :to="'/' + there.url">{{ there.name }}
                            <Icon type="ios-arrow-round-forward" :style="{float: 'left'}" />
                        </MenuItem>
                    </Submenu>
                </div>
            </Menu>
        </Sider>
        <Layout>
            <Header class="layout-header-bar">
                <Breadcrumb class="f-l bread">
                    <BreadcrumbItem v-for="item in breadCrumbList" :to="item.to" :key="item.id">{{ item.name }}</BreadcrumbItem>
                </Breadcrumb>
                <!-- 退出 -->
                <Button class="right-top-btn" icon="ios-power" type="text" ghost @click="handleDropDownClick('logout')"></Button>
            </Header>
            <!-- 标题 + 按钮组 -->
            <div class="right_top_bg clearfix">
                <div class="right_top clearfix">
                    <h4 class="f-l right-titles">{{ title }}</h4>
                    <div class="f-r">
                        <Button :icon="item.icon" class="right_top_btns" :to="'/' + item.url" v-for="item in btns" :key="item.id">{{ item.name }}</Button>
                    </div>
                </div>
            </div>
            <Content :style="{ padding:'15px', background: '#fff'}">
                <router-view></router-view>
            </Content>
            <Footer class="layout-footer-center">2018-2021 &copy; 山木枝</Footer>
        </Layout>
    </Layout>
</div>
</template>
<script>
import console_router from '../.././router/console'
import { LOGOUT } from '../.././store/mutation_types'
export default {
  data() {
    return {
      isCollapsed: false, // 侧栏开关
      menuData: [], // 左侧菜单
      breadCrumbList: [], // 面包屑
      title: '首页', // 标题
      btns: [] // 功能按钮组
    };
  },
  computed: {
    // 登录状态
    username() {
      return this.$store.getters.user_id != 0 ? this.$store.getters.user_name : '未登陆'
    },
    menuitemClasses: function() {
      return [
        'menu-item',
        this.isCollapsed ? 'collapsed-menu' : ''
      ]
    }
  },
  created: function() {
    this.getMenuData();
    // 初始化面包屑及标题+按钮组
    var params = { 'label': this.$route.name };
    this.$api.common.breadcrumb(params).then(res => {
      this.breadCrumbList = res.result.breadcrumb;
      this.title = res.result.title;
      this.btns = res.result.btns;
    });
    // 路由结束后更新面包屑及标题+按钮组
    console_router.afterEach((to, from) => {
      var params = { 'label': to.name };
      // 这里是个大坑，不判断登录页面会在退出时让登录页面进入死循环，全局的钩子还是要少加为好
      if (to.name !== 'login') {
        this.$api.common.breadcrumb(params).then(res => {
          this.breadCrumbList = res.result.breadcrumb;
          this.title = res.result.title;
          this.btns = res.result.btns;
        });
      }
    })
  },
  methods: {
    handleDropDownClick: function(name) {
      if (name == 'logout') {
        this.$store.commit(LOGOUT)
        // 跳转到登录
        console_router.push('/');
      }
    },
    getMenuData: function() {
      var self = this
      this.$api.menu.left().then(res => {
        self.menuData = res.result
      });
    }
  }
}
</script>
