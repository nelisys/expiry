<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">Login</div>

                    <div class="card-body">
                        <form @submit.prevent="submitLogin" @keydown="form.errors.clear($event.target.name)">
                            <div class="form-group row">
                                <label for="email" class="col-sm-4 col-form-label text-md-right">
                                    Email
                                </label>
                                <div class="col-md-6">
                                    <input type="text" id="email" name="email" class="form-control" v-model="form.email"
                                        ref="email"
                                        :class="{'is-invalid': form.errors.has('email')}">
                                    <div class="invalid-feedback" v-if="form.errors.has('email')"
                                        v-text="form.errors.get('email')"></div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">
                                    Password
                                </label>
                                <div class="col-md-6">
                                    <input type="password" id="password" name="password" class="form-control" v-model="form.password"
                                        ref="password"
                                        :class="{'is-invalid': form.errors.has('password')}">
                                    <div class="invalid-feedback" v-if="form.errors.has('password')"
                                        v-text="form.errors.get('password')"></div>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" id="submit" name="submit" class="btn btn-primary" :disabled="form.submitted">
                                        {{ form.submitted ? 'wait...' : 'login' }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                form: new Form({
                    email: '',
                    password: ''
                })
            }
        },
        mounted() {
            if (this.isLoggedIn()) {
                location.href = '/';
                return;
            }

            document.title = 'login';
            this.$refs.email.focus();
        },
        methods: {
            isLoggedIn() {
                return localStorage.getItem('user') != null;
            },

            submitLogin(e){
                e.preventDefault();

                this.form.post('/api/login')
                    .then(response => {
                        localStorage.setItem('token', response.token)
                        localStorage.setItem('user', JSON.stringify(response.user))

                        this.$emit('loggedIn')
                        window.axios.defaults.headers.common['Authorization'] = 'Bearer ' + response.token;
                        window.location = '/';
                    })
                    .catch(error => {

                    })
            }
        }
    }
</script> 
