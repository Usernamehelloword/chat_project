/**
 * Axios
 */
import axios from 'axios';

window.axios = axios;

const csrfMeta = typeof document !== 'undefined' ? document.querySelector('meta[name="csrf-token"]') : null;
if (csrfMeta) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfMeta.getAttribute('content');
}

/**
 * Laravel Echo + Reverb
 */
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

const isHttps = typeof window !== 'undefined' ? window.location.protocol === 'https:' : false;
const currentHost = typeof window !== 'undefined' && window.location.hostname ? window.location.hostname : 'localhost';
const reverbKey = import.meta.env.VITE_REVERB_APP_KEY || 'wltdrmzy3kql9kdlcowf';

window.Echo = new Echo({
    broadcaster: 'reverb',

    key: reverbKey,

    wsHost: currentHost,

    wsPort: isHttps ? 443 : 8080,

    wssPort: 443,

    forceTLS: isHttps,

    enabledTransports: ['ws', 'wss'],
});
