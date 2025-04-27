import Vue from "vue";
import VueRouter from "vue-router";

import HomeRoute from "./../views/home.vue";
import ToplistRoute from "./../views/toplist.vue";
import PlaylistRoute from "./../views/playlist.vue";
import ArtistRoute from "./../views/artist.vue";

Vue.use(VueRouter);
export default new VueRouter({
  mode: "hash",
  routes: [
    {
      path: "/",
      component: HomeRoute
    },
    {
      path: "/toplist",
      component: ToplistRoute
    },
    {
      path: "/playlist",
      component: PlaylistRoute
    },
    {
      path: "/artist",
      component: ArtistRoute
    },
    {
      path: "*",
      component: HomeRoute
    }
  ]
});
