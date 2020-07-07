<template>
    <div class="col-sm-12 col-md-3">
        <div class="card">
            <div class="card-body">
                <ul class="nav nav-pills flex-column">
                    <li class="nav-item">
                        <a
                            class="nav-link active"
                            href="#posts"
                            data-toggle="tab"
                        >
                            <i class="fas fa-map-pin"></i>
                            Posts
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#members" data-toggle="tab">
                            <i class="fas fa-users"></i>
                            Members
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#tasks" data-toggle="tab">
                            <i class="fas fa-pencil-ruler"></i>
                            Tasks
                        </a>
                    </li>
                    <li v-if="!self.isAdministrator() && classrooms.length > 1" class="nav-item dropdown">
                        <a 
                            href="#" 
                            class="nav-link dropdown-toggle"
                            data-toggle="dropdown"
                            role="button"
                            aria-haspopup="true"
                            aria-expanded="false"
                        >
                            Classrooms
                        </a>
                        <div class="dropdown-menu">
                            <router-link
                                class="dropdown-item"
                                v-for="(classroom, index) in classrooms"
                                :key="index"
                                :to="`/dashboard/classrooms/${classroom.id}`"
                            >
                                {{ classroom.name }}
                            </router-link> 
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import Vue from "vue";
import Component from "vue-class-component";
import { AxiosError } from 'axios';
import { Action } from 'vuex-class';

import { ClassroomCollection } from '@classes/Collections';
import { Classroom } from '@classes/Models';

@Component
export default class TabPillComponent extends Vue {
    @Action fetchClassrooms: any;
    classrooms: Array<Classroom> = [];
    created() {
        this.fetchClassrooms()
            .then((classrooms: ClassroomCollection) => {
                this.classrooms = classrooms.data;
            })
            .catch((error: AxiosError) => {
                console.log(error.toJSON ? error.toJSON() : error);
                toastr.info('Your other classrooms could not be loaded at this moment. Please try again later.');
            })
    }
    get self() {
        return this.$store.getters.user;
    }
}
</script>

<style lang="scss"></style>
