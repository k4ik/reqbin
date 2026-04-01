<template>
    <button @click.prevent="createBin">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
            class="lucide lucide-plus-icon lucide-plus">
            <path d="M5 12h14" />
            <path d="M12 5v14" />
        </svg>
        <span>New</span>
    </button>
</template>

<script setup lang="ts">
import { useBin } from '@/composables/useBin';
const { createBin } = useBin();
</script>

<style scoped>
button {
    display: flex;
    align-items: center;
    border: none;
    background-color: rgb(230, 228, 228);
    gap: 0.5em;
    border-radius: 0.8em;
    padding: 0.8em;
    font-size: 0.85em;

}

svg {
    width: 1.2em;
    height: 1.2em;
}

@media (max-width: 1024px) {
    span {
        display: none;
    }
}
</style>