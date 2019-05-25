
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
import store from './store'

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.component('plus-minus-component', require('./components/PlusMinusComponent.vue'));
Vue.component('counter', require('./components/Counter.vue'));
Vue.component('task-list', require('./components/KitchenTaskList.vue'));

const app = new Vue({
    el: '#app',
    store
});