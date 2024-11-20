import Vue from 'vue/dist/vue.esm'
import axios from 'axios'

axios.defaults.withCredentials = true
axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').content;
Vue.prototype.$http = axios

import Dashboard from './components/Dashboard.vue'
import TransactionHistory from './components/TransactionHistory.vue'

new Vue({
    el: '#app',
    components: {
        Dashboard,
        TransactionHistory
    }
})
