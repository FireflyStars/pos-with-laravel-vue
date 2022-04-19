import {
    createStore
} from "vuex";


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

import {cible as CIBLE_MODULE} from "./modules/cible";

import { itemlist as ITEM_LIST_MODULE } from "./modules/component_store/itemlist";

import { devislist as DEVIS_LIST_MODULE } from "./modules/devislist";

import { toggler as TOGGLER_MODULE } from "./modules/toggler"

import { PageBuilder as BUILDER_MODULE } from "./modules/PageBuilder"


export default createStore({
    modules: {
        LOADER_MODULE,
        TOASTER_MODULE,
        CIBLE_MODULE,
        ITEM_LIST_MODULE,
        DEVIS_LIST_MODULE,
        SIDEBAR_MODULE,
        SELECT_MODULE,
        FILTER_MODULE,
        TOGGLER_MODULE,
        BUILDER_MODULE,
    }
});
