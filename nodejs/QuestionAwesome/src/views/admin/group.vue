<template>
    <div>
        <el-tabs value="config">
            <el-tab-pane label="Config" name="config">
                <el-table :data="group_list" style="width: 100%">
                    <el-table-column prop="id" label="ID" width="100" sortable></el-table-column>
                    <el-table-column prop="number" label="Number" width="100" sortable></el-table-column>
                    <el-table-column prop="key" label="Key" width="100" sortable></el-table-column>
                    <el-table-column prop="value" label="Value" width="100" sortable></el-table-column>
                    <el-table-column prop="description" label="Description"></el-table-column>
                    <el-table-column label="操作" width="150">
                        <template slot-scope>
                            <el-button size="mini">编辑</el-button>
                            <el-button size="mini" type="danger" onclick>删除</el-button>
                        </template>
                    </el-table-column>
                </el-table>
            </el-tab-pane>
            <el-tab-pane label="Insert" name="insert">
                <el-table
                    ref="multipleTable"
                    :data="issue_list('[INSERT GROUP]')"
                    style="width: 100%"
                    @selection-change="handleSelectionChange"
                >
                    <el-table-column type="selection" width="55"></el-table-column>
                    <el-table-column prop="title" label="title"></el-table-column>
                </el-table>
                <div style="margin-top: 20px;text-align:right;">
                    <el-button @click="toggleSelection()">取消选择</el-button>
                    <el-button @click="onUpdate()">提交</el-button>
                    <el-button @click="onLock()">关闭</el-button>
                </div>
            </el-tab-pane>
            <el-tab-pane label="Delete" name="Delete">Delete</el-tab-pane>
            <el-tab-pane label="Update" name="Update">Update</el-tab-pane>
        </el-tabs>
    </div>
</template>
<script>
import { mapState } from "vuex";
export default {
    data() {
        return {
            multipleSelection: [],
            multipleSelection_length: 0
        };
    },
    computed: {
        ...mapState({
            group_list: state => state.group.list
        })
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
            return this.$store.getters.getIssueList(filter);
        },
        onUpdate() {
            if (this.multipleSelection.length) {
                this.$store.dispatch("updateGroupList", this.multipleSelection);
            }
        },
        onLock() {}
    }
};
</script>
<style lang="scss" scoped>
</style>