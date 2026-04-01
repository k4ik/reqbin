<script setup lang="ts">
import { useRequestStore } from '@/stores/useRequest'
import { useBinStore } from '@/stores/useBin'
import { useRequests } from '@/composables/useRequest'
import { formatTime } from '@/helpers/formatTime'
import { getMethodStyle } from '@/helpers/getMethodStyle'
const requestStore = useRequestStore()
const binStore = useBinStore()
const { selectRequest } = useRequests()

const handleSelect = (id: number) => {
    selectRequest(id)
    emit('close')
}

const props = defineProps<{
    open: boolean
}>()

const emit = defineEmits<{
    (e: 'close'): void
}>()
</script>

<template>
    <section class="requests" :class="{ open: props.open }">
        <div class="overlay" @click="$emit('close')"></div>

        <div class="requests__panel">
            <div class="head">
                <h1>Recent Requests</h1>
                <p>{{ requestStore.requests.length }} captured</p>
            </div>

            <div v-if="requestStore.requests.length">
                <div class="request" v-for="item in requestStore.requests" :key="item.id" @click="handleSelect(item.id)"
                    :class="{ active: requestStore.request?.id === item.id }">
                    <div class="request_data">
                        <span class="method"
                            :style="{ color: getMethodStyle(item.method).color, backgroundColor: getMethodStyle(item.method).background }">{{
                                item.method }}</span>
                        <span class="endpoint">
                            /bin/{{ binStore.bin }}
                        </span>
                    </div>

                    <div class="request_details">
                        <span class="ip">{{ item.ip }}</span>
                        <span class="created_at">{{ formatTime(item.created_at) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<style scoped>
.requests {
    width: 35%;
    height: auto;
    overflow-y: auto;
    border-right: 1px solid rgba(0, 0, 0, 0.164);
    scrollbar-width: thin;
    scrollbar-color: rgb(230, 228, 228) #ffffff;
    position: relative;
}

.requests__panel {
    padding-top: var(--header-height);
    height: 100vh;
    background: white;
    border-right: 1px solid rgba(0, 0, 0, 0.1);
    overflow-y: auto;
    transition: transform 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    will-change: transform;
    box-shadow: 4px 0 20px rgba(0, 0, 0, 0.08);
}

.head {
    padding: 1em;
    border-bottom: 1px solid rgba(0, 0, 0, 0.164);
}

.head h1 {
    font-size: 1.1em;
}

.head p {
    font-size: 0.8em;
    color: rgb(88, 88, 88);
}

.request {
    display: flex;
    flex-direction: column;
    gap: 0.5em;
    padding: 1em;
    border-bottom: 1px solid rgba(0, 0, 0, 0.164);
    cursor: pointer;
    transition: background 0.2s ease;
}

.request_data {
    display: flex;
    align-items: center;
    gap: 0.5em;
}

.request_details {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.method {
    font-weight: 600;
    font-size: 0.75em;
    padding: 0.4em 0.9em;
    border-radius: 0.5em;
}

.endpoint,
.ip,
.created_at {
    font-size: 0.8em;
    color: rgb(88, 88, 88);
}

.request.active {
    background-color: #f1f5f9;
    border-left: 3px solid #0f172a;
}

@media (max-width: 1024px) {

    .requests {
        width: 100%;
        max-width: none;
    }

    .requests__panel {
        position: fixed;
        left: 0;
        z-index: 100;
        transform: translateX(-100%);
    }

    .requests.open .requests__panel {
        transform: translateX(0);
    }

    .overlay {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.4);
        z-index: 99;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.3s ease;
    }

    .requests.open .overlay {
        opacity: 1;
        pointer-events: all;
    }
}
 
@media (max-width: 425px) {
    .requests__panel {
        max-width: 100%;
    }

    .endpoint {
        word-break: break-all;
    }
}
</style>