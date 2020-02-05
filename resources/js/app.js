require('./bootstrap');

window.Vue = require('vue');

// import dependecies tambahan
import VueRouter from 'vue-router';
import VueAxios from 'vue-axios';
import Axios from 'axios';
import VueInputMask from 'vue-inputmask';
import Vuetify from 'Vuetify';
import "vuetify/dist/vuetify.min.css";

Vue.use(VueRouter, VueAxios, Axios);
Vue.use(VueInputMask.default);
Vue.use(Vuetify);


// import file yang dibuat tadi
import App from './components/App.vue';

import Read from './components/Read.vue';
import ReadClub from './components/ReadClub.vue';
// import Update from './components/Update.vue';

// membuat router
const routes = [
    {
        name: 'read member',
        path: '/admin/members',
        component: Read
    },
    {
        name: 'read clubs',
        path: '/admin/clubs',
        component: ReadClub
    },

    // {
    //     name: 'update',
    //     path: '/detail/:id',
    //     component: Update
    // }
]

const router = new VueRouter({ mode: 'history', routes: routes });
new Vue({
    el: '#app',
    router,
    vuetify: new Vuetify(),
    components: { App },
    template: '<App/>'
})