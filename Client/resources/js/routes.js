import Main from "./components/pages/Main.vue";
import About from "./components/pages/About.vue";

export default [
    { path: '/', component: Main },
    { path: '/about', component: About, props:true },
];
