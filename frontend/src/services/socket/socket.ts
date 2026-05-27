import { echo } from '@/services/socket/echo'
import type { ApiRequest } from '@/types/request'

type RequestCallback = (request: ApiRequest) => void

export function listenToBin(
    bin: string,
    callback: RequestCallback
): void {
    if (!bin) {
        console.error('Invalid bin')

        return
    }

    const channelName = `bin-${bin}`

    echo.channel(channelName)
        .listen(
            '.request.received',
            (data: ApiRequest) => {
                callback(data)
            }
        )
        .error((error: unknown) => {
            console.error('Channel error:', error)
        })
}

export function stopListeningToBin(bin: string): void {
    if (!bin) return

    echo.leave(`bin-${bin}`)
}