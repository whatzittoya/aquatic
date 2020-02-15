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

import Member from './components/Member.vue';
import Club from './components/Club.vue';
import Event from './components/Event.vue';
import EventRace from './components/EventRace.vue';
import Rule from './components/Rule.vue';
import Race from './components/Race.vue';
import Participant from './components/Participant.vue';

// membuat router
const routes = [
    {
        name: 'manage member',
        path: '/admin/members',
        component: Member
    },
    {
        name: 'manage clubs',
        path: '/admin/clubs',
        component: Club
    },

    {
        name: 'manage events',
        path: '/admin/events',
        component: Event
    },
    {
        name: 'manage rules',
        path: '/admin/rules',
        component: Rule
    },
    {
        name: 'manage races',
        path: '/admin/races',
        component: Race
    },
    {
        name: 'manage participants',
        path: '/admin/participants',
        component: Participant
    },
    {
        name: 'manage EventRace',
        path: '/admin/event/races/:id',
        component: EventRace,
    }
]

const router = new VueRouter({ mode: 'history', routes: routes });
new Vue({
    el: '#app',
    router,
    vuetify: new Vuetify(),
    components: { App },
    template: '<App/>'
})