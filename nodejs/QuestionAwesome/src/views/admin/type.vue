<template>
    <div>
        <el-table
            ref="multipleTable"
            :data="issue_list('Type]')"
            style="width: 100%"
            @selection-change="handleSelectionChange"
        >
            <el-table-column type="selection" width="55"></el-table-column>
            <el-table-column prop="title" label="title"></el-table-column>
            <el-table-column fixed="right" label="操作" width="100">
                <template slot-scope="scope">
                    <el-button @click="handleClick(scope.row)" type="text" size="small">查看</el-button>
                    <el-button type="text" size="small">编辑</el-button>
                </template>
            </el-table-column>
        </el-table>
        <div style="margin-top: 20px">
            <el-button @click="toggleSelection()">取消选择</el-button>
        </div>
    </div>
</template>



<script>
export default {
    data() {
        return {
            multipleSelection: []
        };
    },
    methods: {
        handleSelectionChange(val) {
            this.multipleSelection = val;
        },
        toggleSelection(rows) {
            if (rows) {
                rows.forEach(row => {
                    this.$refs.multipleTable.toggleRowSelection(row);
                });
            } else {
                this.$refs.multipleTable.clearSelection();
            }
        },
        issue_list(filter) {
            console.log(this.$store.getters.getIssueList(filter));
            return this.$store.getters.getIssueList(filter);
        }
    }
};
</script>
<style lang="scss" scoped>
</style>