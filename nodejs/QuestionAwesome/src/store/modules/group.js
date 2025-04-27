import parseBody from '@/utils/parseBody'
export default {
    state: {
        list: []
    },
    mutations: {
        // _(state, payload) { }
        setGroupList(state, list) {
            state.list = list;
        }
    },
    getters: {
        // _: (state, getters) => { }
        group_info: state => key => state.list.filter(v => v.key == key)[0] || {
            id: 0,
            number: 0,
            key: "",
            value: "",
            description: ""
        }
    },
    actions: {
        // _(context, payload) { },
        // _({state,commit,getters},payload){}
        updateGroupList({ state, commit, dispatch }, issue_list) {
            console.log(issue_list);
            if (issue_list.length > 0) {
                const list = issue_list.map(v => {
                    const body = parseBody(v.body);
                    return {
                        id: v.id,
                        number: v.number,
                        ...body
                    }
                })
                commit("setGroupList", [...state.list, ...list]);
                dispatch("updateAppConfig");
            }
        }
    }
}