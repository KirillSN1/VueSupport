import Main from "./components/pages/Main.vue";
import About from "./components/pages/About.vue";
import vArticle from "./components/pages/vArticle.vue";
import Articles from "./components/pages/Articles.vue";

export default [
    { path: '/', component: Main },
    { path: '/about', component: About, props:true },
    { path: '/article', component: vArticle },
    { path: '/articles', component: Articles },
];
