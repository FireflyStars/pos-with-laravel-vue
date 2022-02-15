require('./bootstrap')

import { createApp } from 'vue'
import VueClickAway from 'vue3-click-away'
import App from './components/App.vue'

import { GlobalComponents } from './services/Index'

import router from './router/router'
import store from './store/store'


const app = createApp(App)
app.use(router)
app.use(store)
app.use(VueClickAway)
GlobalComponents(app)
app.mount('#app')
