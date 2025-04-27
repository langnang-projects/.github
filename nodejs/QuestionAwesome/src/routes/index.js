import Vue from 'vue';
import VueRouter from 'vue-router';

import HomeRoute from '@/views/home.vue'
import LoginRoute from '@/views/login.vue'
import GroupRoute from '@/views/group.vue'
import TypeRoute from '@/views/type.vue'
import QuestionRoute from '@/views/question.vue'
import ErrorRoute from '@/views/error.vue'
import ForRoute from '@/views/for.vue'

Vue.use(VueRouter);
export default new VueRouter({
    mode: "hash",
    routes: [
        {
            path: "/",
            component: HomeRoute,
        },

        {
            path: "/api/oauth",
            component: () => import("@/api/oauth.vue")
        },
        {
            path: "/login",
            component: LoginRoute,
        },
        {
            path: "/oauth",
            component: LoginRoute,
        },
        {
            path: "/group",
            component: GroupRoute,
        },
        {
            path: "/group/:key",
            component: GroupRoute,
        },
        {
            path: "/type",
            component: TypeRoute,
        },
        {
            path: "/question",
            component: QuestionRoute,
        },
        {
            path: "/for/:type",
            component: ForRoute,
        },
        {
            path: "/admin",
            component: () => import("@/views/admin"),
            children: [
                {
                    path: "group",
                    component: () => import("@/views/admin/group")
                },
                {
                    path: "type",
                    component: () => import("@/views/admin/type")
                },
                {
                    path: "question",
                    component: () => import("@/views/admin/question")
                },
            ]
        },
        {
            path: "*",
            component: ErrorRoute,
        }
    ]
})