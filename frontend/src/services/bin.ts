import api from "@/interface/api"

export async function createBin() {
    const { data } = await api.post('/bin/new')
    return data.bin
}