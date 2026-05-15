export function truncate(
    value: string,
    maxLength: number = 50
): string {
    if (!value) return ''

    if (value.length <= maxLength) {
        return value
    }

    return `${value.slice(0, maxLength)}...`
}