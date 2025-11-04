<template>
    <div>

        <Modal :show="showModal" @close="closeModal" >
            <Create @cancel="closeModal" @created="handleCreated" />
        </Modal>

        <modal :show="showModalDelete" @close="closeModalDelete">
            <Delete @cancel="closeModalDelete" @done="handleDeleted" :categoria="categoriaSeleccionada" />
        </modal>


        <Modal :show="showModalUpdate" @close="closeModalUpdate" >
            <Update @cancel="closeModalUpdate" @done="handleupdated" :categoria="categoriaSeleccionada" />
        </Modal>
        <button class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 focus:outline-none" @click="openCreateModal" type="button">
            Crear Categoria
        </button>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Nombre
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Descripcion
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="categoria in categorias" :key="categoria.id"
                        class="odd:bg-white">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap ">
                            {{ categoria.nombre }}
                        </th>
                        <td class="px-6 py-4">
                            {{ categoria.descripcion }}
                        </td>
                        <td class="px-6 py-4">
                            <button @click="openCreateModalDelete(categoria)"  class="font-medium text-blue-600 m-2 hover:underline">Delete</button>
                            <button @click="openCreateModalUpdate(categoria)"  class="font-medium text-blue-600 m-2    hover:underline">Edit</button>

                        </td>
                    </tr>
                    
                </tbody>
            </table>
        </div>

        

    </div>
</template>

<script setup>
import { Link, usePage, router } from '@inertiajs/vue3';
import Layout from '../../Layout/Layout.vue';
import Modal from '../../../Components/Modal.vue';
import { ref } from 'vue';
import Create from './Create.vue';
import Delete from './Delete.vue';
import Update from './Update.vue';




const showModal = ref(false)
const openCreateModal = () => (showModal.value = true)
const closeModal = () => (showModal.value = false)
const categoriaSeleccionada = ref(null)

const showModalDelete = ref(false)
const closeModalDelete = () => (showModalDelete.value = false)

const showModalUpdate = ref(false)
const closeModalUpdate = () => (showModalUpdate.value = false)



const openCreateModalDelete = (categoria) => {
    showModalDelete.value = true
    categoriaSeleccionada.value = categoria
}
const openCreateModalUpdate = (categoria) => {
    showModalUpdate.value = true
    categoriaSeleccionada.value = categoria
}



function handleCreated() {
    showModal.value = false
    router.visit('/categoria', { method: 'get' })
}

function handleDeleted() {
    showModalDelete.value = false
    router.visit('/categoria', { method: 'get' })
}

function handleupdated() {
    showModalUpdate.value = false
    router.visit('/categoria', { method: 'get' })
}

Layout
defineOptions({ 
    layout: Layout
})

const { categorias } = usePage().props

console.log(categorias);

</script>