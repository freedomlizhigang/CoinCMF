<template>
    <div class="admin-edit-pwd">
        <Form ref="adminPwd" :model="adminPwd" :rules="adminPasswordValidate" action="javascript:void(0)" :loading="loading">
            <FormItem label="密码" prop="password">
                <Input v-model="adminPwd.password" type="password" placeholder="输入密码..."></Input>
            </FormItem>
            <FormItem label="确认密码">
                <Input v-model="adminPwd.password_confirmation" type="password" placeholder="确认密码..."></Input>
            </FormItem>
            <FormItem>
                <Button type="primary" @click="handleSubmit('adminPwd')">提交</Button>
            </FormItem>
        </Form>
    </div>
</template>


<script>
    import { LOGOUT,LOGIN } from '../../.././vuex/mutation_types'
    export default {
        name: 'admin-edit-pwd',
        data () {
            return {
                loading: true,
                admin_id:this.$store.getters.user_id,
                adminPwd:{
                    password:'',
                    password_confirmation:'',
                },
                adminPasswordValidate: {
                    password: [
                        { required: true, message: '密码必须填写', trigger: 'blur' },
                        { type: 'string', min: 6, max:15, message: '密码 6 - 15 位长度', trigger: 'blur' }
                    ]
                },
            }
        },
        created:function(){
        },
        methods: {
            handleSubmit(name) {
                this.$refs[name].validate((valid) => {
                    if (valid) {
                        this.$api.admin.selfeditpassword({admin_id:this.admin_id,password:this.adminPwd.password,password_confirmation:this.adminPwd.password_confirmation}).then(res=>{
                            if(res.code == 200)
                            {
                                this.$Message.success(res.msg);
                                setTimeout(()=>{
                                    // 跳转到登录
                                    this.$store.commit(LOGOUT)
                                    this.$router.push('/console/login');
                                },2000);
                            }
                            this.loading = false;
                            this.$nextTick(() => {this.loading = true;});
                        });
                    } else {
                        this.$Message.error('请检查输入的信息是否正确！');
                        this.loading = false
                        this.$nextTick(() => {this.loading = true;});
                    }
                })
            },
        }
    }
</script>