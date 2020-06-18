<template>
    <div id="root">
        <div class="main align-self-center bg-white mx-auto d-flex shadow">
            <div class="align-self-center mx-auto w-100 h-100 pt-2">
                <router-link to="/" exact class="text-center" tag="div">
                    <img
                        src="@assets/logo.png"
                        alt=""
                        height="80"
                        width="80"
                        class="rounded-circle shadow-sm border m-0 img-link"
                    />
                </router-link>
                <img
                    src="@assets/form-signup-blade-2.svg"
                    alt=""
                    class="img-fluid img-float top-right"
                />
                <img
                    src="@assets/form-signup-blade.svg"
                    alt=""
                    class="img-fluid img-float bottom-left"
                />
                <div class="mt-3 progress-pane">
                    <ul class="progress-list">
                        <li
                            class="progress-item rounded-left"
                            :class="{
                                active: component === 'appRole'
                            }"
                        >
                            <a
                                href=""
                                class="progress-link"
                                @click.prevent.stop=""
                            >
                                1. Select Role
                            </a>
                        </li>
                        <li
                            class="progress-item border-left border-right"
                            :class="{
                                active: component === 'appCredentials'
                            }"
                        >
                            <a
                                href=""
                                class="progress-link"
                                @click.prevent.stop=""
                            >
                                2. Account Credentials
                            </a>
                        </li>
                        <li
                            class="progress-item rounded-right"
                            :class="{
                                active: component === 'appDetail'
                            }"
                        >
                            <a
                                href=""
                                class="progress-link"
                                @click.prevent.stop=""
                            >
                                3. Personal Details
                            </a>
                        </li>
                    </ul>
                </div>
                <transition name="slide-fade" mode="out-in" v-if="!loaded">
                    <div class="container pt-5">
                        <div class="row">
                            <div class="col-md-4 offset-md-4 text-center">
                                <h5>
                                    Please wait...
                                </h5>
                                <i class="fas fa-spinner fa-spin fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </transition>
                <keep-alive>
                    <transition name="slide-fade" mode="out-in">
                        <component
                            v-if="component"
                            :is="component"
                            @next="next"
                        ></component>
                    </transition>
                </keep-alive>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import Vue from "vue";
import Component from "vue-class-component";

import { Action } from "vuex-class";

import appRole from "@components/SignUp/Role.vue";
import appCredentials from "@components/SignUp/Credentials.vue";
import appDetail from "@components/SignUp/Detail.vue";

import { SignUpFormContract } from "~types/store";
import { DepartmentCollection, OccupationCollection } from "@collections/index";
import { Department, User } from "@models/index";

@Component({
    components: {
        appRole,
        appCredentials,
        appDetail
    }
})
export default class SignUp extends Vue {
    component: string | null;
    @Action fillSignUpForm: any;
    @Action fetchDepartments: any;
    @Action fetchOccupations: any;
    @Action login: any;
    loaded = false;
    constructor() {
        super();
        this.component = null;
    }
    next(name: string) {
        this.component = name;
    }
    created() {
        if (Session.hasToken()) {
            const user = Session.user() as User;
            this.login(user);
            this.$router.push(user.homeRoute());
            return;
        }
        Promise.all([this.fetchDepartments(), this.fetchOccupations()]).then(
            responses => {
                const departments = responses[0] as DepartmentCollection;
                const occupations = responses[1] as OccupationCollection;
                if (Session.temp.has("sign-up")) {
                    const form: SignUpFormContract = Session.temp.get(
                        "sign-up"
                    );
                    Session.temp.set("sign-up", form, 20);
                    this.fillSignUpForm(form);
                } else {
                    Session.temp.renew(true);
                    const form: SignUpFormContract = {
                        user: {
                            access_level: null,
                            email: null,
                            username: null,
                            password: null
                        },
                        detail: {
                            first_name: null,
                            last_name: null,
                            gender: "Male",
                            birthday: null,
                            address: null
                        },
                        role: {
                            occupation_id: departments.data[0].id,
                            department_id: occupations.data[0].id
                        }
                    };
                    Session.temp.set("sign-up", form, 20);
                    this.fillSignUpForm(form);
                }
                this.component = "appRole";
                this.loaded = true;
            }
        );
    }
    beforeRouteLeave(to: any, from: any, next: any) {
        next();
    }
}
</script>

<style lang="scss" scoped>
@import "@styles/global.scss";

.slide-fade-enter-active {
    transition: all 0.5s ease-in;
}
.slide-fade-leave-active {
    transition: all 0.5s ease-out;
}
.slide-fade-enter,
.slide-fade-leave-to {
    transform: translateX(20px);
    opacity: 0;
}

.main {
    position: relative;
    width: 100%;
    height: 100%;
    border-radius: 0;
    border-radius: 13px;
}

.progress-pane {
    padding: 0 16px;
}

.progress-list {
    box-shadow: 0 0 5px $emperor;
    border-radius: 15px;
    list-style-type: none;
    padding: 0;
}

.progress-item {
    padding: 0px 4px;
}

.progress-link {
    text-decoration: none;
    color: rgb(80, 80, 80);
    cursor: default;
}

.active {
    background-color: #2d9cdb;
    border-radius: 15px !important;
}

.active > a {
    color: #fff;
}

// .progress-item:hover {
//     background-color: #2d9cdb;
// }

// .progress-item:hover > .progress-link {
//     color: #fff;
// }

.top-right {
    position: absolute;
    top: 0;
    right: 0;
    border-top-right-radius: 10px;
}

.bottom-left {
    position: absolute;
    bottom: 0;
    left: 0;
    border-bottom-left-radius: 10px;
}

.img-link {
    cursor: pointer;
}

.img-float {
    max-height: 100px;
    max-width: 100px;
}

@media (min-width: 768px) {
    .active {
        border-radius: 0 !important;
    }

    .main {
        width: 100%;
        height: 100%;
    }

    .progress-pane {
        height: 25px;
        max-width: 540px;
        margin: auto;
    }

    .progress-list {
        display: flex;
        padding: 0;
    }

    .progress-item {
        text-align: center;
        width: 100%;
        height: 25px;
        display: flex;
        // cursor: pointer;
    }

    .progress-link {
        align-self: center;
        margin: auto;
    }

    .rounded-left {
        border-bottom-left-radius: 15px !important;
        border-top-left-radius: 15px !important;
    }

    .rounded-right {
        border-bottom-right-radius: 15px !important;
        border-top-right-radius: 15px !important;
    }

    .img-float {
        max-height: 200px;
        max-width: 200px;
    }
}

#root {
    background: url("../assets/bg-home.png") center center;
    background-size: cover;
    background-repeat: no-repeat;
    padding: 5px;
    height: 100vh;
    display: flex;
}
</style>
