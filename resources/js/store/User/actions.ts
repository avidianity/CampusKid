import { ActionTree } from "vuex";
import Axios from "axios";
import { UserState, RootState, SignUpFormContract } from "~types/store";
import { UserContract } from "~types/Models";

export const actions: ActionTree<UserState, RootState> = {
    fetchUser({ commit }): any {
        Axios.get("/")
            .then(response => {
                const payload: UserContract = response && response.data;
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
    }
};
