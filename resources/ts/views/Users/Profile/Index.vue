<template>
    <div class="container-fluid pt-5 mb-2">
        <div class="row" v-if="loaded && !error">
            <div class="col-12">
                <app-profile :user="user"></app-profile>
            </div>
            <div class="col-md-3">
                <app-about :user="user"></app-about>
            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header p-2">
                        <app-navigation :user="user"></app-navigation>
                    </div>
                    <div class="card-body">
                        <router-view></router-view>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center mx-auto mt-3" v-if="!loaded && !error">
            <p class="d-inline text-muted">
                {{ loadInfo }}
            </p>
            <i class="fas fa-circle-notch fa-spin"></i>
        </div>
        <error-500 v-if="error"></error-500>
    </div>
</template>

<script lang="ts">
import Vue from "vue";
import Component from "vue-class-component";
import { Action } from "vuex-class";

import { User, Token } from "@classes/Models";

import D500 from "@components/Dashboard500.vue";
import Profile from "./Profile.vue";
import About from "./About.vue";
import Navigation from "./Navigation.vue";

@Component({
    components: {
        appProfile: Profile,
        appAbout: About,
        error500: D500,
        appNavigation: Navigation
    }
})
export default class ProfileIndexComponent extends Vue {
    tokens: any = {};
    user: User | null = null;
    error = false;
    loaded = false;
    loadInfo = "";
    @Action toggleContentHeader: any;
    @Action fillTokens: any;
    created() {
        this.toggleContentHeader(false);
        const id = Number(this.$route.params.id);
        if (id === ((Session.user() as User).id as number)) {
            this.loadInfo = "0/2 Fetching auth info.";
            Axios.get(`/auth/tokens`)
                .then(response => response.data)
                .then((data: Array<Token>) => {
                    this.fillTokens(data.map(token => new Token(token)));
                    this.tokens = data;
                    this.loadInfo = "1/2 Fetching user info.";
                    return Axios.get(`/users/${(Session.user() as User).id}`);
                })
                .then(response => response.data)
                .then((user: User) => {
                    this.user = new User(user);
                    this.loadInfo = "";
                    this.loaded = true;
                })
                .catch(error => {
                    this.error = true;
                });
        } else {
            this.loadInfo = "Fetching user info.";
            Axios.get(`/users/${id}`)
                .then(response => response.data)
                .then(data => {
                    this.user = new User(data);
                    this.loaded = true;
                })
                .catch(error => {
                    this.error = true;
                });
        }
    }
    self() {
        return this.$store.getters.user;
    }
}
</script>

<style lang="scss"></style>
