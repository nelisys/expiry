<template>
    <div>
        <my-nav :user="user" :isLoggedIn="isLoggedIn"></my-nav>

        <div class="container-fluid py-2">
            <flash message=""></flash>
            <router-view @loggedIn="updateSession"></router-view>
        </div>

        <footer class="footer py-2 border-top">
            <div class="container-fluid">
                <div class="float-right">
                    <a href="#"># Back to Top</a>
                </div>
                <span class="text-muted">
                    &copy; 2020 Nelisys Co., Ltd. All rights reserved.
                </span>
            </div>
        </footer>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                user: '',
                isLoggedIn: localStorage.getItem('user') != null,
            }
        },

        mounted() {
            this.updateSession();
            events.$on('logout', this.logout);
        },

        methods: {
            updateSession() {
                this.isLoggedIn = localStorage.getItem('user');

                this.user = JSON.parse(localStorage.getItem('user'));
            },

            logout() {
                // TODO: submit logout to server
                localStorage.removeItem('user')
                localStorage.removeItem('token')

                this.isLoggedIn = false;
                window.axios.defaults.headers.common['Authorization'] = '';
                window.location = '/login';
            }
        }
    }
</script>
