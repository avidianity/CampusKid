<template>
    <router-view></router-view>
</template>

<script lang="ts">
import Vue from "vue";
import Component from "vue-class-component";
import { Action } from "vuex-class";
import { User } from "@classes/Models";

@Component
export default class App extends Vue {
    @Action login: any;
    @Action fillProfilePicture: any;
    created() {
        if (!this.$store.getters.logged) {
            const user = Session.user() as User;
            if (user) {
                user.getProfilePicture().then(file => {
                    this.fillProfilePicture(file);
                });
                this.login(user);
            }
        }
    }
}
</script>
