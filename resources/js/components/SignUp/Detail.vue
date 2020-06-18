<template>
    <div class="container pt-3">
        <div class="row">
            <div class="col-sm-12 col-md-8 offset-md-2">
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <label for="first_name">First Name:</label>
                        <input
                            type="text"
                            name="first_name"
                            placeholder="First Name"
                            class="form-control form-control-sm"
                            v-model="first_name"
                        />
                        <small
                            class="form-text text-muted"
                            :class="messages.first_name.class"
                        >
                            <div
                                v-for="(message, index) in messages.first_name
                                    .messages"
                                :key="index"
                            >
                                {{ message }}
                            </div>
                        </small>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <label for="last_name">Last Name:</label>
                        <input
                            type="text"
                            name="last_name"
                            id="last_name"
                            placeholder="Last Name"
                            class="form-control form-control-sm"
                            v-model="last_name"
                        />
                        <small
                            class="form-text text-muted"
                            :class="messages.last_name.class"
                        >
                            <div
                                v-for="(message, index) in messages.last_name
                                    .messages"
                                :key="index"
                            >
                                {{ message }}
                            </div>
                        </small>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <label for="gender">Gender</label>
                        <select
                            name="gender"
                            id="gender"
                            class="form-control form-control-sm"
                            v-model="gender"
                        >
                            <option value="Male">
                                Male
                            </option>
                            <option value="Female">
                                Female
                            </option>
                        </select>
                        <small
                            class="form-text text-muted"
                            :class="messages.gender.class"
                        >
                            <div
                                v-for="(message, index) in messages.gender
                                    .messages"
                                :key="index"
                            >
                                {{ message }}
                            </div>
                        </small>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <label for="birthday">Birthday:</label>
                        <input
                            type="date"
                            name="birthday"
                            id="birthday"
                            placeholder="Birthday"
                            class="form-control form-control-sm"
                            v-model="birthday"
                        />
                        <small
                            class="form-text text-muted"
                            :class="messages.birthday.class"
                        >
                            <div
                                v-for="(message, index) in messages.birthday
                                    .messages"
                                :key="index"
                            >
                                {{ message }}
                            </div>
                        </small>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <label for="address">Address:</label>
                        <input
                            type="text"
                            name="address"
                            id="address"
                            placeholder="Address"
                            class="form-control form-control-sm"
                            v-model="address"
                        />
                        <small
                            class="form-text text-muted"
                            :class="messages.address.class"
                        >
                            <div
                                v-for="(message, index) in messages.address
                                    .messages"
                                :key="index"
                            >
                                {{ message }}
                            </div>
                        </small>
                    </div>
                    <div class="col-sm-12 mt-3">
                        <button
                            type="submit"
                            class="btn btn-emperor btn-sm"
                            :disabled="processing"
                            :class="{ disabled: processing }"
                            @click.prevent.stop="submit()"
                        >
                            <i
                                class="fas fa-spinner fa-spin"
                                v-if="processing"
                            ></i>
                            {{ processing ? "Creating" : "Create" }} Account
                        </button>
                        <small class="form-text text-muted">
                            By creating an account, you agree to our
                            <router-link to="/privacy-policy">
                                Privacy policy
                            </router-link>
                            and
                            <router-link to="/terms-of-service">
                                Terms of Service.
                            </router-link>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import Vue from "vue";
import Component from "vue-class-component";
import { Action } from "vuex-class";
import { AxiosResponse, AxiosError } from "axios";

import { ValidationMessage } from "@classes/FormValidation";
import { Detail } from "@classes/Models";
import { DetailContract } from "~types/Models";
import { SignUpFormContract } from "~types/store";
import Message from "@classes/Message";

@Component({
    computed: {
        first_name: {
            get() {
                return this.$store.getters.signUpForm.detail.first_name;
            },
            set(value: string) {
                const form: SignUpFormContract = Session.temp.get("sign-up");
                form.detail.first_name = value;
                Session.temp.set("sign-up", form, 20);
                this.$store.dispatch("fillSignUpForm", form);
            }
        },
        last_name: {
            get() {
                return this.$store.getters.signUpForm.detail.last_name;
            },
            set(value: string) {
                const form: SignUpFormContract = Session.temp.get("sign-up");
                form.detail.last_name = value;
                Session.temp.set("sign-up", form, 20);
                this.$store.dispatch("fillSignUpForm", form);
            }
        },
        gender: {
            get() {
                return this.$store.getters.signUpForm.detail.gender;
            },
            set(value: string) {
                const form: SignUpFormContract = Session.temp.get("sign-up");
                form.detail.gender = value;
                Session.temp.set("sign-up", form, 20);
                this.$store.dispatch("fillSignUpForm", form);
            }
        },
        birthday: {
            get() {
                return this.$store.getters.signUpForm.detail.birthday;
            },
            set(value: string) {
                const form: SignUpFormContract = Session.temp.get("sign-up");
                form.detail.birthday = value;
                Session.temp.set("sign-up", form, 20);
                this.$store.dispatch("fillSignUpForm", form);
            }
        },
        address: {
            get() {
                return this.$store.getters.signUpForm.detail.address;
            },
            set(value: string) {
                const form: SignUpFormContract = Session.temp.get("sign-up");
                form.detail.address = value;
                Session.temp.set("sign-up", form, 20);
                this.$store.dispatch("fillSignUpForm", form);
            }
        }
    }
})
export default class DetailComponent extends Vue {
    @Action clearSignUpForm: any;
    processing = false;
    messages: {
        [key: string]: ValidationMessage;
    };
    constructor() {
        super();
        this.messages = {
            first_name: new ValidationMessage(),
            last_name: new ValidationMessage(),
            gender: new ValidationMessage(),
            birthday: new ValidationMessage(),
            address: new ValidationMessage()
        };
    }
    submit() {
        this.processing = true;
        const form: SignUpFormContract = Session.temp.get("sign-up");
        Axios.post("/detail", form.detail)
            .then((response: AxiosResponse) => response.data)
            .then((response: DetailContract) => {
                this.processing = false;
                this.clearSignUpForm();
                Session.clear();
                Session.temp.clear();
                const message =
                    "Signed up successfully. Please login to continue.";
                const style = ["alert-success"];
                Session.flash.set("message", new Message(message, style));
                this.$router.push({
                    path: "/sign-in"
                });
            })
            .catch((error: AxiosError) => {
                this.processing = false;
                if (error.response && error.response.status === 422) {
                    for (const key in error.response.data.errors) {
                        for (const message of error.response.data.errors[key]) {
                            this.messages[key].clear();
                            this.messages[key].danger(message);
                        }
                    }
                } else {
                    console.log(error);
                }
            });
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
