import { ref, computed } from 'vue'
import { defineStore } from 'pinia'
import type { Bin } from '@/types/bin';

export const useBinStore = defineStore('bin', () => {
  const bin = ref<Bin | null>(null);
  const hasBin = computed(() => bin.value);
  const setBin = (data: Bin) => {
    bin.value = data;
  }

  return {
    bin,
    setBin,
    hasBin
  }
})
