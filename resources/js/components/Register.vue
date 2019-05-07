<template>
    <div class="content position-ref center">
        <div class="login row justify-content-center">
            <div class="col-md-6">
                <div class="card">
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
                                       v-model="form.name" placeholder="Name">
                                <span v-if="errors.has('name')" class="invalid-feedback" role="alert">{{ errors.first('name') }}</span>
                            </div>
                            <div class="form-group row">
                                <!--                            <label for="email">Email</label>-->
                                <input type="email" name="email" v-validate="'required|email'" class="form-control"
                                       v-model="form.email" placeholder="Email address">
                                <span v-if="errors.has('email')" class="invalid-feedback" role="alert">{{ errors.first('email') }}</span>
                            </div>
                            <div class="form-group row">
                                <!--                            <label for="password">Password</label>-->
                                <input type="password" name="password" class="form-control"
                                       v-validate="'required|min:6'"
                                       v-model="form.password" placeholder="password">
                                <span v-if="errors.has('password')" class="invalid-feedback" role="alert">{{ errors.first('password') }}</span>
                            </div>
                            <div class="form-group row">
                                <b-form-select v-model="form.country"
                                               @input="getRegions(form.country)">
                                    <option  v-for="country in countries" :value="country.id">{{country.country}}
                                    </option>
                                </b-form-select>
                            </div>
                            <div class="form-group row">
                                <b-form-select v-if="regions.length > 0" v-model="form.region"  @input="getCities(form.region)">
                                    <option v-for="region in regions" :value="region.id">{{region.region}}
                                    </option>
                                </b-form-select>
                            </div>
                            <div class="form-group row">
                                <b-form-select v-if="cities.length > 0" v-model="form.city">
                                    <option v-for="city in cities" :value="city.id">{{city.city}}</option>
                                </b-form-select>
                            </div>
                    <div class="form-group row">
                        <input type="submit" value="Register" class="btn btn-outline-primary ml-auto">
                    </div>
                    </form>
                </div>
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
                city: {},
                countries: [],
                cities: [],
                regions: [],
                country: {},
                region: {},
                error: null,
                country_id: null,
                form: {
                    city: null,
                    name: '',
                    email: '',
                    password: '',
                }
            }
        },
        created() {
            this.getCountries()
        },
        methods: {
            register() {
                console.log(this.form);

                registerUser(this.$data.form)
                    .then(res => {
                        console.log(res);
                        this.$store.commit("registerSuccess", res);
                        this.$router.push({path: '/login'});
                    })
                    .catch(error => {
                        this.$store.commit("registerFailed", {error});
                    })
            }, getRegions(id) {
                let vm = this
                let uri = '/api/auth/get-regions';
                console.log(id)
                axios.get(uri + '?country_id=' + id).then(response => {
                    vm.regions = response.data.regions
                });
                console.log(vm.regions)
            }, getCities(id) {
                let vm = this
                let uri = '/api/auth/get-cities';
                console.log(id)
                axios.get(uri + '?region_id=' + id).then(response => {
                    vm.cities = response.data.cities
                });
            }, getCountries() {
                let vm = this
                let uri = '/api/auth/get-countries/';
                axios.get(uri).then(response => {
                    vm.countries = response.data.countries
                });
                console.log(vm.countries);
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