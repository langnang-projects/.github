<template>
    <div class="view-login">
        <a
            :href="'https://github.com/login/oauth/authorize?client_id='+githubApp.client_id+'&redirect_url='+githubApp.redirect_url"
        >
            <el-button>
                <font-awesome-icon :icon="['fab','github']" />&nbsp;&nbsp;&nbsp;
                <span>Sign in with GitHub</span>
            </el-button>
        </a>
    </div>
</template>
<script>
import { mapState } from "vuex";
export default {
    computed: {
        ...mapState({
            githubApp: state => state.githubApp
        })
    }
};
</script>
<style lang="scss">
.view-login {
    display: flex;
    justify-content: center;
    align-items: center;
    .el-button {
        font-size: 26px;
    }
}
</style>