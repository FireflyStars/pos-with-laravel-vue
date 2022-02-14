import {
    createStore
} from "vuex";


// import { LOADER_MODULE, TOASTER_MODULE, SIDEBAR_MODULE, SELECT_MODULE, FILTER_MODULE, TOGGLER_MODULE } from "./types/types";


import {
    loader as LOADER_MODULE
} from './modules/loader'
import {
    toaster as TOASTER_MODULE
} from "./modules/toaster";
import {
    sidebar as SIDEBAR_MODULE
} from "./modules/sidebar";
import {
    select as SELECT_MODULE
} from "./modules/select";
import {
    filter as FILTER_MODULE
} from "./modules/filter";

import { toggler as TOGGLER_MODULE } from "./modules/toggler"


export default createStore({
    modules: {
        LOADER_MODULE,
        TOASTER_MODULE,
        SIDEBAR_MODULE,
        SELECT_MODULE,
        FILTER_MODULE,
        TOGGLER_MODULE
    }
});
