import Vue from "vue";
import Vuex, { StoreOptions } from "vuex";
import { RootState } from "../types/store";
import {
    OccupationCollection,
    DepartmentCollection
} from "@classes/Collections";
import { User } from "./User";
import Axios, { AxiosError } from "axios";

Vue.use(Vuex);

const store: StoreOptions<RootState> = {
    actions: {
        fetchDepartments({ commit }) {
            return Axios.get("/departments")
                .then(response => response.data)
                .then((response: DepartmentCollection) => {
                    const departments = new DepartmentCollection(response);
                    commit("FILL_DEPARTMENTS", departments);
                    return departments;
                })
                .catch((error: AxiosError) => {
                    console.log(error.toJSON());
                });
        },
        fetchOccupations({ commit }) {
            return Axios.get("/occupations")
                .then(response => response.data)
                .then((response: OccupationCollection) => {
                    const occupations = new OccupationCollection(response);
                    commit("FILL_OCCUPATIONS", occupations);
                    return occupations;
                })
                .catch((error: AxiosError) => {
                    console.log(error.toJSON());
                });
        },
        setRoute({ commit }, name) {
            commit("SET_ROUTE", name);
        }
    },
    mutations: {
        FILL_DEPARTMENTS(state, departments: DepartmentCollection) {
            state.departments = departments;
        },
        FILL_OCCUPATIONS(state, occupations: OccupationCollection) {
            state.occupations = occupations;
        },
        SET_ROUTE(state, name: string) {
            state.route = name;
        }
    },
    getters: {
        departments({ departments }): DepartmentCollection {
            return departments;
        },
        occupations({ occupations }): OccupationCollection {
            return occupations;
        },
        route({ route }): string {
            return route;
        }
    },
    modules: {
        User
    }
};

export default new Vuex.Store<RootState>(store);
