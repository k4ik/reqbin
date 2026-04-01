<script setup lang="ts">
import { useRequestStore } from '@/stores/useRequest'
import { useBinStore } from '@/stores/useBin'
import { useTabsStore } from '@/stores/useTabs'
import { formatTime } from '@/helpers/formatTime'
import { getMethodStyle } from '@/helpers/getMethodStyle'
const requestStore = useRequestStore()
const binStore = useBinStore()
const tabsStore = useTabsStore()
</script>

<template>
    <section class="details" v-if="requestStore.request">
        <div class="details__header">
            <div class="details__top">
                <span class="method"
                    :style="{ color: getMethodStyle(requestStore.request.method).color, backgroundColor: getMethodStyle(requestStore.request.method).background }">{{
                        requestStore.request.method }}</span>
                <span class="endpoint">/bin/{{ binStore.bin }}</span>
            </div>

            <div class="details__meta">
                <span>IP: {{ requestStore.request.ip }}</span>
                <span>Time: {{ formatTime(requestStore.request.created_at) }}</span>
            </div>
        </div>

        <div class="details__tabs">
            <button :class="{ active: tabsStore.activeTab === 'headers' }"
                @click="tabsStore.setTab('headers')">Headers</button>
            <button :class="{ active: tabsStore.activeTab === 'body' }" @click="tabsStore.setTab('body')">Body</button>
            <button :class="{ active: tabsStore.activeTab === 'query' }"
                @click="tabsStore.setTab('query')">Query</button>
        </div>

        <div class="details__content">
            <div v-if="tabsStore.activeTab === 'headers'">
                <div v-for="(value, key) in requestStore.request.headers" :key="key" class="kv">
                    <span class="kv__key">{{ key }}</span>
                    <span class="kv__value">{{ value }}</span>
                </div>
            </div>

            <pre v-else-if="tabsStore.activeTab === 'body'">
{{ requestStore.request.body || 'Empty body' }}
            </pre>

            <div v-else>
                <div v-if="Object.keys(requestStore.request.query_params || {}).length">
                    <div v-for="(value, key) in requestStore.request.query_params" :key="key" class="kv">
                        <span class="kv__key">{{ key }}</span>
                        <span class="kv__value">{{ value }}</span>
                    </div>
                </div>
                <p v-else>No query params</p>
            </div>
        </div>
    </section>
</template>

<style scoped>
.details {
    width: 65%;
    margin-top: var(--header-height);
    height: calc(100vh - var(--header-height));
    padding-top: 0;
    display: flex;
    flex-direction: column;
    background-color: #f9fafb;
}

.details__header {
    padding: 1em;
    border-bottom: 1px solid rgba(0, 0, 0, 0.1);
}

.details__top {
    display: flex;
    align-items: center;
    gap: 0.5em;
    font-weight: 600;
}

.details__meta {
    margin-top: 0.5em;
    font-size: 0.8em;
    color: #666;
    display: flex;
    gap: 1em;
    flex-wrap: wrap;
}

.details__tabs {
    display: flex;
    gap: 1em;
    padding: 0.5em 1em;
    border-bottom: 1px solid rgba(0, 0, 0, 0.1);
}

.details__tabs button {
    background: none;
    border: none;
    font-size: 0.9em;
    cursor: pointer;
    padding-bottom: 0.3em;
}

.details__tabs button.active {
    border-bottom: 2px solid black;
    font-weight: 600;
}

.details__content {
    padding: 1em;
    overflow-y: auto;
}

.method {
    font-weight: 600;
    font-size: 0.95em;
    padding: 0.4em 0.9em;
    border-radius: 0.5em;
}

.details__content pre {
    background-color: #0f172a;
    color: #e2e8f0;
    padding: 1em;
    border-radius: 0.5em;
    font-size: 0.8em;
    overflow-x: auto;
}

.kv {
    display: flex;
    justify-content: space-between;
    padding: 0.5em;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    font-size: 0.85em;
}

.kv__key {
    font-weight: 500;
    color: #111;
}

.kv__value {
    color: #555;
    word-break: break-all;
    overflow-wrap: anywhere;
}

@media (max-width: 1024px) {
    .details {
        width: 100%;
        padding-top: 0;
    }
}

@media (max-width: 768px) {
    .endpoint {
        font-size: 1em;
        word-break: break-all;
    }
}
</style>