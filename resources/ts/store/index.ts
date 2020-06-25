import Vue from "vue";
import Vuex, { StoreOptions } from "vuex";
import { RootState } from "../types/store";
import * as Collections from "@classes/Collections";
import { User } from "./User";
import Axios, { AxiosError } from "axios";

Vue.use(Vuex);

const collection = {
    current_page: 0,
    first_page_url: "",
    from: 0,
    last_page: 0,
    last_page_url: "",
    next_page_url: "",
    path: "",
    per_page: 0,
    prev_page_url: "",
    to: 0,
    total: 0,
    data: [],
    fillModels: () => {},
    hasPreviousPage: () => false,
    hasNextPage: () => false
} as Collections.PaginatedCollection;

const store: StoreOptions<RootState> = {
    state: {
        departments: collection,
        occupations: collection,
        administrators: collection,
        faculties: collection,
        students: collection,
        classrooms: collection,
        subjects: collection,
        loads: {
            departments: false,
            occupations: false,
            classrooms: false,
            students: false,
            faculties: false,
            administrators: false,
            subjects: false
        },
        loadErrors: {
            departments: false,
            occupations: false,
            classrooms: false,
            students: false,
            faculties: false,
            administrators: false,
            subjects: false
        },
        route: ""
    },
    actions: {
        fetchDepartments({ commit, state }, url = "/departments") {
            state.loadErrors.departments = false;
            return Axios.get(url)
                .then(response => response.data)
                .then((response: Collections.DepartmentCollection) => {
                    const departments = new Collections.DepartmentCollection(
                        response
                    );
                    commit("FILL_DEPARTMENTS", departments);
                    return Promise.resolve(departments);
                })
                .catch((error: AxiosError) => {
                    state.loadErrors.departments = true;
                    console.log(error.toJSON ? error.toJSON() : error);
                    return Promise.reject(error);
                });
        },
        fetchOccupations({ commit, state }, url = "/occupations") {
            state.loadErrors.occupations = false;
            return Axios.get(url)
                .then(response => response.data)
                .then((response: Collections.OccupationCollection) => {
                    const occupations = new Collections.OccupationCollection(
                        response
                    );
                    commit("FILL_OCCUPATIONS", occupations);
                    return Promise.resolve(occupations);
                })
                .catch((error: AxiosError) => {
                    state.loadErrors.occupations = true;
                    console.log(error.toJSON ? error.toJSON() : error);
                    return Promise.reject(error);
                });
        },
        fetchClassrooms({ commit, state }, url = "/classrooms") {
            state.loadErrors.classrooms = false;
            return Axios.get(url)
                .then(response => response.data)
                .then((response: Collections.ClassroomCollection) => {
                    const classrooms = new Collections.ClassroomCollection(
                        response
                    );
                    commit("FILL_CLASSROOMS", classrooms);
                    return Promise.resolve(classrooms);
                })
                .catch((error: AxiosError) => {
                    state.loadErrors.classrooms = true;
                    console.log(error.toJSON ? error.toJSON() : error);
                    return Promise.reject(error);
                });
        },
        fetchSubjects({ commit, state }, url = "/subjects") {
            state.loadErrors.subjects = false;
            return Axios.get(url)
                .then(response => response.data)
                .then((response: Collections.SubjectCollection) => {
                    const subjects = new Collections.SubjectCollection(
                        response
                    );
                    commit("FILL_SUBJECTS", subjects);
                    return Promise.resolve(subjects);
                })
                .catch((error: AxiosError) => {
                    state.loadErrors.subjects = true;
                    console.log(error.toJSON ? error.toJSON() : error);
                    return Promise.reject(error);
                });
        },
        setRoute({ commit }, name) {
            commit("SET_ROUTE", name);
        }
    },
    mutations: {
        FILL_DEPARTMENTS(state, departments: Collections.DepartmentCollection) {
            Session.set("departments", departments);
            state.loads.departments = true;
            state.departments = departments;
        },
        FILL_OCCUPATIONS(state, occupations: Collections.OccupationCollection) {
            Session.set("occupations", occupations);
            state.loads.occupations = true;
            state.occupations = occupations;
        },
        FILL_CLASSROOMS(state, classrooms: Collections.ClassroomCollection) {
            Session.set("classrooms", classrooms);
            state.loads.classrooms = true;
            state.classrooms = classrooms;
        },
        FILL_SUBJECTS(state, subjects: Collections.SubjectCollection) {
            Session.set("subjects", subjects);
            state.loads.subjects = true;
            state.subjects = subjects;
        },
        SET_ROUTE(state, name: string) {
            state.route = name;
        }
    },
    getters: {
        departments({ departments }) {
            return departments;
        },
        occupations({ occupations }) {
            return occupations;
        },
        subjects({ subjects }) {
            return subjects;
        },
        route({ route }) {
            return route;
        },
        loads({ loads }) {
            return loads;
        },
        loadErrors({ loadErrors }) {
            return loadErrors;
        }
    },
    modules: {
        User
    }
};

export default new Vuex.Store<RootState>(store);
