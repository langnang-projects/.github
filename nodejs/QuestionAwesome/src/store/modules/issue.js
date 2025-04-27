export default {
    state: {
        _1: {},
        list: [],
    },
    mutations: {
        // _(state, payload) { }
        setIssue_1(state, issue) {
            state._1 = issue;
        },
        setIssueList(state, list) {
            state.list = list;
        },
    },
    getters: {
        // _: (state, getters) => { }
        getIssueList: state => issue_filter => state.list.filter(v => v.title.indexOf(issue_filter) >= 0)
    },
    actions: {
        // _(context, payload) { },
        // _({state,commit,getters},payload){}
        getAnIssue({ state, rootState }, issue_number,) {
            console.log(state);
            console.log(rootState);
            console.log(issue_number);
            // return this._vm.$axios()
        },
        getIssueList({ dispatch, commit }) {
            dispatch("$getIssueList").then(function (_res) {
                console.log(_res.data);
                commit("setIssueList", _res.data);
            }).catch(function (_err) {
                console.log(_err);
            })
        },
    }
}