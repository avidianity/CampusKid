<template>
    <div class="container pt-3">
        <div class="row">
            <div class="col-sm-12 col-md-6 offset-md-3">
                <div class="container">
                    <h3 class="mb-4">I am a...</h3>
                    <div class="text-center mb-5">
                        <button
                            class="btn btn-tradewind mr-3"
                            @click.prevent.stop="next('Teacher')"
                        >
                            Teacher
                            <i class="fas fa-user-tie"></i>
                        </button>
                        <button
                            class="btn btn-cutty-sark ml-3"
                            @click.prevent.stop="next('Student')"
                        >
                            Student
                            <i class="fas fa-user-graduate"></i>
                        </button>
                    </div>
                    <router-link to="/sign-in">
                        Already have an account? Login
                    </router-link>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import Vue from "vue";
import Component from "vue-class-component";
import { Action } from "vuex-class";

import { SignUpFormContract } from "~types/store";

const Roles = {
    ["Student" as string]: 1,
    ["Teacher" as string]: 2,
    [1 as number]: "Student",
    [2 as number]: "Teacher"
};

@Component
export default class RoleComponent extends Vue {
    @Action fillSignUpForm: any;
    form: SignUpFormContract = Session.temp.get("sign-up");
    created() {
        if (this.form.user.access_level !== null) {
            this.next(Roles[this.form.user.access_level] as string);
        }
    }
    next(key: string) {
        this.form.user.access_level = Roles[key] as number;
        Session.temp.set("sign-up", this.form, 20);
        this.fillSignUpForm(this.form);
        this.$emit("next", "appCredentials");
    }
}
</script>

<style lang="scss" scoped>
.btn {
    border-radius: 20px;
}
</style>
