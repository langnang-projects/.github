<template>
    <div class="view-catalog">
        <el-form ref="form" :model="form" :rules="rules">
            <el-form-item label="GROUP：类组" prop="group_key">
                <el-select v-model="form.group_key">
                    <el-option
                        v-for="group in group_list"
                        :key="group.key"
                        :label="group.value"
                        :value="group.key"
                    ></el-option>
                </el-select>
            </el-form-item>
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
                <el-button type="primary" @click="onSubmit">提交</el-button>
                <router-link to="/" class="el-button el-button--default">取消</router-link>
            </el-form-item>
        </el-form>
    </div>
</template>
<script>
import { mapState } from "vuex";
export default {
    data() {
        return {
            form: {
                group_key: "",
                key: "",
                value: "",
                description: ""
            },
            rules: {
                group_key: [{ required: true, trigger: "change" }],
                key: [{ required: true, trigger: "blur" }],
                value: [{ required: true, trigger: "blur" }],
                description: [{ required: true, trigger: "blur" }]
            }
        };
    },
    methods: {
        onSubmit() {
            console.log("submit!");
            if (
                this.form.group_key &&
                this.form.key &&
                this.form.value &&
                this.form.description
            ) {
                this.$store.dispatch("createAnIssue", {
                    title: `[INSERT TYPE] ${this.form.key}: ${this.form.value}`,
                    body: `\`\`\`json\n${JSON.stringify(this.form)}\n\`\`\``
                });
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
        ...mapState({
            catalog_tree: state => state.catalog.tree
        }),
        ...mapState(["group_list"])
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