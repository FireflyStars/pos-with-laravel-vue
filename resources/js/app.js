import {TOASTER_MESSAGE, TOASTER_MODULE} from "./store/types/types";

require('./bootstrap');

import axios from 'axios';
import { createApp } from 'vue';
import App from './components/App';
import VueClickAway from 'vue3-click-away';
import { GlobalComponents } from './services/Index';

import router from './router/router';
import store from './store/store';

axios.interceptors.response.use(
    (response) => response,
    (error) => {
        if (error.response.status == 509)//509 is unassigned so we use for custom error code reporting
        store.dispatch(`${TOASTER_MODULE}${TOASTER_MESSAGE}`,{message:error.response.data,ttl:8,type:'danger'});

        if (error.response.status !== 401&&error.response.status !== 419) return Promise.reject(error)
        sessionStorage.clear();
        store.dispatch(`${TOASTER_MODULE}${TOASTER_MESSAGE}`,{message:'Session expired. Please login again.',ttl:8,type:'danger'});
        //window.location='/';
        router.push({
            name:'Login',
        })
    }
)
const app=createApp(App)
    .use(router)
    .use(store)
    .use(VueClickAway);

    GlobalComponents(app);

    app.mount('#app');