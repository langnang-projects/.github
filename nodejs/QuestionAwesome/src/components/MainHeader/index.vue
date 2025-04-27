<template>
    <el-row class="main-header">
        <router-link to="/">
            <img src="@/assets/logo.png" width="40" style />
        </router-link>
        <!-- <el-button type="text" style>
                <i>search</i> Search...
        </el-button>-->

        <a
            v-if="user.login"
            :href="user.html_url"
            class="el-button el-button--default"
            :disabled="disabled"
            target="_blank"
        >
            <el-avatar size="small" :src="user.avatar_url"></el-avatar>
            {{user.login}}
        </a>

        <router-link v-else to="/login" class="el-button el-button--default">
            <font-awesome-icon :icon="['fab','github']" />&nbsp;Sign in
        </router-link>
        <router-link
            v-if="user.login=='langnang'"
            to="/admin"
            class="el-button el-button--default"
        >Admin</router-link>
        <router-link
            :to="user.login?'/question':'/login'"
            class="el-button el-button--default"
            :disabled="disabled"
        >
            <i class="el-icon-plus"></i>
            Question
        </router-link>
        <router-link
            :to="user.login?'/group':'/login'"
            class="el-button el-button--default"
            :disabled="disabled"
        >
            <i class="el-icon-plus"></i>
            Group
        </router-link>

        <slot></slot>
    </el-row>
</template>
<script>
import { mapState } from "vuex";
export default {
    props: {
        disabled: {
            type: Boolean,
            default: true
        }
    },
    computed: {
        ...mapState({
            user: state => state.user.info
        })
    }
};
</script>
<style lang="scss">
.main-header {
    padding: 18px 30px;
    .el-button {
        & + .el-button {
            margin-left: 0;
        }
    }
    .el-avatar--small {
        margin: -8px 0;
    }
}
</style>