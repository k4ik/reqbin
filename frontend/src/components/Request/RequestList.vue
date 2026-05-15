<script setup lang="ts">
import { useRequestStore } from '@/stores/useRequest'
import { useBinStore } from '@/stores/useBin'
import { formatTime } from '@/helpers/formatTime'
import { getMethodStyle } from '@/helpers/getMethodStyle'
const requestStore = useRequestStore()
const binStore = useBinStore()

const handleSelect = (id: number) => {
    requestStore.selectRequest(id)
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

            <div v-if="requestStore.requests.length" class="requests__display">
                <div class="request" v-for="item in requestStore.requests" :key="item.id" @click="handleSelect(item.id)"
                    :class="{ active: requestStore.request?.id === item.id }">
                    <div class="request_data">
                        <span class="method"
                            :style="{ color: getMethodStyle(item.method).color, backgroundColor: getMethodStyle(item.method).background }">{{
                                item.method }}</span>
                        <span class="endpoint">
                            {{ `/bin/${binStore.bin}` }}
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
    width: 34%;
    min-width: 360px;

    border-right: 1px solid var(--border);

    position: relative;

    height: 100dvh;
    overflow: hidden;
}

.requests__panel {
    height: 100dvh;

    padding-top: var(--header-height);

    background: rgba(15, 23, 42, 0.72);
    backdrop-filter: blur(14px);

    display: flex;
    flex-direction: column;

    overflow: hidden;
}

.head {
    padding: 2em 1rem;

    background: rgba(15, 23, 42, 0.92);

    border-bottom: 1px solid var(--border);

    z-index: 10;

    flex-shrink: 0;
}

.requests__display {
    flex: 1;

    overflow-y: auto;
    overflow-x: hidden;

    min-height: 0;

    scrollbar-gutter: stable;
}

.head h1 {
    font-size: 0.95rem;
}

.head p {
    color: var(--muted);

    font-size: 0.75rem;
}

.request {
    position: relative;

    padding: 0.85rem 1rem;

    border-bottom: 1px solid rgba(255, 255, 255, 0.04);

    cursor: pointer;

    transition: background 0.2s ease;
}

.request:hover {
    background: rgba(255, 255, 255, 0.025);
}

.request.active::before {
    content: "";

    position: absolute;

    left: 0;
    top: 10px;
    bottom: 10px;

    width: 3px;

    border-radius: 999px;

    background: var(--primary);
}

.request_data {
    display: flex;
    align-items: center;
    gap: 0.6rem;
    width: 100%;
    min-width: 0;
}

.request_details {
    margin-top: 0.55rem;

    display: flex;
    justify-content: space-between;

    font-size: 0.74rem;

    color: var(--muted);
}

.method {
    font-size: 0.68rem;
    font-weight: 700;

    padding: 0.35rem 0.7rem;

    border-radius: 999px;
}

.endpoint {
    font-size: 0.83rem;
    font-weight: 500;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    flex: 1;
}

.overlay {
    display: none;
}

@media (max-width: 1024px) {
    .requests {
        width: 0;
        min-width: 0;

        border-right: none;

        overflow: visible;
    }

    .requests__panel {
        position: fixed;

        width: min(420px, 100%);
        height: 100vh;

        left: 0;
        top: 0;

        transform: translateX(-100%);

        transition: transform 0.3s ease;

        z-index: 100;

        border-radius: 0 1rem 1rem 0;
    }

    .requests.open .requests__panel {
        transform: translateX(0);
    }

    .overlay {
        display: block;

        position: fixed;
        inset: 0;

        background: rgba(0, 0, 0, 0.5);

        opacity: 0;
        pointer-events: none;

        transition: opacity 0.3s ease;

        z-index: 99;
    }

    .requests.open .overlay {
        opacity: 1;
        pointer-events: all;
    }
}
</style>