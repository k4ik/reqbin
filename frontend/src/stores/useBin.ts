import { ref, computed } from 'vue'
import { defineStore } from 'pinia'
import * as binService from '@/services/bin'

export const useBinStore = defineStore('bin', () => {
  const bin = ref<string | null>(null)
  const hasBin = computed(() => !!bin.value)

  async function createBin() {
    bin.value = await binService.createBin()
  }

  return {
    bin,
    hasBin,

    createBin
  }
})