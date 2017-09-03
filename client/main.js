import Vue from 'vue'
import App from './components/App.vue'
import store from './store/store.js';
import router from './router.js';

import './style/common.scss'

new Vue({
    el: '#app',
    store,
    router,
    render: h => h(App),
    created() {
        this.$store.dispatch('loadStartNotes');
    },
});
