export type ApiRequest = {
    id: number
    method: string
    headers: Record<string, any>
    body: any
    query_params: Record<string, any>
    ip: string
    created_at: number
}