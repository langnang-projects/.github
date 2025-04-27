import Vue from "vue";
import "./plugins/axios";
import "./plugins/fontawesome";
import "./plugins/element.js";
import App from "./App.vue";
import router from "./routes";
import store from "./store";
import AudioPlayer from "@langnang/vue-audio-player";
import "@langnang/vue-audio-player/lib/vue-audio-player.css";
import "@/styles/index.scss";

Vue.config.productionTip = false;
Vue.use(require("vue-wechat-title"));
Vue.use(AudioPlayer);

new Vue({
  router,
  store,
  render: h => h(App)
}).$mount("#app");
