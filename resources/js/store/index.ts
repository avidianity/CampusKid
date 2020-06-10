import Vue from "vue";
import Vuex, { StoreOptions } from "vuex";
import { RootState } from "../types/store";

Vue.use(Vuex);

export default new Vuex.Store({
    state: {},

    actions: {},

    mutations: {},

    getters: {},

    modules: {}
} as StoreOptions<RootState>);
