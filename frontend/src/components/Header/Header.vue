<template>
    <header class="header">
        <Logo />

        <nav class="header__nav">
            <div
                class="nav__field"
                v-if="store.hasBin"
                @click="copy(`http://localhost:8000/bin/${store.bin}`)"
            >
                <div class="live-dot"></div>

                <p class="field__endpoint">
                    /bin/{{ store.bin }}
                </p>

                <button class="field__button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <rect width="14" height="14" x="8" y="8" rx="2" ry="2" />
                        <path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2" />
                    </svg>

                    {{ copied ? 'Copied' : 'Copy' }}
                </button>
            </div>

            <BinButton />

            <button class="menu-btn" @click="$emit('toggle-menu')">
                ☰
            </button>
        </nav>
    </header>
</template>

<script setup lang="ts">
import BinButton from '@/components/Bin/Button.vue'
import { useBinStore } from '@/stores/useBin'
import { useClipboard } from '@/composables/useClipboard'
import Logo from '@/components/Header/Logo.vue'

const store = useBinStore()
const { copied, copy } = useClipboard()
</script>

<style scoped>
.header {
    position: fixed;
    inset: 0 0 auto 0;


    display: flex;
    align-items: center;
    justify-content: space-between;

    padding: 0 1rem;

    background: rgba(11, 16, 32);

    backdrop-filter: blur(14px);

    border-bottom: 1px solid var(--border);
    height: 10vh;
    z-index: 9999;
}

.header__nav {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.nav__field {
    height: 2.5rem;

    display: flex;
    align-items: center;
    gap: 0.75rem;

    padding: 0 0.85rem;

    border: 1px solid var(--border);

    background: var(--surface);

    border-radius: 0.6rem;

    cursor: pointer;

    transition: border-color 0.2s ease;
}

.nav__field:hover {
    border-color: rgba(124,92,255,0.45);
}

.field__endpoint {
    font-size: 0.8rem;
    color: var(--text);
}

.field__button {
    border: none;
    background: transparent;

    color: var(--muted);

    display: flex;
    align-items: center;
    gap: 0.4rem;

    font-size: 0.75rem;
}

.field__button svg {
    width: 0.9rem;
    height: 0.9rem;
}

.live-dot {
    width: 8px;
    height: 8px;

    border-radius: 999px;

    background: var(--success);

    animation: pulse 1.6s infinite;
}

@keyframes pulse {
    0% {
        opacity: 0.4;
        transform: scale(1);
    }

    50% {
        opacity: 1;
        transform: scale(1.3);
    }

    100% {
        opacity: 0.4;
        transform: scale(1);
    }
}

.menu-btn {
    display: none;

    width: 2.5rem;
    height: 2.5rem;

    border: 1px solid var(--border);

    background: var(--surface);

    color: var(--text);

    border-radius: 0.6rem;
}

@media (max-width: 1024px) {
    .menu-btn {
        display: block;
    }
}

@media (max-width: 768px) {
    .field__endpoint {
        display: none;
    }

    .field__button {
        font-size: 0;
    }
}
</style>