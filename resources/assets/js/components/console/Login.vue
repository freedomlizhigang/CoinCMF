<template>
  <div id="login">
    <Row>
        <Col :xs="{ span: 18, offset: 3 }" :md="{ span: 12, offset: 6 }" :lg="{ span: 6, offset: 9 }">
            <h2 class="login-header"><img src="/img/login_logo.png" width="70" alt=""></h2>
            <Form :model="user" ref="user" :rules="ruleInline" action="javascript:void(0)">
                <FormItem prop="name">
                    <Input v-model="user.name" placeholder="请输入用户名..."></Input>
                </FormItem>
                <FormItem prop="password">
                    <Input v-model="user.password" type="password" placeholder="请输入密码..."></Input>
                </FormItem>
                <FormItem>
                    <Button type="success" long @click="loginSubmit('user')">提交</Button>
                </FormItem>
            </Form>
        </Col>
    </Row>
  </div>
</template>

<style>
    #login {
        margin-top: 180px;
    }
    .login-header {
        text-align: center;
    }
</style>

<script>
import router from '../.././router'
import { LOGOUT,LOGIN } from '../.././vuex/mutation_types'
export default {
    data() {
        return {
            user:{
                name:'',
                password:'',
            },
            ruleInline: {
                name: [
                    { required: true, message: '请输入用户名...', trigger: 'blur' },
                    { type: 'string', min: 2, max:15, message: '用户名 3 - 15 位长度', trigger: 'blur' }
                ],
                password: [
                    { required: true, message: '请输入密码...', trigger: 'blur' },
                    { type: 'string', min: 6, max:15, message: '密码 6 - 15 位长度', trigger: 'blur' }
                ]
            }
        }
    },
    methods: {
        // 验证输入
        loginSubmit(name) {
            this.$refs[name].validate((valid) => {
                if (valid) {
                    var params = {'name':this.user.name,'password':this.user.password};
                    this.$api.login.login(params).then(res=>{
                        this.$store.commit(LOGIN,res.data)
                        // 跳转到首页
                        router.push('/console/index/index');
                    });
                } else {
                    this.$Message.error('请检查输入的信息是否正确！');
                }
            })
        },
    }
}
</script>