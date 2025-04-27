<template>
    <div class="view-catalog">
        <el-form ref="form" :model="form" :rules="rules">
            <el-form-item label="TITLE：标题" prop="title">
                <el-input v-model="form.title"></el-input>
            </el-form-item>
            <el-form-item label="DESCRIPTION：描述" prop="description">
                <el-input type="textarea" v-model="form.description"></el-input>
            </el-form-item>
            <el-form-item label="DIFFICULTY：难易度">
                <el-rate v-model="form.difficulty"></el-rate>
            </el-form-item>
            <el-form-item label="CONTENT：内容">
                <mavon-editor v-model="form.content" ref="md" class="v-note-mode-preview" />
            </el-form-item>
            <el-form-item label="TAGS：标签">
                <el-tag
                    :key="tag"
                    v-for="tag in form.tags"
                    closable
                    :disable-transitions="false"
                    @close="handleClose(tag)"
                >{{tag}}</el-tag>
                <el-input
                    class="input-new-tag"
                    v-if="inputVisible"
                    v-model="inputValue"
                    ref="saveTagInput"
                    size="small"
                    @keyup.enter.native="handleInputConfirm"
                    @blur="handleInputConfirm"
                ></el-input>
                <el-button v-else class="button-new-tag" size="small" @click="showInput">+ New Tag</el-button>
            </el-form-item>
            <el-form-item label="QUESTIONS：问题列表">
                <el-button size="small">+ New Question</el-button>
                <!-- <el-tag
                    :key="tag"
                    v-for="tag in form.tags"
                    closable
                    :disable-transitions="false"
                    @close="handleClose(tag)"
                >{{tag}}</el-tag>
                <el-input
                    class="input-new-tag"
                    v-if="inputVisible"
                    v-model="inputValue"
                    ref="saveTagInput"
                    size="small"
                    @keyup.enter.native="handleInputConfirm"
                    @blur="handleInputConfirm"
                ></el-input>
                <el-button
                    v-else
                    class="button-new-tag"
                    size="small"
                    @click="showInput"
                >+ New Question</el-button>-->
            </el-form-item>
            <el-form-item label="EXPLANATION：整题解析">
                <mavon-editor v-model="form.explanation" ref="md" class="v-note-mode-preview" />
            </el-form-item>
            <el-form-item>
                <el-button type="primary" @click="onSubmit">提交</el-button>
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
                title: "",
                description: "",
                content: "",
                difficulty: 0,
                tags: [],
                questions: [],
                explanation: ""
            },
            quesiton_from: {
                title: "",
                type: "",
                options: [],
                answer: "",
                explain: ""
            },
            inputVisible: false,
            inputValue: "",
            rules: {
                title: [{ required: true }],
                description: [{ required: true }],
                tags: [{ required: true }]
            }
        };
    },
    methods: {
        onSubmit() {
            console.log("submit!");
            console.log(this.form);
            if (
                this.form.title &&
                this.form.description &&
                this.form.content &&
                this.form.explanation
            ) {
                this.$store.dispatch("createAnIssue", {
                    title: `[INSERT QUESTION] ${this.form.title}`,
                    body: `\`\`\`json\n${JSON.stringify(this.form)}\n\`\`\``
                });
            } else {
                this.$alert("所填内容不可为空", "Error", {
                    confirmButtonText: "确定"
                });
            }
        },
        handleClose(tag) {
            this.form.tags.splice(this.form.tags.indexOf(tag), 1);
        },
        showInput() {
            this.inputVisible = true;
            this.$nextTick(() => {
                this.$refs.saveTagInput.$refs.input.focus();
            });
        },
        handleInputConfirm() {
            let inputValue = this.inputValue;
            if (inputValue) {
                this.form.tags.push(inputValue);
            }
            this.inputVisible = false;
            this.inputValue = "";
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