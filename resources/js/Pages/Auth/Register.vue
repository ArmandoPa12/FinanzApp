<template>
    <div  class="flex flex-col items-center justify-center w-screen h-screen bg-gray-200 text-gray-700">
        <form class="flex flex-col bg-white rounded shadow-lg p-12 mt-12" @submit.prevent="form.post('/register')">

            <input placeholder="nombre" class="flex items-center h-12 px-4 w-64 bg-gray-200 mt-2 rounded focus:outline-none focus:ring-2" type="text" v-model="form.nombre">
            <div v-if="form.errors.nombre">{{ form.errors.nombre }}</div>

            <input placeholder="apellido" class="flex items-center h-12 px-4 w-64 bg-gray-200 mt-2 rounded focus:outline-none focus:ring-2" type="text" v-model="form.apellido">
            <div v-if="form.errors.apellido">{{ form.errors.apellido }}</div>

            <input placeholder="carnet" class="flex items-center h-12 px-4 w-64 bg-gray-200 mt-2 rounded focus:outline-none focus:ring-2" type="text" v-model="form.carnet">
            <div v-if="form.errors.carnet">{{ form.errors.carnet }}</div>

            <input placeholder="usuario" class="flex items-center h-12 px-4 w-64 bg-gray-200 mt-2 rounded focus:outline-none focus:ring-2" type="text" v-model="form.username">
            <div v-if="form.errors.username">{{ form.errors.username }}</div>
            <!-- password -->
            <input placeholder="contraseña" class="flex items-center h-12 px-4 w-64 bg-gray-200 mt-2 rounded focus:outline-none focus:ring-2" type="password" v-model="form.password">
            <div v-if="form.errors.password">{{ form.errors.password }}</div>
            <!-- remember me -->
            <input class="flex items-center h-12 px-4 w-64 bg-gray-200 mt-2 rounded focus:outline-none focus:ring-2" type="checkbox" v-model="form.remember"> Remember Me
            <!-- submit -->
            <button type="submit" :disabled="form.processing">Register</button>


        </form>

        <a href="/login">ya tengo cuenta</a>

    </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'

const form = useForm({
    nombre: '',
    apellido: '',
    carnet:'',
    username: '',
    password: '',
})


</script>