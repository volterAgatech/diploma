import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap/dist/js/bootstrap.js'

import { createApp } from 'vue'
import axios from 'axios'
import VueAxios from 'vue-axios'

import App from './App'

//import i18n from './i18n'
import i18n from './i18n'
import store from "./store";

 
import router from './router/index.js'
// store.commit('increment')
//console.log(store.state.count)
createApp(App).use(i18n).use(VueAxios, axios).use(store).use(router).mount('#app')