import parseBody from '@/utils/parseBody';
// import ques from '@/assets/question.json';
export default {
    state: {
        issue: {},
        active: {},
        list: [],
        comment_list: [],
    },
    mutations: {
        setQuestionIssue(state, payload) {
            state.issue = payload;
        },
        setQuestionList(state, payload) {
            state.list = payload;
        },
        setQuestionActive(state, payload) {
            state.active = payload;
        },
        setQuestionComments(state, payload) {
            state.comment_list = payload;
        }
    },
    getters: {
        // _: (state, getters) => { },
        getQuestionList: state => tag => {
            console.log(tag);
            return state.list.filter(q => { return q.tags.indexOf(tag) > -1 })
        },
        getQuestion: state => state.active,
        getQuestionComments: state => state.comment_list
    },
    actions: {
        callQuestionComments(context, payload) {
            context.dispatch("callOptions", payload + "/comments")
                .then(function (_res) {
                    // console.log(_res.data);
                    context.commit("setQuestionComments", _res.data);
                })
        },
        callQuestion(context, payload) {
            // console.log(payload);
            context.dispatch("callOptions", payload)
                .then(function (_res) {
                    // console.log(_res.data);
                    context.commit("setQuestionIssue", _res.data);
                    context.commit("setQuestionActive", { ...parseBody(_res.data.body), comments: _res.data.comments } || {});
                })
            context.dispatch("callQuestionComments", payload);
            // context.commit("setQuestionActive", ques);

        }
        // _(context, payload) { },
        // _({state,commit,getters},payload){}
    }
}