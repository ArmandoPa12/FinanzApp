<template>
    <div>
        <div class="flex gap-x-2 p-3">
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

        <!-- <div class="bg-slate-300 border border-salte-200 rounded-lg shadow-sm">
            <p class="px-3">Incluir</p>
            <div class="flex flex-wrap items-center">
                <div v-for="cat in categorias" :key="cat.id" class="flex items-center p-2">
                    <input type="checkbox" :id="'checkbox-' + cat.id" v-model="filters.incluir" :value="cat.id"
                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 focus:ring-2" />
                    <label :for="'checkbox-' + cat.id" class="ms-2 text-sm font-medium text-gray-900">
                        {{ cat.nombre }}
                    </label>
                </div>
            </div>
        </div>

        <button @click="applyFilters">aply</button> -->



        <div class="flex gap-x-2">
            <div class="block max-w-sm p-6 bg-sky-200 border border-gray-200 rounded-lg shadow-sm">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 ">QR</h5>
                <p class="font-normal text-gray-700"><strong>{{ totales.qr }}</strong></p>
            </div>

            <div class="block max-w-sm p-6 bg-green-400 border border-gray-200 rounded-lg shadow-sm">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 ">Efectivo</h5>
                <p class="font-normal text-gray-700"><strong>{{ totales.efectivo }}</strong></p>
            </div>

            <div class="block max-w-sm p-6 bg-amber-400 border border-gray-200 rounded-lg shadow-sm">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 ">Total</h5>
                <p class="font-normal text-gray-700"><strong>{{ totales.total }}</strong></p>
            </div>

            <div class="w-full max-w-sm bg-gray-300 border border-gray-200 rounded-lg shadow-sm">
                <div class="flex flex-col items-center pb-10">
                    <h5 class="mb-1 text-xl font-medium text-gray-900">Totales</h5>
                    <div class="flex mt-4 md:mt-6">

                        <div
                            class="py-2 px-4 ms-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 ">
                            Ingresos: {{ totales.entrada }}</div>
                        <div
                            class="py-2 px-4 ms-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 ">
                            Gastos: {{ totales.gasto }}</div>
                    </div>
                </div>
            </div>
        </div>






    </div>
</template>
<script setup>
import { computed, onMounted, ref, watch } from 'vue';
import Layout from '../../Layout/Layout.vue';
import { usePage } from '@inertiajs/vue3';

const page = usePage()
const transacciones = computed(() => page.props.transacciones)
const categorias = ref(page.props.categorias || [])
// const transacciones = ref(page.props.transacciones || [])

console.log(categorias.value);
console.log(transacciones.value);






//filtros
// const filters = ref({
//     from: null,
//     to: null,
//     incluir: [categorias.value.id]
// })

// filters.value.incluir = categorias.value.map(cat => cat.id)

// const transFiltradas = transacciones.value.filter(t => 
//     filters.value.incluir.map(Number).includes(Number(t.categoria_id))
// )


// function applyFilters() {
//     console.log(filters.value);
//     console.log(transFiltradas);
// }

// watch(filters, applyFilters, { deep: true })


const totales = computed(() => {
    const resultado = {
        efectivo: 0,
        qr: 0,
        total: 0,
        entrada: 0,
        gasto: 0
    }

    for (const t of transacciones.value  ) {

        const monto = parseFloat(t.monto)
        const signo = t.tipo === false ? 1 : -1

        if (!t.tipo_pago) {
            resultado.efectivo += signo * monto
            // console.log(t.monto, t.tipo ? 'gasto' : 'entrada', t.tipo_pago, signo);

        } else if (t.tipo_pago) {
            resultado.qr += signo * monto
        }

        if (t.tipo) {
            resultado.gasto += monto;
        } else {
            resultado.entrada += monto;
        }
    }

    resultado.total = resultado.efectivo + resultado.qr
    return resultado
})

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