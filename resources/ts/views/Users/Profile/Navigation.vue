<template>
    <ul class="nav">
        <router-link
            :to="`/dashboard/users/${user.id}`"
            class="nav-item"
            exact
            tag="li"
        >
            <a href="#" class="nav-link">Posts</a>
        </router-link>
        <router-link
            :to="`/dashboard/users/${user.id}/followers`"
            class="nav-item"
            tag="li"
        >
            <a href="#" class="nav-link">Followers</a>
        </router-link>
        <router-link
            :to="`/dashboard/users/${user.id}/following`"
            class="nav-item"
            tag="li"
        >
            <a href="#" class="nav-link">Following</a>
        </router-link>
        <router-link
            :to="`/dashboard/users/${user.id}/settings`"
            class="nav-item"
            tag="li"
            v-if="user.id === self.id"
        >
            <a href="#" class="nav-link">Settings</a>
        </router-link>
    </ul>
</template>

<script lang="ts">
import ParentVue from "vue";
import Component from "vue-class-component";

import { User } from "@classes/Models";

const Vue = ParentVue.extend({
    props: {
        user: User
    }
});

@Component
export default class ProfileNavigationComponent extends Vue {
    get self() {
        return this.$store.getters.user;
    }
}
</script>

<style lang="scss" scoped>
@import "@styles/global";
.active {
    background: $emperor;
}
.active > a {
    color: #fff !important;
}
</style>
