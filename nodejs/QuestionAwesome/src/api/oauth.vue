<template>
    <div class="view-api__auth flex-center">
        <h1>{{message}}</h1>
        <el-form v-if="active">
            <el-form-item label="请选择保存本次登录令牌的有效期">
                <el-radio v-model="validity" label="no">不保存</el-radio>
                <br />
                <el-radio v-model="validity" label="chrome">至浏览器关闭</el-radio>
                <br />
                <el-radio v-model="validity" label="forever">永久</el-radio>
            </el-form-item>
            <el-form-item>
                <el-button @click="onSubmit">确认</el-button>
            </el-form-item>
        </el-form>
    </div>
</template>
<script>
import { mapState } from "vuex";
import getQuery from "@/utils/getQuery";
export default {
    data() {
        return {
            validity: "no"
        };
    },
    mounted() {
        this.$store.commit("setUserActive", false);
        // 判断地址栏中是否有参数
        if (window.location.search) {
            // this.auth = false;
            // 将地址栏参数转换为json
            const data = getQuery(window.location.search.substr(1));
            // 是否有code参数
            if (data.code) {
                // 保存code
                this.$store.commit("setUserOAuthCode", data.code);
                // 请求用户令牌
                this.$store.dispatch("getUserToken");
            } else {
                this.$store.commit("setUserOAuthMessage", 0);
            }
        } else {
            this.$store.commit("setUserOAuthMessage", 0);
        }
    },
    methods: {
        onSubmit() {
            // console.log(this.validity);
            // console.log(this.$store.state.user.token);
            const token = this.$store.state.user.token;
            switch (this.validity) {
                case "chrome":
                    window.sessionStorage.setItem(
                        "token",
                        JSON.stringify(token)
                    );
                    break;
                case "forever":
                    window.localStorage.setItem("token", JSON.stringify(token));
                    break;
                default:
                    break;
            }
            window.location.href = "/";
        }
    },
    computed: {
        ...mapState({
            message: state => state.user.oauth.message,
            active: state => state.user.active
            // validity: state => state.user.oauth.validity
        })
    }
};
</script>
<style lang="scss">
.view-api__auth {
    flex-direction: column;
}
</style>