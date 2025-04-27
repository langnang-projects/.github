<template>
    <div class="question-container">
        <h1 class="question-title">{{question.title}}</h1>
        <p class="question-desc">{{question.description}}</p>
        <el-tabs value="content">
            <el-tab-pane name="content">
                <span slot="label">内容</span>
                <mavon-editor v-model="question.content" ref="md" class="v-note-mode-show" />
                <el-form>
                    <el-form-item v-for="(quest,i) in question.questions" :key="i">
                        <p>
                            <span>{{i+1}}.</span>
                            {{quest.title}}
                        </p>

                        <!-- 填空题 -->
                        <el-input v-if="quest.type=='completion'" v-model="quest._answer"></el-input>
                        <!-- 单选题 -->
                        <el-radio-group
                            v-else-if="quest.type=='single-choice'"
                            v-model="quest._answer"
                        >
                            <el-radio :label="3">A: 备选项</el-radio>
                            <el-radio :label="6">B: 备选项</el-radio>
                            <el-radio :label="9">C: 备选项</el-radio>
                        </el-radio-group>
                        <!-- 多选题 -->
                        <el-checkbox-group
                            v-else-if="quest.type=='multi-choice'"
                            v-model="quest._answer"
                        >
                            <el-checkbox label="复选框 A"></el-checkbox>
                            <el-checkbox label="复选框 B"></el-checkbox>
                            <el-checkbox label="复选框 C"></el-checkbox>
                        </el-checkbox-group>
                        <!-- 其它 -->
                        <mavon-editor
                            v-else
                            v-model="quest._answer"
                            ref="md"
                            class="v-note-mode-edit"
                        />
                    </el-form-item>
                    <el-form-item>
                        <el-button>清空</el-button>
                        <el-button>提交</el-button>
                    </el-form-item>
                </el-form>
            </el-tab-pane>
            <el-tab-pane name="answers">
                <span slot="label">答案</span>
                <ol>
                    <li v-for="(quest,i) in question.questions" :key="i">{{quest.answer}}</li>
                </ol>
            </el-tab-pane>

            <el-tab-pane name="explain">
                <span slot="label">题解</span>
                <mavon-editor v-model="question.explanation" ref="md" class="v-note-mode-show" />
            </el-tab-pane>
            <el-tab-pane name="comment">
                <span slot="label">
                    <el-badge :value="question.comments" class="item" type="primary">评论</el-badge>
                </span>
                <mavon-editor
                    v-for="comment in comment_list"
                    :key="comment.id"
                    v-model="comment.body"
                    ref="md"
                    class="v-note-mode-show"
                />
            </el-tab-pane>
        </el-tabs>
        <div></div>
    </div>
</template>
<script>
import { mapGetters } from "vuex";
export default {
    props: {
        visible: {
            type: Boolean,
            default: false
        }
    },
    data() {
        return {
            content: "",
            html: ""
        };
    },
    mounted() {
        if (this.$route.query.id) {
            this.$store.dispatch("callQuestion", this.$route.query.id);
        }
    },
    methods: {
        // 所有操作都会被解析重新渲染
        change(value, render) {
            //value为编辑器中的实际内容，即markdown的内容，render为被解析成的html的内容
            this.html = render;
        },
        // 提交
        submit() {
            //点击提交后既可以获取html内容，又可以获得markdown的内容，之后存入到服务端就可以了
            console.log(this.content);
            console.log(this.html);
        }
    },
    computed: {
        ...mapGetters({
            question: "getQuestion",
            comment_list: "getQuestionComments"
        })
    },
    watch: {}
};
</script>
<style lang="scss">
.question-container {
}
</style>