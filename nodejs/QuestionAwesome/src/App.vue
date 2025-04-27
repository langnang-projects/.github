<template>
    <div
        id="app"
        class="theme-dark"
        v-loading="loading.visible"
        :element-loading-text="loading.text"
    >
        <MainHeader></MainHeader>
        <router-view></router-view>
        <MainFooter />
    </div>
</template>

<script>
// DONE GET https://api.github.com/repos/langnang/QuestionAwesome/issues/1 for syetem data
// DONE save to store (issue._1,app,group.list,type.list,question.list)
// DONE search storage for saved info of token
// DONE if true : GET https://api.github.com/user for user info
// DONE save to store (user.info)

// DONE 由于GitHub Apps 返回的地址不可填写hash模式，只可返回为‘/’地址，因此需要在‘/’路由中检测code
import MainHeader from "@/components/MainHeader";
import MainFooter from "@/components/MainFooter";
import getQuery from "@/utils/getQuery";
import { mapState, mapGetters } from "vuex";
export default {
    name: "App",
    components: { MainHeader, MainFooter },
    data() {
        return {};
    },
    computed: {
        ...mapState({}),
        ...mapGetters(["loading"])
    },
    mounted() {
        this.$store.dispatch("onReady");
        console.log(this);
        console.log(this.$router);
        console.log(this.$store);

        // 判断地址栏中是否有参数
        if (window.location.search) {
            // this.auth = false;
            // 将地址栏参数转换为json
            const query = getQuery(window.location.search.substr(1));
            // 是否有code参数
            if (query.code) {
                // 保存code
                // console.log(query);
                // 跳转至验证页面
                window.location.href = `#/api/oauth`;
            }
        }
    }
};
</script>

<style lang="scss">
</style>
