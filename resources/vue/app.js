/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import '../js/bootstrap';
import Vue from 'vue';
import App from './App.vue';
import vuetify from './plugins/vuetify';

// Push axios into the vue application since it will make things simpler
Vue.prototype.$http = window.axios;

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
new Vue({
    vuetify,
    render: (h) => h(App),
}).$mount('#app');
