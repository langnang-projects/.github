export default {
    state: {
        status: 0,
        loading: {
            visible: false,
            text: "加载中......",
            text_list: [
                "加载中......",
                "加载程序数据中....",
                "加载程序数据失败，请刷新页面。",
                "检测到本地缓存，加载用户数据中......",
                "检测到本地缓存，加载用户数据中......",
            ],
        }
    },
    mutations: {
        setAppLoading(state, boolean) {
            state.loading.visible = boolean;
        },
        setAppLoadingText(state, index = 0) {
            state.loading.text = state.loading.text_list[index];
        }
        // _(state, payload) { }
    },
    getters: {
        // _: (state, getters) => { },
        loading: state => {
            return {
                visible: state.loading.visible,
                text: state.loading.text,
            }
        }
    },
    actions: {
        // _(context, payload) { },
        // _({state,commit,getters},payload){}
    }
}