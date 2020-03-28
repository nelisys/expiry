<template>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark sticky-top">
        <router-link class="navbar-brand" to="/" exact
            style="border: 1px solid #fff; border-radius: 4px; padding: 2px; padding-left: 4px; padding-right: 4px;">
            Expiry
        </router-link>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbars">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbars">
            <ul class="navbar-nav mr-auto">
                <template v-if="isLoggedIn">
                    <li class="nav-item">
                        <a href="/products" class="nav-link">Products</a>
                    </li>
                </template>
            </ul>

            <ul class="navbar-nav">
                <router-link class="nav-item" tag="li" to="/login" exact v-if="! isLoggedIn">
                    <a class="nav-link">Login</a>
                </router-link>

                <li class="nav-item dropdown" v-if="isLoggedIn">
                    <a class="nav-link dropdown-toggle user-profile-link" href="#" id="dropdown-user" data-toggle="dropdown">
                        {{ user.email }}
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item user-logout-link" href="" @click="logout">
                            Logout
                        </a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</template>

<script>
    export default {
        props: ['user', 'isLoggedIn'],

        date() {
            return {
                activeName: '',
            };
        },

        mounted() {
            if (! this.isLoggedIn) {
                return;
            }

            this.updateNav();
        },

        watch: {
            '$route': 'updateNav'
        },

        methods: {
            logout() {
                events.$emit('logout');
            },

            isActive(name) {
                return name == this.activeName;
            },

            updateNav()  {
                let path = this.$route.path;
            },
        }
    }
</script>
