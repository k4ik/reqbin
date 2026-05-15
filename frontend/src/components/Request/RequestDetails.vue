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
                <span class="endpoint">{{ `/bin/${binStore.bin}` }}</span>
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
    flex: 1;
    min-width: 0;

    margin-top: var(--header-height);

    height: calc(100dvh - var(--header-height));

    display: flex;
    flex-direction: column;

    overflow: hidden;
}

.details__header {
    padding: 2rem 1.5rem;

    border-bottom: 1px solid var(--border);
}

.details__top {
    display: flex;
    align-items: center;
    gap: 0.7rem;
    min-width: 0;
    width: 100%;
}

.method {
    font-size: 0.72rem;
    font-weight: 700;

    padding: 0.4rem 0.8rem;

    border-radius: 999px;
}

.endpoint {
    font-size: 0.92rem;
    font-weight: 600;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    flex: 1;
}

.details__meta {
    margin-top: 0.8rem;

    display: flex;
    flex-wrap: wrap;
    gap: 1rem;

    font-size: 0.76rem;

    color: var(--muted);
}

.details__tabs {
    display: flex;
    gap: 0.4rem;

    padding: 0.8rem 1.5rem;

    border-bottom: 1px solid var(--border);
}

.details__tabs button {
    border: none;

    background: transparent;

    color: var(--muted);

    padding: 0.55rem 0.8rem;

    border-radius: 0.45rem;

    font-size: 0.8rem;
}

.details__tabs button.active {
    background: rgba(124, 92, 255, 0.14);

    color: var(--primary);
}

.details__content {
    flex: 1;

    overflow-y: auto;

    padding: 1.5rem;
}

.details__content pre {
    background:
        linear-gradient(180deg,
            rgba(255, 255, 255, 0.02),
            transparent),
        #0d1325;

    border: 1px solid var(--border);

    box-shadow:
        inset 0 1px 0 rgba(255, 255, 255, 0.03);

    color: #dbe7ff;

    padding: 1.2rem;

    border-radius: 0.6rem;

    overflow-x: auto;

    line-height: 1.6;

    font-size: 0.8rem;
}

.kv {
    display: flex;
    justify-content: space-between;
    gap: 1rem;

    padding: 1rem 0;

    border-bottom: 1px solid rgba(255, 255, 255, 0.04);
}

.kv__key {
    font-size: 0.82rem;
    color: var(--text);
}

.kv__value {
    font-size: 0.8rem;

    color: var(--muted);

    text-align: right;

    word-break: break-all;
}

@media (max-width: 1024px) {
    .details {
        height: auto;
        min-height: calc(100dvh - var(--header-height));

        overflow: visible;
    }

    .details__content {
        overflow-y: visible;
    }
}

@media (max-width: 768px) {
    .details__content {
        padding: 1rem;
    }

    .kv {
        flex-direction: column;
    }

    .kv__value {
        text-align: left;
    }
}
</style>