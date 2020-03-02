require('./bootstrap');

window.Vue = require('vue');

// import dependecies tambahan
import VueRouter from 'vue-router';
import VueAxios from 'vue-axios';
import Axios from 'axios';
import VueInputMask from 'vue-inputmask';
import Vuetify from 'Vuetify';
import "vuetify/dist/vuetify.min.css";
import tinymce from 'tinymce';






Vue.use(VueRouter, VueAxios, Axios);
Vue.use(VueInputMask.default);
Vue.use(Vuetify);
Vue.use(tinymce);



// import file yang dibuat tadi
import App from './components/App.vue';

import Member from './components/Member.vue';
import Club from './components/Club.vue';
import Event from './components/Event.vue';
import EventRace from './components/EventRace.vue';
import EventParticipant from './components/EventParticipant.vue';
import Rule from './components/Rule.vue';
import Participant from './components/Participant.vue';
import PureRace from './components/PureRace.vue';
import EventMatch from './components/EventMatch.vue';
import LiveMatch from './components/LiveMatch.vue';
import StartingList from './components/StartingList.vue';
import Payment from './components/Payment.vue';

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
        component: PureRace
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
    },
    {
        name: 'manage EventParticipant',
        path: '/admin/event/participants/:id',
        component: EventParticipant,
    },
    {
        name: 'manage EventMatch',
        path: '/admin/event/matches/:id',
        component: EventMatch,
    },
    {
        name: 'manage LiveMatch',
        path: '/admin/home/:id?',
        component: LiveMatch,
    },
    {
        name: 'manage StartingList',
        path: '/admin/startinglist',
        component: StartingList,
    },
    {
        name: 'manage Payment',
        path: '/admin/payments',
        component: Payment,
    },
    {
        name: 'manage LiveMatch',
        path: '/match',
        component: LiveMatch,
    },


]

const router = new VueRouter({ mode: 'history', routes: routes });
new Vue({
    el: '#app',
    router,
    vuetify: new Vuetify(),
    components: { App },
    template: '<App/>'
})