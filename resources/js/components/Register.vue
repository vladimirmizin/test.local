<template>
    <div class="login row justify-content-center">
        <div class="col-md-6">
            <div class=”card”>
                <div class="card-header">
                    <h3>Register</h3>
                </div>
                <div class="card-body">
                    <form @submit.prevent="register">
                        <div class="form-group row" v-if="regError">
                            <p class=”error”>
                                {{regError}}
                            </p>
                        </div>
                        <div class="form-group row">
                            <!--                            <label for="name">Name</label>-->
                            <input type="text" name="name" class="form-control" v-validate="'required'"
                                   v-model="formRegister.name" placeholder="Name">
                            <span v-if="errors.has('name')" class="invalid-feedback" role="alert">{{ errors.first('name') }}</span>
                        </div>
                        <div class="form-group row">
                            <!--                            <label for="email">Email</label>-->
                            <input type="email" name="email" v-validate="'required|email'" class="form-control"
                                   v-model="formRegister.email" placeholder="Email address">
                            <span v-if="errors.has('email')" class="invalid-feedback" role="alert">{{ errors.first('email') }}</span>
                        </div>
                        <div class="form-group row">
                            <!--                            <label for="password">Password</label>-->
                            <input type="password" name="password" class="form-control" v-validate="'required|min:6'"
                                   v-model="formRegister.password" placeholder="password">
                            <span v-if="errors.has('password')" class="invalid-feedback" role="alert">{{ errors.first('password') }}</span>
                        </div>
                        <div class="form-group row">
                            <div class="form-group row">
                                <b-dropdown text="Select Country">
                                    <b-dropdown-item v-for="country as countries"
                                                     v-on:click="getRegions(country.id)">{{country.country}}
                                    </b-dropdown-item>
                                </b-dropdown>
                            </div>
                            <div class="form-group row">
                                <b-dropdown text="Select Region">
                                        <b-dropdown-item  v-if="regions" v-for="region as regions"
                                                         v-on:click="getCities(country.id)">{{region.region}}
                                        </b-dropdown-item>
                                </b-dropdown>
                            </div>
                            <div class="form-group row">
                                <b-dropdown text="Select City">
                                    <b-dropdown-item v-if="cities" v-for="city as cities">{{city.city}}
                                    </b-dropdown-item>
                                </b-dropdown>
                            </div>
                        </div>
                        <div class="form-group row">
                            <input type="submit" value="Register" class="btn btn-outline-primary ml-auto">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import {registerUser} from '../partials/auth';

    export default {
        data() {
            return {
                formRegister: {
                    name: '',
                    email: '',
                    password: '',
                    countries: [],
                    cities: [],
                    regions: [],
                    country: {},
                    region: {},
                    city: {},
                },
                error: null
            }
        },
        methods: {
            register() {
                registerUser(this.$data.formRegister)
                    .then(res => {
                        console.log(res);
                        this.$store.commit("registerSuccess", res);
                        this.$router.push({path: '/login'});
                    })
                    .catch(error => {
                        this.$store.commit("registerFailed", {error});
                    })
            }, getRegions() {
                let vm = this
                let uri = '/api/auth/get-regions/';
                axios.get(uri).then(response => {
                    vm.regions = response.data
                });
            }, getCities() {
                let vm = this
                let uri = '/api/auth/get-cities/';
                axios.get(uri).then(response => {
                    vm.cities = response.data
                });
            },

        },
        computed: {
            regError() {
                return this.$store.getters.regError
            }
        }
    }
</script>
<style scoped>
    .error {
        text-align: center;
        color: red;
    }
</style>