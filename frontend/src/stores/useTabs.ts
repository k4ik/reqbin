import { defineStore } from "pinia"
import { ref } from "vue"

export const useTabsStore = defineStore('tabs', () => {
    const activeTab = ref<'headers' | 'body' | 'query'>('headers')

    const setTab = (tab: typeof activeTab.value) => {
        activeTab.value = tab
    }

    const reset = () => {
        activeTab.value = 'headers'
    }

    return {
        activeTab,
        setTab,
        reset
    }
})