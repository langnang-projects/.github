export default {
    state: {
        list: []
    },
    mutations: {
        // _(state, payload) { }
        setTypeList(state, list) {
            state.list = list;
        }
    },
    getters: {
        // _: (state, getters) => { }
        getTypeList: (state) => (group_key) => state.list.filter(v => v.group_key == group_key),
    },
    actions: {
        // _(context, payload) { },
        // _({state,commit,getters},payload){}
    }
}