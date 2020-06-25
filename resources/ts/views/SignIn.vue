<template>
    <div id="root">
        <div class="container-fluid">
            <div class="row">
                <div
                    class="col-sm-12 col-md-6 offset-md-3 col-lg-4 offset-lg-4 main p-3 rounded shadow border"
                >
                    <div class="d-flex">
                        <h2 class="mr-auto">Login</h2>
                        <router-link to="/" class="ml-auto back">
                            <img
                                src="@assets/logo.png"
                                alt=""
                                height="50"
                                width="50"
                                class="rounded-circle border shadow-sm logo"
                            />
                        </router-link>
                    </div>
                    <small
                        class="p-2 rounded d-block my-1"
                        v-if="message.has"
                        :class="message.classes"
                    >
                        {{ message.body }}
                        <i
                            class="fas fa-times float-right mt-1 close-btn"
                            @click.prevent.stop="closeMessage()"
                        ></i>
                    </small>
                    <label for="credential">Username/Email:</label>
                    <input
                        type="text"
                        name="username"
                        id="credential"
                        placeholder="Username/Email"
                        class="form-control form-control-sm"
                        v-model="username"
                    />
                    <small
                        class="form-text text-muted"
                        :class="messages.username.class"
                    >
                        <div
                            v-for="(message, index) in messages.username
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
                        id="password"
                        placeholder="Password"
                        class="form-control form-control-sm"
                        v-model="password"
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
                            v-for="(message, index) in messages.password
                                .messages"
                            :key="index"
                        >
                            {{ message }}
                        </div>
                    </small>
                    <button
                        type="submit"
                        class="btn btn-emperor btn-sm mt-1"
                        :class="{ disabled: processing }"
                        :disabled="processing"
                        @click.prevent.stop="submit()"
                    >
                        <i class="fas fa-spinner fa-spin" v-if="processing"></i>
                        {{ processing ? "Signing" : "Sign" }} In
                    </button>
                    <div class="form-check ml-1 mt-1">
                        <input
                            class="form-check-input"
                            type="checkbox"
                            v-model="remember_me"
                            id="remember_me"
                        />
                        <label class="form-check-label" for="remember_me">
                            Remember Me
                        </label>
                    </div>
                    <small class="form-text text-muted">
                        Do not check if you do not want your session to be
                        saved.
                    </small>
                    <small class="form-text text-muted">
                        This will require you to login again on your next visit.
                    </small>
                    <router-link to="/sign-up" class="btn-link d-block mt-2">
                        Create an Account
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

import Message from "@classes/Message";
import { ValidationMessage } from "../classes/FormValidation";
import { AxiosResponse, AxiosError } from "axios";
import { User } from "@classes/Models";

@Component
export default class SignInComponent extends Vue {
    @Action login: any;
    processing = false;
    toggledPassword = false;
    message: {
        has: boolean;
        body: string;
        classes: object;
    };
    form: {
        username: string;
        password: string;
    };
    remember_me = false;
    messages: {
        [key: string]: ValidationMessage;
    };
    created() {
        if (Session.hasToken()) {
            const user = Session.user() as User;
            this.login(user);
            this.$router.push(user.homeRoute());
        }
    }
    constructor() {
        super();
        this.message = {
            has: false,
            body: "",
            classes: {}
        };
        if (Session.temp.has("sign-in")) {
            this.form = Session.temp.get("sign-in");
            Session.temp.set("sign-in", this.form, 20);
        } else {
            this.form = {
                username: "",
                password: ""
            };
            Session.temp.set("sign-in", this.form, 20);
        }
        this.messages = {
            username: new ValidationMessage(),
            password: new ValidationMessage()
        };
        if (Session.flash.has("message")) {
            this.message.has = true;
            const message = Session.flash.get("message") as Message;
            this.message.body = message.message;
            this.message.classes = message.classes;
        }
    }
    get passwordType() {
        return this.toggledPassword ? "text" : "password";
    }
    closeMessage() {
        this.message = {
            has: false,
            body: "",
            classes: {}
        };
    }
    submit() {
        this.processing = true;
        const data = this.form;
        Axios.post("/auth/login", {
            ...data,
            email: this.form.username
        })
            .then((response: AxiosResponse) => response.data)
            .then((response: { token: string; data: User }) => {
                const user = new User(response.data);
                Session.token(response.token, this.remember_me);
                Session.user(user, this.remember_me);
                Session.temp.remove("sign-in");
                this.login(user);
                Session.flash.set("toastr", {
                    type: "success",
                    message: `Welcome back, ${user.username}!`
                });
                this.$router.push(user.homeRoute());
            })
            .catch((error: AxiosError) => {
                if (error.response && error.response.status === 401) {
                    for (const key in error.response.data.errors) {
                        if (key === "message") {
                            toastr.error(
                                error.response.data.errors[key][0],
                                "422",
                                {
                                    positionClass: "toast-top-center"
                                }
                            );
                            // this.message.has = true;
                            // this.message.body =
                            //     error.response.data.errors[key][0];
                            // this.message.classes = {
                            //     "alert alert-danger": true
                            // };
                        } else {
                            for (const message of error.response.data.errors[
                                key
                            ]) {
                                if (key in this.messages) {
                                    this.messages[key].clear();
                                    this.messages[key].timeout(
                                        message,
                                        "danger",
                                        15000
                                    );
                                }
                            }
                        }
                    }
                } else {
                    console.log(error.toJSON ? error.toJSON() : error);
                }
            })
            .then(() => {
                this.processing = false;
            });
    }
    get username() {
        return this.form.username;
    }
    set username(value: string) {
        const form = Session.temp.get("sign-in");
        form.username = value;
        Session.temp.set("sign-in", form, 20);
        this.form.username = value;
    }
    get password() {
        return this.form.password;
    }
    set password(value: string) {
        const form = Session.temp.get("sign-in");
        form.password = value;
        Session.temp.set("sign-in", form, 20);
        this.form.password = value;
    }
}
</script>

<style lang="scss" scoped>
#root {
    background: url("../assets/bg-home.png") center center;
    background-size: cover;
    background-repeat: no-repeat;
    padding: 2px;
    height: 100vh;
    display: flex;
}

.main {
    background-color: #fff;
    font-family: "Lato-Light";
    height: 100%;
    margin-top: 3rem;
}

@media (min-width: 576px) {
    #root {
        padding: 20px;
    }
}

.form-control,
.btn {
    border-radius: 15px;
}

.back {
    cursor: pointer;
}

.close-btn:hover {
    color: rgb(100, 100, 100);
    cursor: pointer;
}
.back:focus {
    outline: none;
}
</style>
