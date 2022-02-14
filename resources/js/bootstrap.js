window._ = require('lodash');
import router from './router/router'
window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

window.axios.interceptors.response.use(
    (response) => response,
    (error) => {
        if (error.response.status !== 401 && error.response.status !== 419) return Promise.reject(error)
        sessionStorage.clear();
        //store.dispatch(`${TOASTER_MODULE}${TOASTER_MESSAGE}`,{message:'Session expired. Please login again.',ttl:8,type:'danger'});
        router.push({ name: 'Login' })
    }
)