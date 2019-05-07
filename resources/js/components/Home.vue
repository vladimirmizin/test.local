<template>
    <body>
    <div class="flex-center position-ref full-height">
        <div class="top-right links">
            <router-link :to="{ name: 'login' }">Login</router-link>
            <router-link :to="{ name: 'register' }">Register</router-link>
        </div>
        <div class="content">
            <div class="title m-b-md">
                Home Page
            </div>

        </div>
    </div>
    </body>
</template>
<script>
    export default {
    }
</script>