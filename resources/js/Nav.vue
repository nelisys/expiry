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
                <li class="nav-item">
                    <a href="/products" class="nav-link">Products</a>
                </li>
            </ul>
        </div>
    </nav>
</template>
