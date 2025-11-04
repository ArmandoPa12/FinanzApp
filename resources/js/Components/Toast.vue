<template>
  <Transition name="fade">
    <div
      v-if="visible"
      class="fixed top-5 right-5 z-50 px-4 py-3 rounded-lg shadow-lg text-white font-semibold"
      :class="toastClass"
    >
      {{ message }}
    </div>
  </Transition>
</template>

<script setup>
import { computed, ref } from 'vue'


const visible = ref(false)
const message = ref('')
const type = ref('success')

const show = (msg, t = 'success', duration = 3000) => {
  message.value = msg
  type.value = t
  visible.value = true

  setTimeout(() => {
    visible.value = false
  }, duration)
}

const toastClass = computed(() => {
  return {
    'bg-green-500': type.value === 'success',
    'bg-red-500': type.value === 'error',
    'bg-yellow-500': type.value === 'warning',
    'bg-blue-500': type.value === 'info',
  }
})

// Exportamos el método `show` para usarlo fuera del componente
defineExpose({ show })
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s ease;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
