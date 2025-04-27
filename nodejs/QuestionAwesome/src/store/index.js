import Vue from 'vue';
import Vuex from 'vuex';
import mutations from './mutations';
import getters from './getters';
import actions from './actions';

import $app from './modules/$app';
import user from './modules/user';
import group from './modules/group';
import type from './modules/type';
import question from './modules/question';
import issue from './modules/issue';

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        $app,
        user,
        group,
        type,
        question,
        issue,
    },
    state: {
        host: "https://api.github.com",
        owner: "langnang",
        repo: "QuestionAwesome",
        app: {},
        githubApp: {
            client_id: "Iv1.312c32dbc9a31bfa",
            redirect_url: "http://localhost:8080/api/oauth",
            client_secret: "ba151763fc8b24b346284864e5a42b57fb04a399",
        }
    },
    mutations,
    getters,
    actions,
})