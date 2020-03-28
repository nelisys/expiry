<template>
    <div class="card-deck">
        <div class="card border-danger" @click="gotoProducts('expired')">
            <div class="card-body">
                <h5 class="card-title text-danger">Expired</h5>
                <p class="card-text text-danger">
                    {{ expired_products }} products
                </p>
            </div>
        </div>

        <div class="card border-info" @click="gotoProducts('today')">
            <div class="card-body">
                <h5 class="card-title text-info">Today</h5>
                <p class="card-text text-info">
                    {{ today_products }} products
                </p>
            </div>
        </div>

        <div class="card border-success" @click="gotoProducts('future')">
            <div class="card-body">
                <h5 class="card-title text-success">Future</h5>
                <p class="card-text text-success">
                    {{ future_products }} products
                </p>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                expired_products: 0,
                today_products: 0,
                future_products: 0,
            };
        },

        mounted() {
        },

        methods: {
            gotoProducts(status) {
                location.href = `/products?status=${status}`;
            },
        },
    }
</script>