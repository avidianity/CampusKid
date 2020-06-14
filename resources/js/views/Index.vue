<template>
    <div class="container-fluid px-0 main bg-white">
        <app-navbar></app-navbar>
        <main class="container-fluid pt-5">
            <div class="row px-5">
                <div class="col-sm-12 col-md-6 pl-5">
                    <h1 class="title">
                        Make Learning and Teaching Easier
                    </h1>
                    <p class="lead">
                        We help teachers and students learn better through
                        interactive, real-time and secure services. From
                        conducting classes to open discussions as well as
                        tasking with homeworks and many more. We handle it all
                        for you!
                    </p>
                    <router-link to="/sign-up" class="btn btn-cutty-sark">
                        Get Started
                    </router-link>
                </div>
                <div class="col-sm-12 col-md-6 py-3 pr-3">
                    <img src="@assets/intro.png" alt="" class="img-fluid" />
                </div>
            </div>
            <app-info></app-info>
            <app-info-cartoon></app-info-cartoon>
            <app-footer></app-footer>
        </main>
    </div>
</template>

<script lang="ts">
import Vue from "vue";
import Component from "vue-class-component";
import appNavbar from '@components/Home/Navbar.vue';
import appFooter from "@components/Home/Footer.vue";
import appInfo from "@components/Home/Info.vue";
import appInfoCartoon from "@components/Home/InfoCartoon.vue";
@Component({
    components: {
        appNavbar,
        appFooter,
        appInfo,
        appInfoCartoon
    }
})
export default class Home extends Vue {}
</script>

<style lang="scss" scoped>

.main {
    box-shadow: 0 0 10px rgb(30, 30, 30);
    border-radius: 12px;
}

.lead {
    text-indent: 24px;
    font-size: 18px;
    font-family: "Lato-Light";
    line-height: 30px;
}

.title {
    margin-top: 12px;
    font-size: 46px;
}
</style>

<style>
body {
    background: url("../assets/bg-home.png") center center;
    background-size: cover;
    background-repeat: no-repeat;
    padding: 20px;
    font-family: "Lato-Regular";
}
</style>
