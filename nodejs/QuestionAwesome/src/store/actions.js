// import config from '@/assets/config.json'
import parseBody from '@/utils/parseBody'

const issueActions = {
    $getAnIssue({ state }, issue_number,) {
        return this._vm.$axios.get(`${state.host}/repos/${state.owner}/${state.repo}/issues/${issue_number}`)
    },
    $getIssueList({ state, }) {
        return this._vm.$axios.get(`${state.host}/repos/${state.owner}/${state.repo}/issues`);
    },
    $createAnIssue({ state }, data) {
        let _this = this._vm;
        this._vm
            .$axios({
                method: "POST",
                url: "https://api.github.com/repos/langnang/QuestionAwesome/issues",
                data: data,
                headers: {
                    accept: "application/json",
                    Authorization: `token ${state.user.token.access_token}`
                }
            })
            .then(function (_res) {
                console.log(_res.data);
                _this.$confirm('记录已提交，是否继续操作?', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning'
                }).then(() => {
                    _this.$message({
                        type: 'success',
                    });
                }).catch(() => {
                    _this.$message({
                        type: 'info',
                    });
                });
            })
            .catch(function (_err) {
                console.log(_err);
            })
    },
    $updateAnIssue({ state }, data) {
        return this._vm.$axios({
            method: "PATCH",
            url: `https://api.github.com/repos/langnang/QuestionAwesome/issues/${data.issue_number}`,
            data: {
                body: `\`\`\`json\n${JSON.stringify(data.body)}\n\`\`\``
            },
            headers: {
                accept: "application/json",
                Authorization: `token ${state.user.token.access_token}`
            }
        })

    },
    $lockAnIssue({ state }, data) {
        return this._vm.$axios({
            method: "PUT",
            url: `https://api.github.com/repos/langnang/QuestionAwesome/issues/${data.issue_number}/lock`,
            data: {
                "locked": true,
                "active_lock_reason": data.lock_reason
            },
            headers: {
                accept: "application/json",
                Authorization: `token ${state.user.token.access_token}`
            }
        })
    },
    $unlockAnIssue({ state }, issue_number) {
        return this._vm.$axios({
            method: "DELETE",
            url: `https://api.github.com/repos/langnang/QuestionAwesome/issues/${issue_number}/lock`,
            headers: {
                accept: "application/json",
                Authorization: `token ${state.user.token.access_token}`
            },

        })
    }
}

const userActions = {
    $getUserInfo({ state }) {
        return this._vm.$axios({
            method: 'get',
            url: `${state.host}/user`,
            headers: {
                Authorization: `Bearer ${state.user.token.access_token}`
            }
        })
    }
}
const appActions = {
    async getAppConfig({ dispatch, commit }) {
        commit("setAppLoading", true);
        commit("setAppLoadingText", 1);
        // let _this = this._vm;
        dispatch("$getAnIssue", 1)
            .then(function (_res) {
                // console.log(_res.data.body);
                commit("setAppLoading", false);
                const content = _res.data.body;
                commit("setIssue_1", _res.data);
                const config = parseBody(content);
                commit("setApp", config || {});
                commit("setGroupList", config.group_list || []);
                commit("setTypeList", config.type_list || []);
                commit("setQuestionList", config.question_list || []);
            }).catch(function () {
                // dispatch("callSystemOptions");
                commit("setAppLoadingText", 2);
                // _this.$alert('请求网站数据失败，请重新刷新页面！！！', 'Error', {
                //     confirmButtonText: '确定',
                //     callback: () => {
                //         window.location.reload();
                //     }
                // });
            })

        // context.commit("setCatalogTree", config.catalog_tree || {});
        // context.commit("setQuestion/List", config.question_list || {});
    },
    updateAppList(context, list) {
        console.log(list);
        list.forEach(v => {
            console.log(v);
        })
    },
    updateAppGroupList() { },
    updateAppTypeList() { },
    updateAppQuestionList() { },
    updateAppConfig({ state, dispatch }) {
        console.log(state.app);
        console.log({
            group_list: state.group.list,
            type_list: state.type.list,
            question_list: state.question.list
        })
        dispatch("$updateAnIssue", {
            issue_number: 1,
            body: {
                group_list: state.group.list,
                type_list: state.type.list,
                question_list: state.question.list
            }
        }).then(function (_res) {
            console.log(_res);
        }).catch(function (_err) {
            console.log(_err);
        })
    },
}
export default {
    ...userActions,
    ...issueActions,
    ...appActions,
    // _(context, payload) { },
    // _({state,commit,getters},payload){},
    async onReady({ commit, dispatch }) {
        await dispatch("getAppConfig");
        const _token =
            window.localStorage.getItem("token") ||
            window.sessionStorage.getItem("token");
        if (_token) {
            // console.log("has storage token");
            const token = JSON.parse(_token);
            // console.log(token);
            commit("setUserToken", token);
            // 请求用户数据
            await dispatch("getUserInfo");
        } else {
            console.log("no storage token");
        }
    }
}