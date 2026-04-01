import { defineStore } from "pinia"
import { ref } from "vue"
import type { ApiRequest } from '@/types/request'

export const useRequestStore = defineStore('request', () => {
    const requests = ref<ApiRequest[]>([])
    const request = ref<ApiRequest|null>()

    const setRequests = (data: ApiRequest[]) => {
        requests.value = data
    }

    const setRequest = (data: ApiRequest) => {
        request.value = data
    }

    const reset = () => {
        requests.value = []
        request.value = null
    }

    return {
        request,
        requests,
        setRequests,
        setRequest,
        reset
    }
})