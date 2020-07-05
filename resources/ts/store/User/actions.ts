import { ActionTree } from "vuex";
import Axios from "axios";
import { UserState, RootState, SignUpFormContract } from "~types/store";
import { User, File, Token } from "@classes/Models/index";

export const actions: ActionTree<UserState, RootState> = {
    fetchUser({ commit }): any {
        Axios.get("/")
            .then(response => {
                const payload: User = response && response.data;
                commit("FILL_USER", payload);
            })
            .catch(error => {
                console.error("fetchUser: ", error);
            });
    },
    fillSignUpForm({ commit }, form: SignUpFormContract): any {
        commit("FILL_SIGN_UP_FORM", form);
    },
    clearSignUpForm({ commit }): any {
        commit("CLEAR_SIGN_UP_FORM");
    },
    login({ commit }, user: User) {
        commit("LOGIN", user);
    },
    logout({ commit }) {
        commit("LOGOUT");
    },
    fillProfilePicture({ commit }, file: File) {
        commit("FILL_PROFILE_PICTURE", file);
    },
    fillTokens({ commit }, tokens: Array<Token>) {
        commit("FILL_TOKENS", tokens);
    }
};
