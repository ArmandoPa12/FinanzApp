<template>
    <div>
        <div class="flex gap-x-2">
            <a href="/transaccion/export" class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">
                Exportar a Excel
            </a>

            <form @submit.prevent="uploadFile" class="space-y-2">
                <input type="file" @change="handleFile" accept=".xlsx,.xls,.csv" />
                <button type="submit" class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700">
                    Importar
                </button>
            </form>
        </div>
    </div>
</template>
<script setup>
import { ref } from 'vue';
import Layout from '../../Layout/Layout.vue';


//export
const file = ref(null)
function handleFile(e) {
  file.value = e.target.files[0]
}
function uploadFile() {
  const formData = new FormData()
  formData.append('file', file.value)
  router.post('/transaccion/import', formData)
}

defineOptions({
    layout: Layout
})
</script>