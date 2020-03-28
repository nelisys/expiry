const routes = [
    {
        name: 'not_found',
        path: '*',
        component: require('./NotFound.vue').default,
    },
    {
        name: 'login',
        path: '/login',
        component: require('./Login.vue').default,
    },
    {
        name: 'home',
        path: '/',
        component: require('./Home.vue').default,
        meta: {
            requiresAuth: true,
        }
    },
    {
        name: 'products',
        path: '/products',
        component: require('./ProductIndex.vue').default,
        meta: {
            requiresAuth: true,
        }
    },
];

export default routes;
