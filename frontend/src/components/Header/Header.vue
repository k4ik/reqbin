<template>
    <header class="header">
        <Logo />

        <nav class="header__nav">
            <div class="nav__field" v-if="store.hasBin"
                @click="clipboardStore.copy(`http://localhost:8000/bin/${store.bin}`)">
                <p class="field__endpoint">
                    bin/{{ store.bin }}
                </p>

                <button class="field__button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-copy-icon lucide-copy">
                        <rect width="14" height="14" x="8" y="8" rx="2" ry="2" />
                        <path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2" />
                    </svg>
                    {{ clipboardStore.copied ? 'Copied!' : 'Copy URL' }}
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
import BinButton from '@/components/Bin/Button.vue';
import { useBinStore } from '@/stores/useBin';
import { useClipboardStore } from '@/stores/useClipboard';
import Logo from '@/components/Header/Logo.vue';

const store = useBinStore()
const clipboardStore = useClipboardStore()
</script>

<style scoped>
.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1em;
    border-bottom: 1px solid rgba(128, 128, 128, 0.548);
    position: fixed;
    width: 100%;
    top: 0;
    z-index: 9998;
    background-color: #FFF;
}

.header__nav {
    display: flex;
    gap: 0.5em;
    align-items: center;
}

.nav__field {
    display: flex;
    align-items: center;
    background-color: rgb(230, 228, 228);
    padding: 0.8em;
    gap: 1em;
    border-radius: 0.8em;
    font-size: 0.85em;
}

.field__button {
    background: transparent;
    border: none;
    display: flex;
    align-items: center;
    gap: 0.5em;
    font-size: 0.75em;

}

.field__button svg {
    width: 1.2em;
    height: 1.2em;
}

.menu-btn {
    display: none;
    font-size: 1.2em;
    background: none;
    border: none;
    padding: 0.3em 0.6em;
    border-radius: 0.5em;
}

.menu-btn:active {
    background: rgba(0,0,0,0.05);
}

@media (max-width: 1024px) {
    .menu-btn {
        display: block;
    }

}

@media (max-width: 768px) {
    .header__nav {
        gap: 1em;
    }


    .field__endpoint {
        display: none;
    }
}
</style>