<template>
    <div class="admin-edit-pwd">
        <Form ref="adminData" :model="adminInfo" :rules="adminValidate" action="javascript:void(0)">
            <FormItem label="密码" prop="password">
                <Input v-model="adminInfo.password" type="password" placeholder="输入密码..."></Input>
            </FormItem>
            <FormItem label="确认密码">
                <Input v-model="adminInfo.password_confirmation" type="password" placeholder="确认密码..."></Input>
            </FormItem>
            <FormItem>
                <Button type="primary" @click="handleSubmit('adminData')">提交</Button>
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
                adminInfo:{
                    password:'',
                    password_confirmation:'',
                },
                adminValidate: {
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
                        var params = this.adminInfo;
                        params.admin_id = this.$store.getters.user_id;
                        this.$api.admin.selfeditpassword(params).then(res=>{
                            if (res.code == 200) {
                                this.$Message.success('修改成功，请重新登录...');
                                this.$store.commit(LOGOUT)
                                // 跳转到登录
                                this.$router.push('/');
                            }
                        });
                    }
                })
            },
        }
    }
</script>