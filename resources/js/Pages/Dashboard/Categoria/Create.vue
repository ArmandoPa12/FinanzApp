<template>
    <div class="p-4">
        <h1 class="text-2xl font-bold mb-4">Crear Categoria</h1>
        <form class="max-w-sm mx-auto" @submit.prevent="submit">
            <div class="mb-5">
                <label for="text" class="block mb-2 text-sm font-medium text-gray-900">Nombre</label>
                <input type="text" v-model="form.nombre"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    required />
            </div>
            <div class="mb-5">
                <label for="text" class="block mb-2 text-sm font-medium text-gray-900">Descripcion</label>
                <input type="text" v-model="form.descripcion"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    required />
            </div>

            <div class="flex justify-end gap-2">
                <button type="submit"
                :disabled="form.processing" 
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">
                    Guardar
                </button>
                <button type="button" @click="$emit('cancel')" class="px-3 py-1 border rounded">
                    Cancelar
                </button>
            </div>

            <div v-if="Object.keys(form.errors).length">
                <h3>Errores:</h3>
                <ul>
                    <li v-for="(error, key) in form.errors" :key="key">{{ error }}</li>
                </ul>
            </div>
        </form>


    </div>
</template>
<script setup>
import { Link, router, useForm } from '@inertiajs/vue3';
import Layout from '../../Layout/Layout.vue';
const emits = defineEmits(['cancel', 'created'])


const form = useForm({
    nombre: '',
    descripcion: '',
})
const submit = () => {
    form.post('/categoria/store', {
        onError: () => form.reset('nombre'),
        onSuccess: () => {
            emits('done')
            form.reset()
        },
    })
}

Layout
defineOptions({
    layout: Layout
})
</script>