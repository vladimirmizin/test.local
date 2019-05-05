<template>
    <div class="container">
        <h1>Hallo from home page</h1>
        <router-link :to="{ name: 'login' }">Login</router-link>
        <router-link :to="{ name: 'register' }">Registre</router-link>


    </div>
</template>
<script>
    export default {
    }
</script>