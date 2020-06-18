import { Module } from "vuex";
import { getters } from "./getters";
import { actions } from "./actions";
import { mutations } from "./mutations";
import { UserState, RootState, SignUpFormContract } from "~types/store";

const sign_up: SignUpFormContract = {
    user: {
        access_level: null,
        email: null,
        username: null,
        password: null
    },
    detail: {
        first_name: null,
        last_name: null,
        gender: null,
        birthday: null,
        address: null
    },
    role: {
        department_id: null,
        occupation_id: null
    }
};

export const state: UserState = {
    user: undefined,
    forms: {
        sign_up
    },
    logged: false
};

export const User: Module<UserState, RootState> = {
    state,
    mutations,
    actions,
    getters
};
