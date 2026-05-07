import Echo from 'laravel-echo'
import Pusher from 'pusher-js'
import { useRequestStore } from '@/stores/useRequest'

(window as any).Pusher = Pusher

const echo = new Echo({
    broadcaster: 'pusher',
    key: 'e79c5aff8362a28faddc6751086dbceb',
    cluster: 'mt1',
    wsHost: window.location.hostname,
    wsPort: 6001,
    forceTLS: false,
    encrypted: false,
    enabledTransports: ['ws', 'wss'],
    disableStats: true,
})

export function useRequestSocket() {
    const requestStore = useRequestStore()

    const listenToBin = async (bin: string) => {
        if (!bin) {
            console.log('⛔ Invalid bin')
            return
        }

        const channelName = `bin-${bin}`
        const channel = echo.channel(channelName)

        channel.listen('.request.received', (data: any) => {
            requestStore.addRequest(data)
        })

        channel.error((err: any) => {
            console.error('❌ CHANNEL ERROR:', err)
        })
    }

    const stopListening = (bin: string) => {
        if (!bin) return

        const channelName = `bin-${bin}`
        echo.leave(channelName)
    }

    return { listenToBin, stopListening }
}