window.Vue = require('vue');

const Root = Vue.extend(require("./components/root.vue").default);

import routes from './routes.js';
import VueRouter from 'vue-router';
Vue.use(VueRouter);
window.onload = function(){
    window.vmm = new Root({
        el:"#app",
        name:"Root",
        router:new VueRouter({ mode: 'history', routes })//use router
    });
}