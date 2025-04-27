<template>
    <div class="view-catalog">
        <el-form ref="form" :model="form" :rules="rules">
            <el-form-item label="KEY：关键字" prop="key">
                <el-input v-model="form.key"></el-input>
            </el-form-item>
            <el-form-item label="VALUE：关键值" prop="value">
                <el-input v-model="form.value"></el-input>
            </el-form-item>
            <el-form-item label="DESCRIPTION：描述" prop="description">
                <el-input type="textarea" v-model="form.description"></el-input>
            </el-form-item>
            <el-form-item>
                <el-button type="primary" @click="onSubmit('insert')">创建</el-button>
                <el-button type="primary" @click="onSubmit('update')">提交</el-button>
                <router-link to="/" class="el-button el-button--default">取消</router-link>
            </el-form-item>
        </el-form>
    </div>
</template>
<script>
export default {
    data() {
        return {
            form: {
                id: 0,
                number: 0,
                key: "",
                value: "",
                description: ""
            },
            rules: {
                key: [{ required: true, trigger: "blur" }],
                value: [{ required: true, trigger: "blur" }],
                description: [{ required: true, trigger: "blur" }]
            }
        };
    },
    methods: {
        onSubmit(target) {
            if (this.form.key && this.form.value && this.form.description) {
                if (target == "insert") {
                    this.$store.dispatch("createAnIssue", {
                        title: `[INSERT GROUP] ${this.form.key}: ${this.form.value}`,
                        body: `\`\`\`json\n${JSON.stringify(this.form)}\n\`\`\``
                    });
                } else if (target == "update") {
                    this.$store.dispatch("createAnIssue", {
                        title: `[UPDATE GROUP] ${this.form.key}: ${this.form.value}`,
                        body: `\`\`\`json\n${JSON.stringify(this.form)}\n\`\`\``
                    });
                }
            } else {
                this.$refs["form"].validate(valid => {
                    if (valid) {
                        alert("submit!");
                    } else {
                        console.log("error submit!!");
                        return false;
                    }
                });
                this.$alert("所填内容不可为空", "Error", {
                    confirmButtonText: "确定"
                });
            }
        }
    },
    computed: {
        group_info() {
            console.log(this.$store.getters.group_info());
            return this.$store.getters.group_info();
        }
    }
};
</script>
<style lang="scss" scoped>
.view-catalog {
    padding: 0 30px;
    display: flex;
    justify-content: center;
    align-items: center;
    .el-form {
        display: block;
        width: 700px;
    }
}
</style>