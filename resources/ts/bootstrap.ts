import "bootstrap";
import VueSession from "@classes/VueSession";
import axios, { AxiosInstance } from "axios";
import jQuery from "jquery";
import toastr from "toastr";
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
        format: (format: string) => string;
    }
    var Axios: AxiosInstance;
    var Session: VueSession;
    var toastr: Toastr;
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
globalThis.toastr = toastr;

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

Date.prototype.format = function(format: string) {
    let result = "";
    const twelveHour = [
        "1",
        "2",
        "3",
        "4",
        "5",
        "6",
        "7",
        "8",
        "9",
        "10",
        "11",
        "12",
        "1",
        "2",
        "3",
        "4",
        "5",
        "6",
        "7",
        "8",
        "9",
        "10",
        "11",
        "12"
    ];
    const shortDays = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];
    const fullDays = [
        "Sunday",
        "Monday",
        "Tuesday",
        "Wednesday",
        "Thursday",
        "Friday",
        "Saturday"
    ];
    const shortMonths = [
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
    const fullMonths = [
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
    for (const letter of format) {
        /**
         * Reference:
         * https://www.php.net/manual/en/function.date.php
         */
        const month = this.getMonth();
        const date = this.getDate();
        const day = this.getDay();
        const hours = this.getHours();
        const fullYear = this.getFullYear();
        switch (letter) {
            /**
             * Days
             */
            case "d":
                const d = String(date);
                result += d.length === 2 ? d : `0${d}`;
                break;
            case "D":
                result += shortDays[day];
                break;
            case "j":
                result += date;
                break;
            /**
             * Months
             */
            case "F":
                result += fullMonths[month];
                break;
            case "m":
                const m = String(month + 1);
                result += m.length === 2 ? m : `0${m}`;
                break;
            case "M":
                result += shortMonths[month];
                break;
            case "n":
                result += String(month + 1);
                break;
            case "t":
                const temp = new Date(fullYear, month + 1, 0);
                result += String(temp.getDate());
                break;
            /**
             * Years
             */
            case "Y":
                result += String(fullYear);
                break;
            case "y":
                const t = String(fullYear);
                result += `${t[2]}${t[3]}`;
                break;
            /**
             * Times
             */
            case "a":
                result += hours >= 12 ? "pm" : "am";
                break;
            case "A":
                result += hours >= 12 ? "PM" : "AM";
                break;
            case "g":
                result += twelveHour[hours];
                break;
            case "G":
                result += hours;
                break;
            case "h":
                const l = String(twelveHour[hours]);
                result += l.length === 2 ? l : `0${l}`;
                break;
            case "H":
                const p = String(hours);
                result += p.length === 2 ? p : `0${p}`;
                break;
            case "i":
                const x = String(this.getMinutes());
                result += x.length === 2 ? x : `0${x}`;
                break;
            case "s":
                const y = String(this.getSeconds());
                result += y.length === 2 ? y : `0${y}`;
                break;
            default:
                result += letter;
                break;
        }
    }
    return result;
};
// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLS: true
// });
