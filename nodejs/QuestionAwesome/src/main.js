import Vue from 'vue'
import App from '@/App.vue'
import router from '@/routes'
import store from '@/store'
import '@/plugins/axios'
import '@/plugins/element'
import '@/plugins/fontawesome'
import '@/plugins/mavon-editor'
import '@/styles/index.scss'

Vue.config.productionTip = false
Vue.use(require('vue-wechat-title'))

new Vue({
  router,
  store,
  render: h => h(App)
}).$mount('#app')

