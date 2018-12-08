<template>
    <div class="admin-edit-info">
        <Form ref="adminInfo" :model="adminInfo" :rules="adminEditValidate" action="javascript:void(0)" :loading="loading">
            <FormItem label="姓名" prop="realname">
                <Input v-model="adminInfo.realname" placeholder="输入姓名..."></Input>
            </FormItem>
            <FormItem label="手机号">
                <Input v-model="adminInfo.phone" placeholder="输入手机号..."></Input>
            </FormItem>
            <FormItem label="邮箱">
                <Input v-model="adminInfo.email" placeholder="输入邮箱..."></Input>
            </FormItem>
            <FormItem>
                <Button type="primary" @click="handleSubmit('adminInfo')">提交</Button>
            </FormItem>
        </Form>
    </div>
</template>


<script>
    export default {
        name: 'admin-edit-info',
        data () {
            return {
                loading: true,
                admin_id:this.$store.getters.user_id,
                adminInfo:{
                    realname:'',
                    phone:'',
                    email:'',
                },
                adminEditValidate: {
                    realname: [
                        { required: true, message: '姓名必须填写', trigger: 'blur' },
                        { type: 'string', min: 2, max:15, message: '姓名 3 - 15 位长度', trigger: 'blur' }
                    ]
                },
            }
        },
        created:function(){
            this.getInfo();
        },
        methods: {
            handleSubmit(name) {
                this.$refs[name].validate((valid) => {
                    if (valid) {
                        this.$api.admin.selfeditinfo({admin_id:this.admin_id,realname:this.adminInfo.realname,phone:this.adminInfo.phone,email:this.adminInfo.email}).then(res=>{
                            if(res.code == 200)
                            {
                                this.$Message.success(res.msg);
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
            getInfo:function(){
                // 取信息
                this.$api.admin.detail({admin_id:this.admin_id}).then(res=>{
                    if(res.code == 200)
                    {
                        this.adminInfo = res.data;
                        this.$Message.success(res.msg);
                    }
                    this.loading = false;
                    this.$nextTick(() => {this.loading = true;});
                    this.showEditInfo = !this.showEditInfo;
                });
            },

        }
    }
</script>