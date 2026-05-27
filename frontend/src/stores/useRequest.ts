import { defineStore } from 'pinia'
import { ref } from 'vue'

import type { ApiRequest } from '@/types/request'

import {
    listenToBin,
    stopListeningToBin,
} from '@/services/socket/socket'

export const useRequestStore = defineStore(
    'request',
    () => {
        const requests = ref<ApiRequest[]>([])
        const selectedRequest = ref<ApiRequest | null>(null)

        function connectToBin(bin: string): void {
            listenToBin(bin, (data) => {
                addRequest(data)
            })
        }

        function disconnectFromBin(bin: string): void {
            stopListeningToBin(bin)
        }

        function addRequest(data: ApiRequest): void {
            const normalizedRequest = normalizeRequest(data)

            const alreadyExists = requests.value.some(
                (request) => request.id === normalizedRequest.id
            )

            if (alreadyExists) return

            requests.value.unshift(normalizedRequest)
        }

        function selectRequest(id: number): void {
            selectedRequest.value =
                requests.value.find(
                    (request) => request.id === id
                ) ?? null
        }

        function reset(): void {
            requests.value = []
            selectedRequest.value = null
        }

        function normalizeRequest(
            request: any
        ): ApiRequest {
            const createdAt = normalizeTimestamp(request)

            return {
                ...request,

                id:
                    request.id ??
                    `${createdAt}-${Math.random()}`,

                created_at: createdAt,

                headers: safeParse(request.headers),

                query_params: normalizeQueryParams(
                    request.query_params
                ),

                body:
                    safeParse(request.body) ??
                    request.body,
            }
        }

        function normalizeTimestamp(
            request: any
        ): number {
            if (request.timestamp) {
                return Number(request.timestamp) * 1000
            }

            return Date.now()
        }

        function normalizeQueryParams(value: any) {
            if (Array.isArray(value)) {
                return {}
            }

            return safeParse(value)
        }

        function safeParse(value: any) {
            try {
                return typeof value === 'string'
                    ? JSON.parse(value)
                    : value
            } catch {
                return value
            }
        }

        return {
            selectedRequest,
            requests,

            connectToBin,
            disconnectFromBin,

            addRequest,
            selectRequest,

            reset,
        }
    }
)