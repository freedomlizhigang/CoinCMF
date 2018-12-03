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
                                <Avatar src="/img/login_logo.png" /> {{ username }}
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
            <Content :style="{margin: '15px', padding:'15px', background: '#fff'}">
                <router-view></router-view>
            </Content>
            <Footer class="layout-footer-center">2018-2021 &copy; 山木枝</Footer>
      </Layout>
    </Layout>
</div>
</template>
<script>
    import router from '../.././router'
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
                return this.$store.getters.user_id != 0 ? this.$store.getters.user_name : '未登陆'
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
            var params = {'label':this.$route.name};
            this.$api.common.breadcrumb(params).then(res=>{
                this.breadCrumbList = res.data.breadcrumb;
                this.title = res.data.title;
                this.btns = res.data.btns;
            });
            // 路由结束后更新面包屑及标题+按钮组
            router.afterEach((to, from) => {
                var params = {'label':to.name};
                this.$api.common.breadcrumb(params).then(res=>{
                    this.breadCrumbList = res.data.breadcrumb;
                    this.title = res.data.title;
                    this.btns = res.data.btns;
                });
            })
        },
        methods:{
            handleDropDownClick: function (name) {
                if (name == 'logout') {
                    this.$store.commit(LOGOUT)
                    // 跳转到登录
                    router.push('/console/login');
                }
            },
            getMenuData:function(){
                var self = this
                this.$api.article.articleList().then(res=>{
                    this.menuData = res.data
                });
                return self.menuData;
            },
        }
  }
</script>