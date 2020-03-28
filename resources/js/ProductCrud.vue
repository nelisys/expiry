<template>
    <div>
        <my-spinner :open="openSpinner"></my-spinner>
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-1 border-bottom">
            <strong>Product</strong>
            <div>
                <template v-if="action == 'show' && product">
                    <router-link :to="'/products/' + id + '/edit'" class="my-btn-edit" exact>edit</router-link>
                    <router-link :to="'/products/' + id + '/delete'" class="my-btn-delete" exact>delete</router-link>
                </template>
            </div>
        </div>

        <template v-if="action == 'create' || product">
            <div class="card card-default col-12">
                <div class="card-body">
                    <div v-if="form.errors.status && form.errors.status != '422'" class="alert alert-danger">
                        Error {{ form.errors.status }}: {{ form.errors.statusText }}
                    </div>

                    <form @submit.prevent="onSubmit" @keydown="form.errors.clear($event.target.name)">
                        <my-label-input-text
                            label="Name"
                            id="name"
                            :form="form"
                            :action="action"></my-label-input-text>

                        <my-label-input-date-picker
                            label="Expiry Date"
                            id="expiry_date"
                            :form="form"
                            :action="action"></my-label-input-date-picker>

                        <div class="form-group row mb-2">
                            <div class="offset-md-3 col-md-9">
                                <template v-if="action == 'create'">
                                    <button type="submit" class="btn btn-sm btn-primary" :disabled="submitted">{{ submitText }}</button>
                                    <button type="button" @click="backToIndex()" class="btn btn-sm btn-outline-secondary">cancel</button>
                                </template>
                                <template v-else-if="action == 'edit'">
                                    <button type="submit" class="btn btn-sm btn-outline-primary" :disabled="submitted">{{ submitText }}</button>
                                    <button type="button" @click="backToShow()" class="btn btn-sm btn-outline-secondary">cancel</button>
                                </template>
                                <template v-else-if="action == 'delete'">
                                    <button type="submit" class="btn btn-sm btn-danger" :disabled="submitted">{{ submitText }}</button>
                                    <button type="button" @click="backToShow()" class="btn btn-sm btn-outline-secondary">cancel</button>
                                </template>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </template>
        <template v-else-if="! openSpinner">
            not found
        </template>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                openSpinner: false,
                id: null,
                action: null,
                product: null,
                form: new Form({
                    name: '',
                    expiry_date: '',
                }),
                submitted: false,
            }
        },
        computed: {
            submitText: function () {
                if (this.submitted) {
                    return 'wait...';
                }

                return 'submit';
            },
        },

        mounted() {
            this.id = this.getId(this.$route.params);
            this.action = this.getAction(this.$route.params);

            if (this.id) {
                this.openSpinner = true;

                let url = `/api/products/${this.id}`;
                
                axios.get(url)
                    .then(response => {
                        this.product = response.data.data;

                        this.form.name = this.product.name;
                        this.openSpinner = false;
                    })
                    .catch(error => {
                        // console.log(error);
                        this.openSpinner = false;
                    })
            }
        },

        methods: {
            backToIndex() {
                location.href = '/products';
            },

            backToShow() {
                location.href = `/products/${this.id}`;
            },
            
            onSubmit() {
                this.submitted = true;

                let submitUrl = this.getSubmitUrl('/api/products', this.id, this.action);

                this.form[submitUrl.method](submitUrl.url)
                    .then(response => {
                        this.$router.replace('/products');
                        flash(submitUrl.flash_message);
                        this.submitted = false;
                    })
                    .catch(error => {
                        this.submitted = false;
                    });
            },

            getId(params) {
                if (params.id == 'create') {
                    return null;
                }

                return params.id;
            },

            getAction(params) {
                if (params.id == 'create') {
                    return 'create';
                }

                if (! params.action) {
                    return 'show';
                }

                return params.action;
            },

            getSubmitUrl(api_url, id, action) {
                let url = {};

                switch (action) {
                    case 'show':
                        url = {
                            url: null,
                            method: null,
                            flash_message: null,
                        }
                        break;

                    case 'create':
                        if (id) {
                            url = {
                                url: api_url + '/' + id,
                                method: 'patch',
                                flash_message: 'data created.',
                            }
                        } else {
                            url = {
                                url: api_url,
                                method: 'post',
                                flash_message: 'data created.',
                            }
                        }
                        break;

                    case 'edit':
                        if (id === null) {
                            url = {
                                url: api_url,
                                method: 'post',
                                flash_message: 'data created.',
                            }
                        } else {
                            url = {
                                url: api_url + '/' + id,
                                method: 'patch',
                                flash_message: 'data updated.',
                            }
                        }
                        break;

                    case 'delete':
                        url = {
                            url: api_url + '/' + id,
                            method: 'delete',
                            flash_message: 'data deleted.',
                        }
                        break;

                    case 'move':
                        url = {
                            url: api_url,
                            method: 'post',
                            flash_message: 'data moved.',
                        }
                        break;

                    default:
                        url = {
                            url: null,
                            method: null,
                            flash_message: 'invalid.',
                        }
                        break;
                }

                return url;
            },
        }
    }    
</script>            
