export function formatTime(ts: number) {
    return new Date(ts * 1000).toLocaleString()
}