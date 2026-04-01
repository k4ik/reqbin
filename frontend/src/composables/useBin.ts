import api from "@/interface/api"
import { useBinStore } from "@/stores/useBin"

export function useBin() {
    const store = useBinStore()

    const createBin = async () => {
        const { data } = await api.post('/bin/new')
        store.setBin(data.bin)
    }

    return { createBin }
}