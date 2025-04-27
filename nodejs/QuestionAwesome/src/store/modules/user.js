import getQuery from "@/utils/getQuery";
export default {
    state: {
        active: false,
        info: {},
        oauth: {
            code: "",
            validity: "page",
            message: "No OAuth Info, Please Sign in.",
            message_list: [
                "No OAuth Info, Please Sign in.",
                "Verification Code Detected, Validating....",
                "Bad Verification Code, Please Sign in Again.",
                "Good Verification Code, Requesting User Info...",
                "Sign in Success."
            ],
        },
        token: {

        }
    },
    mutations: {
        setUserActive(state, isActive) {
            state.active = isActive;
        },
        setUserOAuthCode(state, code) {
            state.oauth.code = code;
        },
        setUserOAuthMessage(state, index) {
            state.oauth.message = state.oauth.message_list[index];
        },
        setUserInfo(state, info) {
            state.info = info;
            state.active = true;
        },
        setUserToken(state, token) {
            state.token = token;
        }

    },
    // 
    getters: {},
    actions: {
        getUserInfo({ commit, dispatch }) {
            // commit("setAppLoading", true);
            dispatch("$getUserInfo")
                .then(function (_res) {
                    commit("setUserOAuthMessage", 4);
                    commit("setUserInfo", _res.data);
                }).catch(function (_err) {
                    console.log(_err);
                })
        },
        getUserToken({ state, dispatch, commit, rootState }) {
            commit("setUserOAuthMessage", 1);
            console.log(state)
            console.log(rootState)
            this._vm.$axios({
                method: "POST",
                // url: 'https://github.com/login/oauth/access_token?' +
                url: '/access_token?' +
                    `client_id=${rootState.githubApp.client_id}&` +
                    `client_secret=${rootState.githubApp.client_secret}&` +
                    `code=${state.oauth.code}`,
                headers: {
                    accept: "application/json"
                }
            }).then(function (_res) {
                // console.log(_res);
                // 转换为json
                const token = getQuery(_res.data);
                // console.log(token);
                // 检测是否含有用户令牌
                if (token.access_token) {
                    commit("setUserToken", token);
                    commit("setUserOAuthMessage", 3);
                    // 请求用户数据
                    dispatch("getUserInfo")
                }
                else {
                    throw new Error(token.error);
                }
            }).catch(function (_err) {
                commit("setUserOAuthMessage", 2);
                console.log(_err);
            })
        }
    }
}