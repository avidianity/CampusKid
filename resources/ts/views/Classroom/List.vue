<template>
    <div class="container-fluid">
        <div v-if="!loaded">
            <h4 class="d-inline">Loading...</h4>
            <i class="fas fa-circle-notch fa-spin"></i>
        </div>
        <error v-if="error"></error>
        <app-table
            v-if="loaded && !error"
            :title="'Classrooms'"
            @search="initSearch"
        >
            <template v-slot:buttons v-if="isFaculty">
                <router-link
                    to="/dashboard/classroom/add"
                    class="btn btn-tool"
                    tag="button"
                    title="Add Classroom"
                >
                    <i class="fas fa-chalkboard"></i>
                </router-link>
            </template>
            <template v-slot:headers>
                <th>ID</th>
                <th>Name</th>
                <th>Subject</th>
                <th>Faculty</th>
                <th>Department</th>
                <th class="text-center">Students</th>
                <th class="text-center">
                    Action
                </th>
            </template>
            <template v-slot:body>
                <tr v-for="(classroom, index) in classrooms" :key="index">
                    <td>{{ classroom.id }}</td>
                    <td>{{ classroom.name }}</td>
                    <td>{{ classroom.subject.name }}</td>
                    <td>
                        {{ classroom.faculty.user.detail.last_name }},
                        {{ classroom.faculty.user.detail.first_name }}
                    </td>
                    <td>{{ classroom.department.abbreviation }}</td>
                    <td class="text-center">{{ classroom.students.length }}</td>
                    <td class="text-center">
                        <router-link
                            :to="`/dashboard/classrooms/${classroom.id}`"
                            class="btn btn-primary btn-sm btn-flat"
                        >
                            <i class="fas fa-info-circle"></i>
                            View
                        </router-link>
                    </td>
                </tr>
            </template>
            <pagination
                :pagination="pagination"
                @navigation="navigate"
            ></pagination>
        </app-table>
    </div>
</template>

<script lang="ts">
import Vue from "vue";
import Component from "vue-class-component";
import { Action } from "vuex-class";

import Table from "@components/Table.vue";
import Pagination from "@components/Pagination.vue";
import D500 from "@components/Dashboard500.vue";

import { User, Classroom } from "@models/index";
import { ClassroomCollection } from "@classes/Collections";

@Component({
    components: {
        appTable: Table,
        Pagination,
        Error: D500
    }
})
export default class ClassroomListComponent extends Vue {
    @Action fetchClassrooms: any;
    pagination = {};
    classrooms: Array<Classroom> = [];
    loaded = false;
    error = false;
    created() {
        this.navigate("/classrooms");
    }
    get isFaculty(): boolean {
        return (Session.user() as User).isFaculty();
    }
    get getters() {
        return this.$store.getters;
    }
    navigate(url: string) {
        this.error = false;
        Session.set("current-nav-url", url);
        this.fetchClassrooms(url)
            .then((classrooms: ClassroomCollection) => {
                const data = classrooms.data;
                this.classrooms = data;
                delete classrooms.data;
                this.pagination = classrooms;
                this.loaded = true;
            })
            .catch((error: any) => {
                this.error = true;
                this.loaded = true;
                console.log(error);
            });
    }
    initSearch(query: string) {
        console.log(query);
    }
}
</script>
