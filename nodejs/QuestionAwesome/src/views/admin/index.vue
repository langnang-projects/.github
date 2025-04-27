<template>
    <div class="view-admin">
        <el-row>
            <el-col :span="4">
                <el-menu
                    :router="true"
                    @open="handleOpen"
                    @close="handleClose"
                    background-color="#545c64"
                    text-color="#fff"
                    active-text-color="#ffd04b"
                >
                    <el-menu-item index="/admin/group">
                        <span slot="title">Group</span>
                    </el-menu-item>
                    <el-menu-item index="/admin/type">
                        <span slot="title">Type</span>
                    </el-menu-item>
                    <el-menu-item index="/admin/question">
                        <span slot="title">Question</span>
                    </el-menu-item>
                </el-menu>
            </el-col>
            <el-col :span="20">
                <router-view></router-view>
            </el-col>
        </el-row>
    </div>
</template>
<script>
// DONE GET GET https://api.github.com/repos/:owner/:repo/issues for issue list
// DONE save to store(issue.list)
// DONE filter issue list for group|type|question

// TODO Config
// DONE Insert 1. multiselection insert group issue
// TODO Insert 2. update store.group.list
// TODO Insert 3. update config issue
// TODO Insert 4. colse insert group issue
// TODO Insert 5. delete insert group issue in issue.list
// TODO Delete
// TODO Update
export default {
    mounted() {
        this.$store.dispatch("getIssueList");
    },
    methods: {
        handleOpen(key, keyPath) {
            console.log(key, keyPath);
        },
        handleClose(key, keyPath) {
            console.log(key, keyPath);
        }
    }
};
</script>