<template>
    <div class="container pt-3">
        <form class="row">
            <div class="col-sm-12 col-md-6 offset-md-3 col-lg-4 offset-lg-4">
                <label for="email" class="mt-0">Email:</label>
                <input
                    type="email"
                    name="email"
                    placeholder="Email"
                    class="form-control form-control-sm"
                    v-model="email"
                    id="email"
                />
                <small
                    class="form-text text-muted"
                    :class="messages.email.class"
                >
                    <div
                        v-for="(message, index) in messages.email.messages"
                        :key="index"
                    >
                        {{ message }}
                    </div>
                </small>
                <label for="username">Username:</label>
                <input
                    type="text"
                    name="username"
                    placeholder="Username"
                    v-model="username"
                    class="form-control form-control-sm"
                    id="username"
                />
                <small
                    class="form-text text-muted"
                    :class="messages.username.class"
                >
                    <div
                        v-for="(message, index) in messages.username.messages"
                        :key="index"
                    >
                        {{ message }}
                    </div>
                </small>
                <label for="occupation" v-if="role === 2">Occupation:</label>
                <select
                    name="occupation"
                    id="occupation_id"
                    class="form-control form-control-sm"
                    v-model="occupation_id"
                    v-if="role === 2"
                >
                    <option
                        :value="occupation.id"
                        v-for="(occupation, index) in occupations"
                        :key="index"
                    >
                        {{ occupation.name }}
                    </option>
                </select>
                <small
                    class="form-text text-muted"
                    :class="messages.occupation_id.class"
                >
                    <div
                        v-for="(message, index) in messages.occupation_id
                            .messages"
                        :key="index"
                    >
                        {{ message }}
                    </div>
                </small>
                <label for="department">Department</label>
                <select
                    name="department_id"
                    id="department"
                    class="form-control form-control-sm"
                    v-model="department_id"
                >
                    <option
                        :value="department.id"
                        v-for="(department, index) in departments"
                        :key="index"
                    >
                        {{ department.name }}
                    </option>
                </select>
                <small
                    class="form-text text-muted"
                    :class="messages.department_id.class"
                >
                    <div
                        v-for="(message, index) in messages.department_id
                            .messages"
                        :key="index"
                    >
                        {{ message }}
                    </div>
                </small>
                <label for="password">Password:</label>
                <input
                    :type="passwordType"
                    name="password"
                    placeholder="Password"
                    v-model="password"
                    class="form-control form-control-sm"
                    id="password"
                />
                <div class="form-check ml-1 mt-1">
                    <input
                        class="form-check-input"
                        type="checkbox"
                        v-model="toggledPassword"
                    />
                    <small class="form-check-label">
                        Show Password
                    </small>
                </div>
                <small
                    class="form-text text-muted"
                    :class="messages.password.class"
                >
                    <div
                        v-for="(message, index) in messages.password.messages"
                        :key="index"
                    >
                        {{ message }}
                    </div>
                </small>
                <button
                    type="submit"
                    class="btn btn-emperor btn-sm mt-3 px-3"
                    :class="{ disabled: processing }"
                    :disabled="processing"
                    @click.prevent.stop="validate()"
                >
                    <i class="fas fa-spinner fa-spin" v-if="processing"></i>
                    Next
                </button>
            </div>
        </form>
    </div>
</template>

<script lang="ts">
import Vue from "vue";
import Component from "vue-class-component";
import { AxiosResponse, AxiosError } from "axios";
import { ValidationMessage } from "@classes/FormValidation";
import { SignUpFormContract } from "~types/store";
import { Department, Occupation } from "@classes/Models/index";

@Component({
    computed: {
        role(): number {
            return this.$store.getters.signUpForm.user.access_level;
        },
        username: {
            get() {
                return this.$store.getters.signUpForm.user.username;
            },
            set(value: string) {
                const form: SignUpFormContract = Session.temp.get("sign-up");
                form.user.username = value;
                Session.temp.set("sign-up", form, 20);
                this.$store.dispatch("fillSignUpForm", form);
            }
        },
        email: {
            get() {
                return this.$store.getters.signUpForm.user.email;
            },
            set(value: string) {
                const form: SignUpFormContract = Session.temp.get("sign-up");
                form.user.email = value;
                Session.temp.set("sign-up", form, 20);
                this.$store.dispatch("fillSignUpForm", form);
            }
        },
        password: {
            get() {
                return this.$store.getters.signUpForm.user.password;
            },
            set(value: string) {
                const form: SignUpFormContract = Session.temp.get("sign-up");
                form.user.password = value;
                Session.temp.set("sign-up", form, 20);
                this.$store.dispatch("fillSignUpForm", form);
            }
        },
        department_id: {
            get() {
                return this.$store.getters.signUpForm.role.department_id;
            },
            set(value: number) {
                const form: SignUpFormContract = Session.temp.get("sign-up");
                form.role.department_id = value;
                Session.temp.set("sign-up", form, 20);
                this.$store.dispatch("fillSignUpForm", form);
            }
        },
        occupation_id: {
            get() {
                return this.$store.getters.signUpForm.role.occupation_id;
            },
            set(value: number) {
                const form: SignUpFormContract = Session.temp.get("sign-up");
                form.role.occupation_id = value;
                Session.temp.set("sign-up", form, 20);
                this.$store.dispatch("fillSignUpForm", form);
            }
        },
        departments(): Array<Department> {
            return this.$store.getters.departments.data;
        },
        occupations(): Array<Occupation> {
            return this.$store.getters.occupations.data;
        }
    }
})
export default class CredentialsComponent extends Vue {
    messages: {
        [key: string]: ValidationMessage;
    };
    toggledPassword = false;
    processing: boolean;
    constructor() {
        super();
        this.messages = {
            email: new ValidationMessage("Email must be valid."),
            username: new ValidationMessage(
                "Choose a username that you will remember well."
            ),
            occupation_id: new ValidationMessage(),
            department_id: new ValidationMessage(),
            password: new ValidationMessage("Please provide a secure password.")
        };
        window["misc"] = this.messages;
        this.processing = false;
    }
    get passwordType() {
        return this.toggledPassword ? "text" : "password";
    }
    created() {
        const level = Session.temp.get("sign-up-level");
        if (level && level === 2) {
            Session.temp.set("sign-up-level", level, 20);
            this.next();
        }
    }
    validate() {
        if (!this.processing) {
            this.processing = true;
            const form = Session.temp.get("sign-up") as SignUpFormContract;
            Axios.post(`/auth/register`, { ...form.user, ...form.role })
                .then((response: AxiosResponse) => response.data)
                .then((response: any) => {
                    this.processing = false;
                    if (response.status) {
                        Session.token(response.token);
                        Session.temp.set("sign-up", form, 20);
                        Session.temp.set("sign-up-level", 2, 20);
                        this.next();
                    }
                })
                .catch((error: AxiosError) => {
                    this.processing = false;
                    if (error.response && error.response.status === 422) {
                        for (const key in error.response.data.errors) {
                            for (const message of error.response.data.errors[
                                key
                            ]) {
                                this.messages[key].clear();
                                this.messages[key].timeout(
                                    message,
                                    "danger",
                                    5000
                                );
                            }
                        }
                    } else {
                        throw error;
                    }
                });
        }
    }
    next() {
        this.$emit("next", "appDetail");
    }
}
</script>

<style lang="scss" scoped>
label {
    margin: 12px 0 4px 0;
    font-family: "Lato-Light";
}

.form-control,
.btn {
    border-radius: 20px;
}
</style>
