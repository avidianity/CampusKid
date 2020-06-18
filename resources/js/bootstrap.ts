import "bootstrap";
import VueSession from "@classes/VueSession";
import SessionContract from "~types/Session";
import axios, { AxiosInstance } from "axios";
import { CSRFTokenException } from "@classes/CSRF";

declare global {
    interface Window {
        Session: any;
        misc: any;
    }
    interface Object {
        [key: string]: any;
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
axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
axios.defaults.headers.common["X-CSRF-Token"] = token?.content;

axios.interceptors.request.use(config => {
    if (Session.hasToken()) {
        config.headers["Authorization"] = `Bearer ${Session.token()}`;
    }
    return config;
});

globalThis.Axios = axios;

globalThis.Session = new VueSession();

// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLS: true
// });
