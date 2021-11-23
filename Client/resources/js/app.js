window.Vue = require('vue');

Vue.component("main-page",require("./components/main.vue").default);

window.onload = function(){
    vmm = new Vue({
        el:"#app",
    });
}