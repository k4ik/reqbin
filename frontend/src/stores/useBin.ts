import { ref, computed } from 'vue'
import { defineStore } from 'pinia'

export const useBinStore = defineStore('bin', () => {
  const bin = ref<string | null>(null);

  const hasBin = computed(() => !!bin.value);

  const setBin = (value: string) => {
    bin.value = value;
  }

  return {
    bin,
    setBin,
    hasBin
  }
})