<template>
    <div>
        <my-nav></my-nav>

        <div class="container-fluid py-2">
            <router-view></router-view>
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
