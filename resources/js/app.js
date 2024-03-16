const routes = [
    { path: '/', component: require('./components/ExampleComponent.vue').default },
    // Agrega más rutas según tus necesidades
];

const router = new VueRouter({
    routes,
    mode: 'history', // Opción para URLs más limpias
});

const app = new Vue({
    el: '#app',
    router,
});
