<template>
    <div class="admin-edit-info">
        <Form ref="adminData" :model="adminInfo" :rules="adminValidate" action="javascript:void(0)">
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
                <Button type="primary" @click="handleSubmit('adminData')">提交</Button>
            </FormItem>
        </Form>
    </div>
</template>


<script>
export default {
  name: 'AdminEditInfo',
  data() {
    return {
      adminInfo: {
        realname: '',
        phone: '',
        email: ''
      },
      adminValidate: {
        realname: [
          { required: true, message: '姓名必须填写', trigger: 'blur' }
        ]
      }
    }
  },
  created: function() {
    this.getInfo();
  },
  methods: {
    handleSubmit(name) {
      this.$refs[name].validate((valid) => {
        if (valid) {
          var params = this.adminInfo;
          params.admin_id = this.$store.getters.user_id;
          this.$api.admin.selfeditinfo(params).then(res => {
            if (res.code == 200) {
              this.$Message.success('修改成功...');
            }
          });
        }
      })
    },
    getInfo: function() {
      this.$api.admin.detail({ 'admin_id': this.$store.getters.user_id }).then(res => {
        if (res.code == 200) {
          this.adminInfo = res.result
        }
      });
    }

  }
}
</script>
