import { MutationTree } from "vuex";
import { UserState, SignUpFormContract } from "~types/store";
import { UserContract } from "~types/Models";

export const mutations: MutationTree<UserState> = {
    FILL_USER(state, payload: UserContract) {
        state.user = payload;
    },
    FILL_SIGN_UP_FORM(state, payload: SignUpFormContract) {
        state.forms.sign_up = payload;
    },
    CLEAR_SIGN_UP_FORM(state) {
        delete state.forms;
    }
};
