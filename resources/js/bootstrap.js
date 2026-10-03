/**
 * Axios
 */
import axios from 'axios';

window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Laravel Echo + Reverb
 */
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

const isHttps = (import.meta.env.VITE_REVERB_SCHEME ?? (typeof window !== 'undefined' && window.location.protocol === 'https:' ? 'https' : 'http')) === 'https';
const defaultPort = isHttps ? 443 : 80;

window.Echo = new Echo({
    broadcaster: 'reverb',

    key: import.meta.env.VITE_REVERB_APP_KEY || 'wltdrmzy3kql9kdlcowf',

    wsHost: import.meta.env.VITE_REVERB_HOST || (typeof window !== 'undefined' ? window.location.hostname : 'localhost'),

    wsPort: Number(import.meta.env.VITE_REVERB_PORT ?? defaultPort),

    wssPort: Number(import.meta.env.VITE_REVERB_PORT ?? 443),

    forceTLS: isHttps,

    enabledTransports: ['ws', 'wss'],
});
