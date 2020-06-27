<template>
    <div class="col-12">
        <div
            class="card card-primary card-outline"
            :style="{
                background:
                    classroom && classroom.cover_photo
                        ? classroom.cover_photo.url
                        : 'url(\'https://via.placeholder.com/1000\') center center',
                'background-repeat': 'no-repeat',
                backgroundSize: '100%'
            }"
        >
            <div class="card-body box-profile">
                <div class="mb-3">
                    <img
                        class="profile-user-img img-fluid img-circle"
                        :src="
                            classroom && classroom.profile_picture
                                ? classroom.profile_picture.url
                                : 'https://via.placeholder.com/128'
                        "
                        alt="Classroom Profile Picture"
                    />
                </div>
                <div class="mb-2">
                    <h3 class="profile-username p-1 rounded d-inline">
                        {{ classroom.name }}
                    </h3>
                </div>
                <div class="my-2">
                    <p class="text-muted p-1 rounded d-inline">
                        {{ classroom.subject.name }}
                    </p>
                </div>
                <div class="my-2">
                    <p class="text-muted p-1 rounded d-inline">
                        {{ classroom.faculty.user.detail.last_name }},
                        {{ classroom.faculty.user.detail.first_name }} -
                        {{ classroom.faculty.occupation.name }}
                    </p>
                </div>
                <div class="my-2">
                    <p class="text-muted p-1 rounded d-inline">
                        {{ classroom.department.name }}
                    </p>
                </div>
                <div class="mt-2" v-if="classroom.description">
                    <p class="text-muted p-1 rounded d-inline">
                        {{ classroom.description }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import ParentVue from "vue";
import Component from "vue-class-component";

import { Classroom } from "@classes/Models";

const Vue = ParentVue.extend({
    props: {
        classroom: Classroom
    }
});

@Component
export default class VueComponent extends Vue {}
</script>

<style lang="scss"></style>
