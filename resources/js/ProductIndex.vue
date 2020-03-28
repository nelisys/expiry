<template>
    <div>
        <h1>products...</h1>
        <ul>
            <li v-for="product in products" :key="product.id">
                {{ product.name }}
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                products:[],
            };
        },

        mounted() {
            axios.get('/api/products')
                .then(response => {
                    this.products = response.data.data;
                })
                .catch(error => {
                    alert(error.response.statusText);
                    location.href = '/login';
                });
        },
    }
</script>