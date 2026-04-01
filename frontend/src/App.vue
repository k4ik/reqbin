<script setup lang="ts">
import Header from '@/components/Header/Header.vue'
import { useBinStore } from '@/stores/useBin'
import { useRequestStore } from '@/stores/useRequest'
import { useRequests } from '@/composables/useRequest'
import { ref, watch } from 'vue'
import { useTabsStore } from '@/stores/useTabs'
import RequestDetails from './components/Request/RequestDetails.vue'
import RequestList from './components/Request/RequestList.vue'
const tabsStore = useTabsStore()
const binStore = useBinStore()
const requestStore = useRequestStore()
const { startPolling, stopPolling } = useRequests()

const isMenuOpen = ref(false)

watch(
    () => binStore.bin,
    (bin) => {
        requestStore.reset()
        tabsStore.reset()
        
        if (bin) startPolling()
        else stopPolling()
    },
    { immediate: true }
)
</script>

<template>
    <Header @toggle-menu="isMenuOpen = !isMenuOpen" />

    <main>
        <RequestList :open="isMenuOpen" @close="isMenuOpen = false" />
        <RequestDetails />
    </main>
</template>
<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap');

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: "Inter", sans-serif;
}

:root {
    --header-height: 4.5em;
}

main {
    display: flex;
    justify-content: space-between;
    gap: 1rem;
}

@media (max-width: 1024px) {
    main {
        flex-direction: column;
    }
}

</style>
