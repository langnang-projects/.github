// import './plugins/axios'
// import './plugins/fontawesome'
import { createApp } from 'vue'
import App from './views/home/index.vue'
import store from './store'
import ElementPlus from 'element-plus'
import 'element-plus/lib/theme-chalk/index.css'

createApp(App).use(store).use(ElementPlus).mount('#app')
