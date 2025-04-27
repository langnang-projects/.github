<template>
    <div class="catalog-list">
        <el-card v-for="group in group_list" :key="group.key">
            <div slot="header" class="catalog-list__title">
                <span>{{group.value}}</span>
                <router-link
                    :to="user.login?'/type':'/login'"
                    class="el-button el-button--default"
                    style="float:right;padding:12px 20px;font-size:14px;"
                    :disabled="disabled"
                >
                    <i class="el-icon-plus"></i>
                    Type
                </router-link>
            </div>
            <router-link
                :to="'/for/'+type.key"
                class="el-button el-button--default"
                v-for="type in type_list(group.key)"
                :key="type.key"
            >{{type.value}}</router-link>
        </el-card>
    </div>
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
    data() {
        return {};
    },
    computed: {
        ...mapState({
            group_list: state => state.group.list,
            user: state => state.user.info
        })
    },
    methods: {
        type_list(group_key) {
            return this.$store.getters.getTypeList(group_key);
        }
    }
};
</script>
<style lang="scss" scoped>
.catalog-list {
    .catalog-list__title {
        font-size: 3em;
        font-weight: bold;
        text-align: center;
    }
    .el-button {
        padding: 1em 1.5em;
        font-size: 1.3em;
        margin: 10px;
    }
}
</style>