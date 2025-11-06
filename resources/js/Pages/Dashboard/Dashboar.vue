<template>
  <div>
    <!-- <div>Bienvenido, {{ usuario.nombre }} ({{ usuario.username }})</div> -->

    <Modal :show="showModal" @close="closeModal">
      <Delete @cancel="closeModal" @done="handleDelete" :transaccion="transaccionSeleccionada" />
    </Modal>

    <div class="text-left w-full">
      <h3 class="text-lg font-semibold ml-3 text-slate-800">Transacciones</h3>
      <p class="text-slate-500 mb-5 ml-3">usuario: {{ usuario.nombre }}</p>
    </div>



    <div class="space-y-4">
      <div class="flex gap-4 items-end">
        <div>
          <label class="block text-sm">Desde</label>
          <input type="date" v-model="filters.from" class="border p-1 rounded">
        </div>

        <div>
          <label class="block text-sm">Hasta</label>
          <input type="date" v-model="filters.to" class="border p-1 rounded">
        </div>

        <div>
          <label class="block text-sm">Categoría</label>
          <select v-model="filters.categoria_id" class="border p-1 rounded">
            <option value="0">Todas</option>
            <option v-for="cat in categorias" :key="cat.id" :value="cat.id">
              {{ cat.nombre }}
            </option>
          </select>
        </div>

        <div>
          <label class="block text-sm">Tipo</label>
          <select v-model="filters.tipo" class="border p-1 rounded">
            <option value="0">Todos</option>
            <option value="false">Entrada</option>
            <option value="true">Gasto</option>
          </select>
        </div>

        <div>
          <label class="block text-sm">Tipo pago</label>
          <select v-model="filters.tipo_pago" class="border p-1 rounded">
            <option value="0">Todos</option>
            <option value="true">QR</option>
            <option value="false">efectivo</option>
          </select>
        </div>

        <div>
          <label class="block text-sm">Dias</label>
          <select v-model="filters.days" class="border p-1 rounded">
            <option value="0">Todos</option>
            <option value="1">1 dia</option>
            <option value="3">3 dias</option>
            <option value="7">1 semana</option>
          </select>
        </div>

        <div>
          <label class="block text-sm">Ordenar por monto</label>
          <select v-model="filters.sort" class="border p-1 rounded">
            <option value="0">Ninguno</option>
            <option value="asc">Menor a mayor</option>
            <option value="desc">Mayor a menor</option>
          </select>
        </div>

        <button @click="cleanFilters" class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">
          limpiar filtros
        </button>
      </div>
    </div>


    <div
      class="relative flex flex-col w-full h-full overflow-scroll text-gray-700 bg-white shadow-md rounded-lg bg-clip-border">
      <table id="productTable" class="w-full text-left table-auto min-w-max">
        <thead>
          <tr>
            <th class="p-1 border-b border-slate-300 bg-slate-50">
              <p class="block text-sm font-normal leading-none text-slate-500">
                Fecha
              </p>
            </th>
            <th class="p-1 border-b border-slate-300 bg-slate-50">
              <p class="block text-sm font-normal leading-none text-slate-500">
                Categoría
              </p>
            </th>
            <th class="p-1 border-b border-slate-300 bg-slate-50">
              <p class="block text-sm font-normal leading-none text-slate-500">
                Descripcion
              </p>
            </th>
            <th class="p-1 border-b border-slate-300 bg-slate-50">
              <p class="block text-sm font-normal leading-none text-slate-500">
                Monto
              </p>
            </th>
            <th class="p-1 border-b border-slate-300 bg-slate-50">
              <p class="block text-sm font-normal leading-none text-slate-500">
                Metodo pago
              </p>
            </th>
            <!-- <th class="p-1 border-b border-slate-300 bg-slate-50">
              <p class="block text-sm font-normal leading-none text-slate-500">
                QR
              </p>
            </th> -->
            <th class="p-1 border-b border-slate-300 bg-slate-50">
              <p class="block text-sm font-normal leading-none text-slate-500">
                Persona
              </p>
            </th>
            <th class="p-1 border-b border-slate-300 bg-slate-50">
              <p class="block text-sm font-normal leading-none text-slate-500">
                Acciones
              </p>
            </th>

          </tr>
        </thead>
        <tbody>
          <tr v-for="tran in transacciones" class="hover:bg-slate-50" :key="tran.id">
            <td class="p-1 border-b border-slate-200">
              <p class="block text-sm text-slate-800">
                {{ tran.fecha }}
              </p>
            </td>
            <td class="p-1 border-b border-slate-200">
              <p class="block text-sm text-slate-800">
                {{ tran.categoria?.nombre || 'sin categoria' }}
              </p>
            </td>
            <td class="p-1 border-b border-slate-200 max-w-[200px]">
              <p class="block text-sm break-words whitespace-normal"
                :class="tran.descripcion ? 'text-slate-800' : 'text-slate-400 italic'">
                {{ tran.descripcion || 'Sin descripción' }}
              </p>
            </td>
            <td class="p-1 border-b border-slate-200" :class="tran.tipo == '0' ? 'bg-green-200' : 'bg-red-200'">
              <p class="block text-sm text-slate-800">
                {{ (tran.tipo == '0' ? tran.monto  : '-' + tran.monto) + ' Bs' }}     
              </p>
            </td>
            <td class="p-1 border-b border-slate-200">
              <p class="block text-sm text-slate-800">
                {{ tran.tipo_pago == '0' ? 'Efectivo' : 'Qr'  }} 
              </p>
            </td>
            <td class="p-1 border-b border-slate-200">
              <p class="block text-sm text-slate-800">
                {{ tran.persona.nombre || '' }}
              </p>
            </td>
            <td class="p-1  border-slate-200">
              <div class="flex gap-x-2">
                <Link :href="`/transaccion/edit/${tran.id}`" as="Button" type="button"
                  class="px-2 py-1 text-xs font-medium text-center text-white bg-blue-500 rounded-lg hover:bg-blue-400 focus:ring-4 focus:outline-none focus:ring-blue-300">
                editar</Link>
                <button @click="openModalDelete(tran)" type="button"
                  class="px-2 py-1 text-xs font-medium text-center text-white bg-red-500 rounded-lg hover:bg-red-400 focus:ring-4 focus:outline-none focus:ring-red-300">eliminar</button>
              </div>
            </td>


          </tr>

        </tbody>
        <!-- <tfoot>
          <tr>
            <td colspan="3" class="p-4 text-left font-bold text-slate-800 border-t border-slate-300">
            </td>
            <td colspan="1" class="p-4 font-semibold text-slate-800 border-t border-slate-300">
              {{ totalEntradas.toFixed(2) }} Bs
            </td>
            <td colspan="1" class="p-4 font-semibold text-slate-800 border-t border-slate-300">
              {{ totalGastos.toFixed(2) }} Bs
            </td>
            <td colspan="1" class="p-4 font-semibold text-slate-800 border-t border-slate-300">
              Total:
            </td>
            <td colspan="1" class="p-4 font-semibold text-slate-800 border-t border-slate-300">
              {{ total.toFixed(2) }} Bs
            </td>
          </tr>
        </tfoot> -->
      </table>
    </div>
  </div>

</template>

<script setup>
import { Link, router, usePage } from '@inertiajs/vue3'
import Layout from '../Layout/Layout.vue'
import Modal from '../../../js/Components/Modal.vue';
import Delete from './Transaccion/Delete.vue';
import { computed, ref, watch } from 'vue';

const page = usePage()
const usuario = computed(() => page.props.usuario)
const transacciones = computed(() => page.props.transacciones)
const categorias = computed(() => page.props.categorias)

const showModal = ref(false)
const closeModal = () => (showModal.value = false)
const transaccionSeleccionada = ref(null)
const openModalDelete = (transaccion) => {
  showModal.value = true
  transaccionSeleccionada.value = transaccion
}
function handleDelete() {
  showModal.value = false
  router.visit('/dashboard', { method: 'get' })
}


// filtros
const filters = ref({
  from: null,
  to: null,
  days: 1,
  categoria_id: 0,
  tipo: 0,
  tipo_pago: 0,
  sort: 0,
})

function applyFilters() {
  router.get('/dashboard', filters.value, {
    preserveState: true,
    preserveScroll: false,
    replace: true,
  })
}

function cleanFilters() {
  Object.assign(filters.value, {
    from: null,
    to: null,
    days: 1,
    categoria_id: 0,
    tipo: 0,
    tipo_pago: 0,
    sort: 0,
  })
  applyFilters();
}

watch(filters, applyFilters, { deep: true })




defineOptions({
  layout: Layout
})

</script>