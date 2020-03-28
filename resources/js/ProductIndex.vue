<template>
    <div>
        <my-spinner :open="openSpinner"></my-spinner>
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
            <h3>
                Products
                <span class="badge badge-danger" v-if="status == 'expired'">
                    {{ status }}
                </span>
                <span class="badge badge-info" v-else-if="status == 'today'">
                    {{ status }}
                </span>
                <span class="badge badge-success" v-else-if="status == 'future'">
                    {{ status }}
                </span>
            </h3>
            <div class="btn-toolbar mb-2 mb-md-0">
                <a href="/products/create" class="btn btn-sm btn-success">+ create</a>
            </div>
        </div>

        <div class="list-group">
            <a v-for="product in products" :key="product.id"
                href="#"
                @mouseover="hoverProductId = product.id"
                class="list-group-item list-group-item-action">
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1">{{ product.name }}</h5>
                    <small>
                        <button v-show="hoverProductId == product.id"
                            type="button"
                            @click="deleteProduct(product.id)"
                            class="btn btn-sm btn-outline-danger">delete</button>
                    </small>
                </div>
                <p class="mb-1" :class="`text-` + diffForHumans(product.expiry_date).color">
                    {{ diffForHumans(product.expiry_date).text }}
                    ({{ product.expiry_date }})
                </p>
            </a>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                openSpinner: false,
                products:[],
                hoverProductId: null,
                status: '',
            };
        },

        mounted() {
            if (this.$route.query.status) {
                this.status = this.$route.query.status;
            }

            this.refresh();
        },

        methods: {
            diffForHumans(date) {
                let diffDays = moment(date).diff(moment().format('YYYY-MM-DD'), 'days');

                if (diffDays < 0) {
                    return {
                        color: 'danger',
                        text: 'expired',
                    };
                }

                if (diffDays == 0) {
                    return {
                        color: 'info',
                        text: 'today',
                    };
                }

                if (diffDays == 1) {
                    return {
                        color: 'success',
                        text: 'tomorrow',
                    };
                }

                return {
                    color: 'success',
                    text: diffDays + ' days',
                };
            },

            async refresh() {
                this.openSpinner = true;

                try {
                    await axios.get(`/api/products?status=${this.status}&sort=expiry_date&order=desc&per_page=100`)
                        .then(response => {
                            this.products = response.data.data;
                        });
                } catch (error) {
                    alert(error.response.statusText);
                    location.href = '/login';
                } finally {
                    this.openSpinner = false;
                }
            },

            async deleteProduct(product_id) {
                try {
                     var r = confirm(`Confirm delete`);

                    if (! r) {
                        return;
                    }

                    await axios.delete(`/api/products/${product_id}`)
                        .then(response => {
                            console.log('deleted');
                        });

                    await axios.get('/api/products?sort=expiry_date&order=desc')
                        .then(response => {
                            this.products = response.data.data;
                        });
                } catch (error) {
                    alert(error.response.statusText);
                    location.href = '/login';
                } finally {
                    this.openSpinner = false;
                }
            },
        },
    }
</script>
