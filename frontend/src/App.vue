<script setup lang="ts">
import Header from '@/components/Header/Header.vue'
import { useBinStore } from '@/stores/useBin'
import { useRequestStore } from '@/stores/useRequest'
import { ref, watch } from 'vue'
import RequestDetails from './components/Request/RequestDetails.vue'
import RequestList from './components/Request/RequestList.vue'
import { useRequestSocket } from './composables/useWebsockets'

const binStore = useBinStore()
const requestStore = useRequestStore()
const { listenToBin, stopListening } = useRequestSocket()

const isMenuOpen = ref(false)

watch(
    () => binStore.bin,
    (newBin, oldBin) => {
        if (oldBin) stopListening(oldBin)

        if (newBin) {
            requestStore.reset()
            listenToBin(newBin)
        }
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
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=JetBrains+Mono:wght@100..800&display=swap');

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    scrollbar-width: thin;
    scrollbar-color: rgba(124, 92, 255, 0.7) rgba(255, 255, 255, 0.03);
}

*::-webkit-scrollbar {
    width: 10px;
    height: 10px;
}

*::-webkit-scrollbar-track {
    background: rgba(255, 255, 255, 0.03);
}

*::-webkit-scrollbar-thumb {
    background: linear-gradient(180deg,
            rgba(124, 92, 255, 0.9),
            rgba(124, 92, 255, 0.55));

    border-radius: 999px;

    border: 2px solid transparent;
    background-clip: padding-box;
}

*::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(180deg,
            rgba(140, 110, 255, 1),
            rgba(124, 92, 255, 0.75));

    border-radius: 999px;
}

*::-webkit-scrollbar-corner {
    background: transparent;
}

:root {
    --header-height: 3.5rem;

    --bg: #0b1020;
    --surface: rgba(15, 23, 42, 0.72);
    --surface-light: rgba(255, 255, 255, 0.03);

    --border: rgba(255, 255, 255, 0.06);

    --text: #e6eaf2;
    --muted: #7f8aa3;

    --primary: #7c5cff;
    --success: #3ddc97;
    --danger: #ff5d73;
}


html,
body,
#app {
    height: 100%;
}

body {
    font-family: "Inter", sans-serif;

    color: var(--text);

    background-color: #0b1020;

    background-image:
        linear-gradient(rgba(255, 255, 255, 0.025) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255, 255, 255, 0.025) 1px, transparent 1px);

    background-size: 24px 24px;

    overflow: hidden;
}

button {
    font-family: inherit;
}

main {
    display: flex;
    height: 100dvh;
    overflow: hidden;
}

.endpoint,
.method,
.field__endpoint,
pre,
.kv__key {
    font-family: "JetBrains Mono", monospace;
}


@media (max-width: 1024px) {
    main {
        display: flex; 
        position: relative;
        width: 100%;
    }
}
</style>