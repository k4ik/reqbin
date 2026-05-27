import { defineStore } from 'pinia'
import { ref } from 'vue'

type Tab = 'headers' | 'body' | 'query'

export const useTabsStore = defineStore(
    'tabs',
    () => {
        const activeTab = ref<Tab>('headers')

        function setTab(tab: Tab): void {
            activeTab.value = tab
        }

        function reset(): void {
            activeTab.value = 'headers'
        }

        return {
            activeTab,

            setTab,
            reset,
        }
    }
)