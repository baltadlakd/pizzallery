
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
require('sweetalert2');


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


Vue.component('create-password', require('./components/users/createPassword.vue'));
Vue.component('update-password', require('./components/users/updatePassword.vue'));
Vue.component('edit-name', require('./components/users/editName.vue'));
Vue.component('bar', require('./components/users/bar.vue'));
Vue.component('user-table',require('./components/users/userTable.vue'));
Vue.component('show-info',require('./components/users/showInfo.vue'));
Vue.component('cards',require('./components/users/cards.vue'));





const app = new Vue({
  el: '#app'
});
