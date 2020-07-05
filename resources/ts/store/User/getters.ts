import { GetterTree } from "vuex";
import { UserState, RootState, SignUpFormContract } from "~types/store";
import { User, File, Token } from "@classes/Models";

export const getters: GetterTree<UserState, RootState> = {
    user(state): User | null {
        return state.user;
    },
    signUpForm(state): SignUpFormContract {
        return state.forms.sign_up;
    },
    logged(state): boolean {
        return state.logged;
    },
    profilePicture(state): File | undefined {
        return state.profile;
    },
    tokens({ tokens }): Array<Token> {
        return tokens;
    }
};
