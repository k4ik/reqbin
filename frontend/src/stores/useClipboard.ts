import { ref, computed } from 'vue'
import { defineStore } from 'pinia'

export const useClipboardStore = defineStore('clipboard', () => {
    const copied = ref(false)

    async function copy(text: string) {
        try {
            await navigator.clipboard.writeText(text)
            copied.value = true

            setTimeout(() => {
                copied.value = false
            }, 2000)
        } catch (err) {
            console.error('Copy failed', err)
        }
    }
    return {
        copied,
        copy
    }
})
