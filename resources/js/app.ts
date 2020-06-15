import "./bootstrap";

import Vue from "vue";
import router from "./router";
import store from "./store";

import App from "./App.vue";

import AOS from "aos";
import "aos/dist/aos.css";

new Vue({
    router,
    store,
    el: "#app",
    mounted() {
        AOS.init();
    },
    render: h => h(App)
});
