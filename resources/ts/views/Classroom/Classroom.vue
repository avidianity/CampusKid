<template>
    <div class="container-fluid pt-2 pb-5">
        <div class="row" v-if="loaded && !error">
            <app-header :classroom="classroom"></app-header>
            <app-pill></app-pill>
            <div class="tab-content col-sm-12 col-md-9">
                <app-posts
                    :posts="posts"
                    :profilePicture="profilePicture"
                    :classroomID="classroom.id"
                ></app-posts>
                <app-members :classroom="classroom"></app-members>
                <app-tasks
                    :classroom="classroom"
                    :profilePicture="profilePicture"
                ></app-tasks>
            </div>
        </div>
        <div class="pt-5 col-12" v-if="!loaded && !error">
            <div class="mt-5 text-center pt-5 d-flex">
                <div class="mx-auto">
                    <h4 class="m-1 d-inline">Loading...</h4>
                    <i class="fas fa-circle-notch fa-spin fa-2x"></i>
                    <div class="text-muted">
                        {{ loadInfo }}
                    </div>
                </div>
            </div>
        </div>
        <app-error v-if="error"></app-error>
        <app-error-404
            v-if="error && is404"
            title="Oops! Classroom not found."
            body="We could not find the classroom you were looking for."
        ></app-error-404>
    </div>
</template>

<script lang="ts">
import Vue from "vue";
import Component from "vue-class-component";
import { Route, NavigationGuardNext } from "vue-router";
import { Action } from "vuex-class";
import { AxiosError, AxiosResponse } from "axios";

import * as Models from "@classes/Models";
import { PostCollection } from "@classes/Collections";

import Header from "./Header.vue";
import Pill from "./Tabs/Pill.vue";
import Posts from "./Tabs/Posts.vue";
import Members from "./Tabs/Members.vue";
import Tasks from "./Tabs/Tasks.vue";
import D500 from "@components/Dashboard500.vue";
import D404 from "@components/Dashboard404.vue";

@Component({
    components: {
        appHeader: Header,
        appPill: Pill,
        appPosts: Posts,
        appMembers: Members,
        appTasks: Tasks,
        appError: D500,
        appError404: D404
    }
})
export default class ClassroomComponent extends Vue {
    @Action toggleContentHeader: any;
    @Action findClassroomByID: any;
    loaded = false;
    loadInfo = "";
    error = false;
    is500 = false;
    is404 = false;
    classroom: Models.Classroom | null = null;
    posts: Array<Models.Post> = [];
    pagination: PostCollection | null = null;
    get self() {
        return this.$store.getters.user;
    }
    get profilePicture() {
        return this.$store.getters.profilePicture;
    }
    created() {
        this.toggleContentHeader(false);
        this.loadInfo = "0/2 Fetching classroom.";
        this.findClassroomByID(this.$route.params.id)
            .then((result: Models.Classroom) => {
                return result;
            })
            .catch(() => {
                return Axios.get(`classrooms/${this.$route.params.id}`).then(
                    (response: AxiosResponse) =>
                        new Models.Classroom(response.data)
                );
            })
            .then((classroom: Models.Classroom) => {
                this.classroom = classroom;
                this.loadInfo = "1/2 Loading classroom's data.";
                return Axios.get(`/posts?classroom_id=${classroom.id}`);
            })
            .then((response: AxiosResponse) => response.data)
            .then((data: PostCollection) => {
                const posts = new PostCollection(data);
                this.posts = posts.data;
                delete posts.data;
                this.pagination = posts;
                this.loaded = true;
            })
            .catch((error: AxiosError) => {
                this.loaded = true;
                this.error = true;
                this.classroom = null;
                if (error.response && error.response.status === 500) {
                    this.is500 = true;
                } else if (error.response && error.response.status === 404) {
                    this.is404 = true;
                }
            });
    }
    initSearch(query: string) {
        console.log(query);
    }
    beforeRouteLeave(to: Route, from: Route, next: NavigationGuardNext) {
        this.toggleContentHeader(true);
        next();
    }
}
</script>

<style lang="scss">
.card {
    max-width: none !important;
    max-height: none !important;
}
</style>
