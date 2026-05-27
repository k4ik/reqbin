import Echo from 'laravel-echo'
import Pusher from 'pusher-js'

(window as any).Pusher = Pusher

export const echo = new Echo({
    broadcaster: 'pusher',

    key: import.meta.env.VITE_SOKETI_APP_KEY,

    cluster: 'mt1',

    wsHost: window.location.hostname,
    wsPort: 6001,

    forceTLS: false,
    encrypted: false,

    enabledTransports: ['ws', 'wss'],

    disableStats: true,
})