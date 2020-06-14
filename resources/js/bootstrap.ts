import Axios from "axios";
import $ from "jquery";
import "bootstrap";

declare global {
    interface Window {
        $: any;
        Axios: any;
    }
}

window.$ = $;

Axios.defaults.baseURL = "http://mekoi.dev.local/campuskid/public/api";
Axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

let token: HTMLMetaElement | null = document.head.querySelector(
    'meta[name="csrf-token"]'
);

if (token) {
    Axios.defaults.headers.common["X-CSRF-TOKEN"] = token.content;
} else {
    console.error(
        "CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token"
    );
}

window.Axios = Axios;

// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLS: true
// });
