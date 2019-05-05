<template>
    <div>
        <transition name="fade">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">
                            <button type="button" @click="logout">Logout</button>
                            <div class="card-header">Комментарии</div>
                            <div class="card-body">
                                <form-component></form-component>
                                <br>
                                <hr>
                                <comments-component></comments-component>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </transition>
    </div>
</template>
<script>
    export default {
        created: function () {
            console.log(this.$store.getters.currentUser)
        },
        computed: {
            currentUser() {
                return this.$store.getters.currentUser.token
            }
        },
        mounted() {
            axios.get('/api/auth/dashboard')
                .then(response => {
                    this.data = response.data.data
                }).catch(error => {

            })
        },
        methods: {
            logout() {
                this.$store.dispatch("logout");
            }
        }

    }
</script>