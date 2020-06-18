import { GetterTree } from "vuex";
import { UserState, RootState, SignUpFormContract } from "~types/store";
import { UserContract } from "~types/Models";

export const getters: GetterTree<UserState, RootState> = {
    user(state): UserContract | undefined {
        return state.user;
    },
    signUpForm(state): SignUpFormContract {
        return state.forms.sign_up;
    },
    logged(state): boolean {
        return state.logged;
    }
};
