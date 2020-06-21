import "bootstrap";
import VueSession from "@classes/VueSession";
import axios, { AxiosInstance } from "axios";
import jQuery from "jquery";
import { CSRFTokenException } from "@classes/CSRF";

declare global {
    interface Window {
        Session: VueSession;
        jQuery: JQueryStatic;
        $: JQueryStatic;
        [key: string]: any;
    }
    interface Object {
        [key: string]: any;
    }
    interface Date {
        getFullMonth: () => string;
        getHalfMonth: () => string;
        getMonthAndYear: () => string;
    }
    var Axios: AxiosInstance;
    var Session: VueSession;
}

const token: HTMLMetaElement | null = document.querySelector(
    'meta[name="csrf-token"]'
);

if (!token) {
    throw new CSRFTokenException(
        "There is no CSRF Token. Please reload the page."
    );
}

axios.defaults.baseURL = "http://mekoi.dev.local/campuskid/public/api";
axios.defaults.headers.common["Accept"] = "application/json";
axios.defaults.headers.common["Content-Type"] = "application/json";
axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
axios.defaults.headers.common["Cache-Control"] = "no-cache";
axios.defaults.headers.common["X-CSRF-Token"] = token?.content;
// axios.defaults.headers.common["Cookie"] = `XSRF-TOKEN=${token?.content}`;
axios.defaults.withCredentials = true;

axios.interceptors.request.use(config => {
    if (Session.hasToken()) {
        config.headers["Authorization"] = `Bearer ${Session.token()}`;
    }
    return config;
});

axios.interceptors.response.use(
    response => {
        return response;
    },
    error => {
        if (error.status && error.status === 401) {
            Session.clear();
            Session.temp.clear();
            Session.flash.clear();
        }
        return Promise.reject(error);
    }
);

window.$ = jQuery;
window.jQuery = jQuery;
globalThis.Axios = axios;
globalThis.Session = new VueSession();

Date.prototype.getFullMonth = function() {
    const months = [
        "January",
        "February",
        "March",
        "April",
        "May",
        "June",
        "July",
        "August",
        "September",
        "October",
        "November",
        "December"
    ];
    return months[this.getMonth()];
};
Date.prototype.getHalfMonth = function() {
    const months = [
        "Jan",
        "Feb",
        "Mar",
        "Apr",
        "May",
        "Jun",
        "Jul",
        "Aug",
        "Sept",
        "Oct",
        "Nov",
        "Dec"
    ];
    return months[this.getMonth()];
};
Date.prototype.getMonthAndYear = function() {
    return `${this.getHalfMonth()} ${this.getDate()}, ${this.getFullYear()}`;
};
// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLS: true
// });
