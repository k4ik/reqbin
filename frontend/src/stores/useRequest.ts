import { defineStore } from "pinia"
import { ref } from "vue"
import type { ApiRequest } from '@/types/request'

export const useRequestStore = defineStore('request', () => {
    const requests = ref<ApiRequest[]>([])
    const request = ref<ApiRequest | null>(null)

    const addRequest = (data: ApiRequest) => {
        const normalized = normalizeRequest(data)

        if (requests.value.find(r => r.id === normalized.id)) return

        requests.value.unshift(normalized)
    }

    const selectRequest = (id: number) => {
        const req = requests.value.find(r => r.id === id)

        if (req) {
            request.value = req
        }
    }

    const reset = () => {
        requests.value = []
        request.value = null
    }

    function normalizeRequest(req: any): ApiRequest {
        const created_at = normalizeTimestamp(req)

        return {
            ...req,

            created_at,

            id: req.id ?? `${created_at}-${Math.random()}`,

            headers: safeParse(req.headers),
            query_params: normalizeQueryParams(req.query_params),
            body: safeParse(req.body) ?? req.body,
        }
    }

    function normalizeTimestamp(req: any): number {
        if (req.timestamp) {
            return Number(req.timestamp) * 1000
        }

        return Date.now()
    }

    function normalizeQueryParams(value: any) {
        if (Array.isArray(value)) return {}
        return safeParse(value)
    }

    function safeParse(value: any) {
        try {
            return typeof value === 'string' ? JSON.parse(value) : value
        } catch {
            return value
        }
    }

    return {
        request,
        requests,
        addRequest,
        selectRequest,
        reset,
    }
})