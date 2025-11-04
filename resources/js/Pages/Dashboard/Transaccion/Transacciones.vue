<template>
    <div>
        <h1 class="my-3"> {{ mode === 'create' ? 'Crear' : 'Actualizar' }} Transacción</h1>





        <form @submit.prevent="submit">

            <div class="flex gap-4">
                <div class="flex-2 items-center">
                    <span class="m-3 text-sm font-medium text-dark-300">Entrada</span>
                    <label class="inline-flex items-center cursor-pointer">

                        <input type="checkbox" v-model="form.tipo" value="" class="sr-only peer">
                        <div
                            class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600 dark:peer-checked:bg-blue-600">
                        </div>

                    </label>
                    <span class="ms-3 text-sm font-medium text-dark-300">Salida</span>
                </div>
                <div class="flex-2 items-center">
                    <span class="m-3 text-sm font-medium text-dark-300">Efectivo</span>
                    <label class="inline-flex items-center cursor-pointer">

                        <input type="checkbox" v-model="form.tipo_pago" value="" class="sr-only peer">
                        <div
                            class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600 dark:peer-checked:bg-blue-600">
                        </div>

                    </label>
                    <span class="ms-3 text-sm font-medium text-dark-300">Qr</span>
                </div>

            </div>



            <div class="items-center">
                <label for="number-input" class="block mb-2 text-sm font-medium text-gray-900">Ingresar monto:</label>
                <input v-model="form.monto" min="0" type="decimal" id="number-input"
                    aria-describedby="helper-text-explanation"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    placeholder="0" required />
            </div>


            <div>

                <label for="message" class="block mb-2 text-sm font-medium text-gray-900 ">Your
                    message</label>
                <textarea v-model="form.descripcion" id="message" rows="4"
                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="saldo/alquiler..."></textarea>

            </div>

            <div>
                <label for="countries" class="mb-2 text-sm font-medium text-gray-900">Categoría</label>
                <select required v-model="form.categoria_id" id="countries"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    <option v-for="categoria in categorias" :key="categoria.id" :value="categoria.id">
                        {{ categoria.nombre }}
                    </option>
                </select>
            </div>



            <div class="relative max-w-sm">
                <label for="message" class="block mb-2 text-sm font-medium text-gray-900 ">Fecha</label>

                <input id="default-datepicker" v-model="form.fecha" type="date"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    placeholder="Select date">
            </div>

            <br />
            <div class="flex gap-x-2">

                <button type="submit" :disabled="form.processing"
                    class="px-2 py-1 text-xs font-medium text-center text-white bg-blue-500 rounded-lg hover:bg-blue-400 focus:ring-4 focus:outline-none focus:ring-blue-300">
                    {{ form.processing ? 'Registrando. . ' : mode === 'create' ? 'Guardar' : 'Guardar cambios' }}
                </button>

                <button
                    class="px-2 py-1 text-xs font-medium text-center text-white bg-red-500 rounded-lg hover:bg-red-400 focus:ring-4 focus:outline-none focus:ring-red-300"
                    :hidden="mode === 'create'" @click="atras">
                    Atras
                </button>
            </div>
        </form>

        <div v-if="Object.keys(form.errors).length">
            <h3>Errores:</h3>
            <ul>
                <li v-for="(error, key) in form.errors" :key="key">{{ error }}</li>
            </ul>
        </div>

        <Toast ref="toast" />
    </div>
</template>

<script setup>
import { router, useForm, usePage } from '@inertiajs/vue3'
import Layout from '../../Layout/Layout.vue';
import Toast from '../../../Components/Toast.vue';
import { ref } from 'vue';


const { categorias, mode, transaccion } = usePage().props
const toast = ref(null);

console.log(mode, transaccion);

const form = useForm({
    tipo: transaccion?.tipo || 'false',
    monto: transaccion?.monto || '',
    tipo_pago: transaccion?.tipo_pago || 'false',
    descripcion: transaccion?.descripcion || '',
    categoria_id: transaccion?.categoria_id || '',
    persona_id: '',
    fecha: transaccion?.fecha || new Date().toISOString().split('T')[0],
})
defineOptions({
    layout: Layout
})


function submit() {
    console.log(categorias);
    console.log(form);

    if (mode === 'edit') {
        form.put(`/transaccion/update/${transaccion.id}`, {
            onError: () => {
                toast.value.show('Error al actualizar ❌', 'error')
            },
            onSuccess: (response) => {
                router.visit('/dashboard', { method: 'get' })
            },
        })
        return;
    } else {
        form.post('/transaccion/store', {
            onError: () => {
                toast.value.show('Error al guardar ❌', 'error')
            },
            onSuccess: (response) => {
                toast.value.show(response.props?.flash?.message || 'Guardado con éxito ✅', 'success')
                form.reset()

            },
        })
    }
}

function atras() {
    history.back();
}
</script>