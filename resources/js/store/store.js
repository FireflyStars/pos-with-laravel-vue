import { createStore } from "vuex";
import { loader as LOADER_MODULE}  from './modules/loader'
import {toaster as TOASTER_MODULE} from "./modules/toaster";
import {sidebar as SIDEBAR_MODULE} from "./modules/sidebar";
import {select as SELECT_MODULE} from "./modules/select";
export default createStore({
    modules:{
        LOADER_MODULE,
        TOASTER_MODULE,
        SIDEBAR_MODULE,
		SELECT_MODULE,
    }
});