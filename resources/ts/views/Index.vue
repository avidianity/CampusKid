<template>
    <div id="root">
        <div class="container-fluid px-0 main bg-white">
            <app-navbar></app-navbar>
            <main class="container-fluid pt-5">
                <app-header></app-header>
                <app-info></app-info>
                <app-info-cartoon></app-info-cartoon>
                <app-footer></app-footer>
            </main>
        </div>
    </div>
</template>

<script lang="ts">
import Vue from "vue";
import Component from "vue-class-component";
import appNavbar from "@components/Home/Navbar.vue";
import appHeader from "@components/Home/Header.vue";
import appFooter from "@components/Home/Footer.vue";
import appInfo from "@components/Home/Info.vue";
import appInfoCartoon from "@components/Home/InfoCartoon.vue";
@Component({
    components: {
        appNavbar,
        appHeader,
        appFooter,
        appInfo,
        appInfoCartoon
    }
})
export default class Home extends Vue {
    created() {
        const user = Session.user();
        if (user) {
            this.$store.dispatch("login", user);
            this.$router.push(user.homeRoute());
        }
    }
}
</script>

<style lang="scss" scoped>
#root {
    background: url("../assets/bg-home.png") center center;
    background-size: cover;
    background-repeat: no-repeat;
}

.main {
    box-shadow: 0 0 10px rgb(30, 30, 30);
    border-radius: 0px;
}

@media (min-width: 576px) {
    #root {
        padding: 20px;
    }

    .main {
        border-radius: 12px;
    }
}
</style>
