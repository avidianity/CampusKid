import "bootstrap";
import VueSession from "@classes/VueSession";
import axios, { AxiosInstance } from "axios";
import $ from "jquery";
import toastr from "toastr";
import { CSRFTokenException } from "@classes/CSRF";

function allPromise(promises: Array<Promise<any>>, callback: Function) {
    const results: Array<any> = [];
    let hasError = false;
    for (const index in promises) {
        promises[index]
            .then((response: any) => {
                callback(response, index, promises);
                results.push(response);
            })
            .catch((error: any) => {
                hasError = true;
                results.push(error);
            });
    }
    return hasError ? Promise.reject(results) : Promise.resolve(results);
}

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
        format: (format: string) => string;
        isGreaterThan: (date: Date) => boolean;
        isLessThan: (date: Date) => boolean;
    }
    var AllPromise: typeof allPromise;
    var Axios: AxiosInstance;
    var Session: VueSession;
    var toastr: Toastr;
}

const AllPromise = allPromise;

const token: HTMLMetaElement | null = document.querySelector(
    'meta[name="csrf-token"]'
);

if (!token) {
    throw new CSRFTokenException(
        "There is no CSRF Token. Please reload the page."
    );
}

axios.defaults.baseURL = "/api";
axios.defaults.headers.common["Accept"] = "application/json";
axios.defaults.headers.common["Content-Type"] = "application/json";
axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
axios.defaults.headers.common["Cache-Control"] = "no-cache";
axios.defaults.headers.common["X-CSRF-Token"] = token?.content;
// axios.defaults.headers.common["Cookie"] = `XSRF-TOKEN=${token?.content}`;
// axios.defaults.withCredentials = true;

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
        const user = Session.user();
        if (
            error.response &&
            error.response.status &&
            error.response.status === 401 &&
            user !== null
        ) {
            Session.clear();
            Session.temp.clear();
            Session.flash.clear();
        }
        return Promise.reject(error);
    }
);

window.$ = $;
window.jQuery = $;
globalThis.Axios = axios;
globalThis.Session = new VueSession();
globalThis.toastr = toastr;

import "./addons";

// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLS: true
// });
