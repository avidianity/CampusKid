import { MutationTree } from "vuex";
import { UserState, SignUpFormContract } from "~types/store";
import { User, File, Token } from "@classes/Models/index";

export const mutations: MutationTree<UserState> = {
    FILL_USER(state, payload: User) {
        state.user = payload;
    },
    FILL_SIGN_UP_FORM(state, payload: SignUpFormContract) {
        state.forms.sign_up = payload;
    },
    CLEAR_SIGN_UP_FORM(state) {
        delete state.forms;
    },
    LOGIN(state, user: User) {
        state.user = user;
        state.logged = true;
    },
    LOGOUT(state) {
        state.user = null;
        state.profile = undefined;
        delete state.user;
        delete state.profile;
        state.logged = false;
        Session.clearAll();
    },
    FILL_PROFILE_PICTURE(state, file: File) {
        state.profile = file;
    },
    FILL_TOKENS(state, tokens: Array<Token>) {
        state.tokens = tokens;
    }
};
