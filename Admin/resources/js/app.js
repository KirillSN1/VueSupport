window._ = require('lodash');

Vue.component("app",require("./components/app.vue").default);

import routes from './routes.js';
import VueRouter from 'vue-router';
import Vue from 'vue';
// import Variables from './variables.js';

Vue.use(VueRouter);
window.onload = function(){
    window.vmm = new Vue({
        el:"#app",
        template:"<app></app>",
        router:new VueRouter({ mode: 'history', routes })//use router
    });
}