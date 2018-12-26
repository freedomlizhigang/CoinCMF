<template>
    <div class="config">
        <Form ref="configData" :model="config" :rules="configValidate" action="javascript:void(0)">
            <FormItem label="项目名称" prop="sitename">
                <Input v-model="config.sitename" placeholder="请输入项目名称..."></Input>
            </FormItem>
            <FormItem label="项目介绍">
                <Input v-model="config.describe" type="textarea" :rows="4" placeholder="请输入项目介绍..."></Input>
            </FormItem>
            <FormItem label="联系人">
                <Input v-model="config.person" placeholder="请输入联系人..."></Input>
            </FormItem>
            <FormItem label="联系电话">
                <Input v-model="config.phone" placeholder="请输入联系电话..."></Input>
            </FormItem>
            <FormItem label="联系邮箱">
                <Input v-model="config.email" placeholder="请输入联系邮箱..."></Input>
            </FormItem>
            <FormItem label="联系地址">
                <Input v-model="config.address" type="textarea" :rows="4" placeholder="请输入联系地址..."></Input>
            </FormItem>
            <FormItem>
                <Button type="primary" @click="handleSubmit('configData')">提交</Button>
            </FormItem>
        </Form>
    </div>
</template>


<script>
    export default {
        name: 'config',
        data () {
            return {
                config:{
                    sitename:'',
                    describe:'',
                    person:'',
                    phone:'',
                    email:'',
                    address:'',
                },
                configValidate: {
                    sitename: [
                        { required: true, message: '站点名称必须填写', trigger: 'blur' }
                    ]
                },
            }
        },
        created:function(){
            this.getConfig();
        },
        methods: {
            handleSubmit(name) {
                this.$refs[name].validate((valid) => {
                    if (valid) {
                        this.$api.config.edit(this.config).then(res=>{
                            if (res.code == 200) {
                                this.$Message.success('修改权限菜单成功...');
                            }
                        });
                    }
                })
            },
            getConfig:function(){
                var self = this
                this.$api.config.get().then(res=>{
                    this.config = res.data
                });
            },

        }
    }
</script>