<template>
    <nav class="navbar navbar-expand-sm navbar-dark bg-emperor">
        <router-link class="navbar-brand ml-2" to="/" exact>
            <img
                src="@assets/logo.png"
                height="30"
                width="30"
                alt=""
                class="d-inline-block"
            />
            CampusKid
        </router-link>
        <button
            class="navbar-toggler border-0"
            type="button"
            data-toggle="collapse"
            data-target="#campuskidNavbar"
            aria-controls="campuskidNavbar"
            aria-expanded="false"
            aria-label="Toggle navigation"
        >
            <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="campuskidNavbar">
            <ul class="navbar-nav ml-auto mr-2">
                <li class="nav-item">
                    <router-link to="/help" class="nav-link">
                        Help
                        <span class="nav-line"></span>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/contact" class="nav-link">
                        Contact
                        <span class="nav-line"></span>
                    </router-link>
                </li>
                <li class="nav-item" v-if="!logged">
                    <router-link to="/sign-in" class="nav-link">
                        Sign In
                        <span class="nav-line"></span>
                    </router-link>
                </li>
            </ul>
            <router-link
                to="/sign-up"
                class="btn btn-tradewind btn-sm my-2 my-sm-0 mr-2"
                v-if="!logged"
            >
                Sign Up
            </router-link>
            <router-link
                :to="homeRoute"
                class="btn btn-cutty-sark btn-sm my-2 my-sm-0 mr-2"
                v-if="logged"
            >
                Dashboard
            </router-link>
        </div>
    </nav>
</template>

<script lang="ts">
import Vue from "vue";
import Component from "vue-class-component";
import { User } from "@classes/Models/index";

@Component
export default class NavbarComponent extends Vue {
    get logged(): boolean {
        return this.$store.getters.logged;
    }
    get homeRoute() {
        try {
            return (Session.user() as User).homeRoute().path;
        } catch (error) {
            return "/";
        }
    }
}
</script>

<style lang="scss" scoped>
@import "@styles/global.scss";

@media(max-width: 575px) {
    .navbar {
        position: fixed;
        top: 0;
        right: 0;
        left: 0;
        z-index: 1030;
    }
}

.nav-line {
    display: none;
    width: 0%;
    height: 2px;
    background-color: #fff;
    transition: 0.5s ease;
}

@media (min-width: 576px) {
    .navbar {
        border-top-right-radius: 11px;
        border-top-left-radius: 11px;
    }

    .nav-line {
        display: block;
    }

    .nav-link:hover .nav-line {
        width: 100%;
    }
}

.btn {
    padding: 6px 24px;
    border-radius: 20px;
    font-family: "Lato-Bold";
}

.navbar-toggler:focus {
    outline: none;
}
</style>
