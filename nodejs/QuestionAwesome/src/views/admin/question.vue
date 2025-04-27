<template>
    <div>
        <el-table :data="issue_list('Question]')" style="width: 100%">
            <el-table-column prop="title" label="title"></el-table-column>
        </el-table>
    </div>
</template>



<script>
export default {
    data() {
        return {};
    },
    methods: {
        issue_list(filter) {
            console.log(this.$store.getters.getIssueList(filter));
            return this.$store.getters.getIssueList(filter);
        }
    }
};
</script>
<style lang="scss" scoped>
</style>