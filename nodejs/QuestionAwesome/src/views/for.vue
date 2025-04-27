<template>
    <div class="view-for">
        <FilterList v-if="false" />
        <el-row :gutter="30" style="margin:0 10px;">
            <el-col :span="8" style="height:70vh;overflow-y:scroll;">
                <QuestionList />
            </el-col>
            <el-col :span="16">
                <Question v-if="$route.query.id&&issue.id" />
                <div v-else style="text-align:center;">
                    <img src="@/assets/logo.png" alt />
                    <p>Select a question to continue</p>
                </div>
            </el-col>
        </el-row>
    </div>
</template>

<script>
import { mapState } from "vuex";

import FilterList from "@/components/FilterList";
import Question from "@/components/Question";
import QuestionList from "@/components/QuestionList";
export default {
    components: {
        FilterList,
        Question,
        QuestionList
    },
    computed: {
        ...mapState({
            issue: state => state.question.issue
        })
    },
    watch: {
        "$route.query.id": function(newValue) {
            // console.log(newValue, oldValue);
            // this.$store.commit("setQuestionIssue", {});
            // this.$store.commit("setQuestionActive", {});
            // this.$store.commit("setQuestionComments", []);
            if (newValue) {
                this.$store.dispatch("callQuestion", newValue);
            }
        }
    }
};
</script>

<style lang="scss" scoped>
.view-for {
    .el-row {
        // margin: 0 20px;
    }
}
</style>