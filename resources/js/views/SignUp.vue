<template>
    <div id="root">
        <div class="main align-self-center bg-white mx-auto d-flex">
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
                <keep-alive>
                    <transition name="slide-fade" mode="out-in">
                        <component :is="component" @next="next"></component>
                    </transition>
                </keep-alive>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import Vue from "vue";
import Component from "vue-class-component";
import appRole from "@components/SignUp/Role.vue";
import appCredentials from "@components/SignUp/Credentials.vue";
import appDetail from "@components/SignUp/Detail.vue";

@Component({
    components: {
        appRole,
        appCredentials,
        appDetail
    },
    beforeRouteLeave(to, from, next) {
        next();
    }
})
export default class SignUp extends Vue {
    component = "appRole";
    next(name: string) {
        this.component = name;
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

.progress-pane {
    height: 25px;
    border-radius: 15px;
    max-width: 540px;
    box-shadow: 0 0 5px $emperor;
    margin: auto;
}

.progress-list {
    list-style-type: none;
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

.active {
    background-color: #2d9cdb;
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

.progress-link {
    text-decoration: none;
    align-self: center;
    margin: auto;
    color: rgb(80, 80, 80);
    cursor: default;
}

.main {
    position: relative;
    width: 80%;
    height: 90%;
    border-radius: 10px;
}

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

.rounded-left {
    border-bottom-left-radius: 15px !important;
    border-top-left-radius: 15px !important;
}

.rounded-right {
    border-bottom-right-radius: 15px !important;
    border-top-right-radius: 15px !important;
}

.img-link {
    cursor: pointer;
}

.img-float {
    max-height: 100px;
    max-width: 100px;
}

@media (min-width: 576px) {
    .img-float {
        max-height: 200px;
        max-width: 200px;
    }
}

#root {
    background: url("../assets/bg-home.png") center center;
    background-size: cover;
    background-repeat: no-repeat;
    padding: 20px;
    height: 100vh;
    display: flex;
}
</style>
