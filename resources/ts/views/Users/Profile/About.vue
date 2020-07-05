<template>
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">About</h3>
        </div>
        <div class="card-body">
            <strong v-if="!user.isAdministrator()">
                <i class="fas fa-building mr-1"></i>
                Department
            </strong>
            <p class="text-muted" v-if="!user.isAdministrator()">
                {{ user.role.department.name }}
            </p>
            <strong v-if="!user.isStudent()">
                <i class="fas fa-briefcase mr-1"></i>
                Occupation
            </strong>
            <p class="text-muted" v-if="!user.isStudent()">
                {{ user.role.occupation.name }}
            </p>
            <hr />
            <strong>
                <i class="fas fa-map-marker-alt mr-1"></i>
                Location
            </strong>
            <p class="text-muted">
                {{ user.detail.address }}
            </p>
            <ul class="list-group list-group-unbordered mb-3">
                <li class="list-group-item">
                    <b class="lato-light">Followers</b>
                    <a class="float-right">
                        0
                    </a>
                </li>
                <li class="list-group-item">
                    <b class="lato-light">Following</b>
                    <a class="float-right">
                        0
                    </a>
                </li>
                <li class="list-group-item">
                    <b class="lato-light">Classes</b>
                    <a class="float-right">
                        0
                    </a>
                </li>
            </ul>
        </div>
    </div>
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
export default class ProfileAboutComponent extends Vue {}
</script>

<style lang="scss"></style>
