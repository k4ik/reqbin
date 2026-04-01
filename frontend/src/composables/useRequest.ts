import api from "@/interface/api"
import { useRequestStore } from "@/stores/useRequest"
import { useBinStore } from "@/stores/useBin"
import { ref, onUnmounted } from "vue"

export function useRequests() {
    const requestStore = useRequestStore()
    const binStore = useBinStore()

    const loading = ref(false)
    let interval: number | null = null

    const fetchRequests = async () => {
        if (!binStore.bin) return

        loading.value = true

        try {
            const { data } = await api.get(`/bin/${binStore.bin}/requests`)

            const normalized = data
                .map(normalizeRequest)
                .sort((a: any, b: any) => b.created_at - a.created_at)

            requestStore.setRequests(normalized)
        } finally {
            loading.value = false
        }
    }

    const startPolling = () => {
        stopPolling()

        fetchRequests()

        interval = setInterval(fetchRequests, 10000)
    }

    const stopPolling = () => {
        if (interval) {
            clearInterval(interval)
            interval = null
        }
    }

    const selectRequest = (id: number) => {
        const req = requestStore.requests.find(r => r.id === id)
        if (req) requestStore.setRequest(req)
    }
    function normalizeRequest(req: any) {
        return {
            ...req,
            headers: safeParse(req.headers),
            query_params: safeParse(req.query_params),
            body: safeParse(req.body) ?? req.body,
        }
    }

    function safeParse(value: any) {
        try {
            return typeof value === 'string' ? JSON.parse(value) : value
        } catch {
            return value
        }
    }

    onUnmounted(stopPolling)

    return {
        loading,
        fetchRequests,
        startPolling,
        stopPolling,
        selectRequest
    }
}