<template>
    <div>
        <my-spinner :open="openSpinner"></my-spinner>
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
            <h3>
                Dashboard
            </h3>
        </div>

        <div class="card-deck">
            <div class="card border-danger" @click="gotoProducts('expired')">
                <div class="card-body">
                    <h5 class="card-title text-danger">Expired</h5>
                    <p class="card-text text-danger">
                        {{ summary.expired }} products
                    </p>
                </div>
            </div>
            <div class="card border-info" @click="gotoProducts('today')">
                <div class="card-body">
                    <h5 class="card-title text-info">Today</h5>
                    <p class="card-text text-info">
                        {{ summary.today }} products
                    </p>
                </div>
            </div>
            <div class="card border-success" @click="gotoProducts('future')">
                <div class="card-body">
                    <h5 class="card-title text-success">Future</h5>
                    <p class="card-text text-success">
                        {{ summary.future }} products
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                openSpinner: false,
                summary: {
                    expired: 0,
                    today: 0,
                    future: 0,
                },
            };
        },

        mounted() {
            axios.get('/api/products/summary')
                .then(response => {
                    this.summary = response.data;

                    console.log(this.summary);
                });
        },

        methods: {
            gotoProducts(status) {
                location.href = `/products?status=${status}`;
            },
        },
    }
</script>