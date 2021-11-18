import { createStore } from "vuex";
import { loader as LOADER_MODULE}  from './modules/loader'
import {toaster as TOASTER_MODULE} from "./modules/toaster";
import {sidebar as SIDEBAR_MODULE} from "./modules/sidebar";
export default createStore({
    modules:{
        LOADER_MODULE,
        TOASTER_MODULE,
        SIDEBAR_MODULE,
    }
});