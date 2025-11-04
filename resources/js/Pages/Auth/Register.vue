<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <form @submit.prevent="form.post('/register')">

            <input type="text" v-model="form.nombre">
            <div v-if="form.errors.nombre">{{ form.errors.nombre }}</div>
            <input type="text" v-model="form.username">
            <div v-if="form.errors.username">{{ form.errors.username }}</div>
            <!-- password -->
            <input type="password" v-model="form.password">
            <div v-if="form.errors.password">{{ form.errors.password }}</div>
            <!-- remember me -->
            <input type="checkbox" v-model="form.remember"> Remember Me
            <!-- submit -->
            <button type="submit" :disabled="form.processing">Login</button>


        </form>

        <a href="/login">ya tengo cuenta</a>

    </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'

const form = useForm({
    nombre: '',
    username: '',
    password: '',
})


</script>