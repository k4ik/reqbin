<template>
    <button @click.prevent="createBin">
        <svg xmlns="http://www.w3.org/2000/svg"
            width="24"
            height="24"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round">
            <path d="M5 12h14" />
            <path d="M12 5v14" />
        </svg>

        <span>New</span>
    </button>
</template>

<script setup lang="ts">
import { useBin } from '@/composables/useBin'
const { createBin } = useBin()
</script>

<style scoped>
button {
    height: 2.5rem;

    display: flex;
    align-items: center;
    gap: 0.5rem;

    padding: 0 0.9rem;

    border: 1px solid var(--border);

    background: var(--surface);

    color: var(--text);

    border-radius: 0.6rem;

    font-size: 0.8rem;
    font-weight: 500;
}

button:hover {
    border-color: rgba(124,92,255,0.45);
}

svg {
    width: 1rem;
    height: 1rem;
}

@media (max-width: 1024px) {
    span {
        display: none;
    }

    button {
        width: 2.5rem;
        justify-content: center;
        padding: 0;
    }
}
</style>