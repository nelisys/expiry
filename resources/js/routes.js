const routes = [
    {
        name: 'not_found',
        path: '*',
        component: require('./NotFound.vue').default,
    },
    {
        name: 'home',
        path: '/',
        component: require('./Home.vue').default,
    },
    {
        name: 'products',
        path: '/products',
        component: require('./ProductIndex.vue').default,
    },
];

export default routes;
