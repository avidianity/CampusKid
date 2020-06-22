<template>
    <div class="container-fluid">
        <div v-if="!loaded">
            <h4 class="d-inline">Loading...</h4>
            <i class="fas fa-circle-notch fa-spin"></i>
        </div>
        <error v-if="error"></error>
        <app-table
            v-if="loaded && !error"
            :title="'students'"
            @search="initSearch"
        >
            <template v-slot:buttons>
                <router-link
                    to="/dashboard/users/Student/add"
                    class="btn btn-tool"
                    tag="button"
                    title="Add Student"
                >
                    <i class="fas fa-user-tie"></i>
                </router-link>
            </template>
            <template v-slot:headers>
                <th>ID</th>
                <th>UID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Department</th>
                <th>Classes</th>
                <th class="text-center" colspan="3">Actions</th>
            </template>
            <template v-slot:body>
                <tr v-for="(student, index) in students" :key="index">
                    <td>{{ student.id }}</td>
                    <td>{{ student.user.id }}</td>
                    <td>
                        <img
                            :src="student.avatar.url"
                            alt=""
                            :class="student.avatar.class"
                        />
                        {{ student.user.username }}
                    </td>
                    <td>
                        {{ student.user.email }}
                    </td>
                    <td>
                        {{ student.department_name }}
                    </td>
                    <td>
                        {{ student.classrooms.length }}
                    </td>
                    <td>
                        <modal
                            :id="index"
                            :classes="[
                                'btn',
                                'btn-primary',
                                'btn-sm',
                                'btn-flat'
                            ]"
                            :title="`${student.user.username}'s Details`"
                        >
                            <template v-slot:name>
                                <i class="fas fa-info-circle"></i>
                                View
                            </template>
                            <template v-slot:body>
                                <div
                                    class="container-fluid"
                                    v-if="student.user.detail"
                                >
                                    <label for="first_name">First Name:</label>
                                    <p id="first_name">
                                        {{ student.user.detail.first_name }}
                                    </p>
                                    <label for="last_name">Last Name:</label>
                                    <p id="last_name">
                                        {{ student.user.detail.last_name }}
                                    </p>
                                    <label for="gender">Gender:</label>
                                    <p id="gender">
                                        {{ student.user.detail.gender }}
                                    </p>
                                    <label for="birthday">Birthday:</label>
                                    <p id="birthday">
                                        {{
                                            student.user.detail.birthday.format(
                                                "F j, Y"
                                            )
                                        }}
                                    </p>
                                    <label for="address">Address:</label>
                                    <p id="address">
                                        {{ student.user.detail.address }}
                                    </p>
                                </div>
                                <div class="container" v-else>
                                    <p>
                                        <b>{{ student.user.username }}</b> has
                                        not added details yet.
                                    </p>
                                </div>
                            </template>
                        </modal>
                    </td>
                    <td>
                        <a href="" class="btn btn-warning btn-sm btn-flat">
                            <i class="fas fa-user-edit"></i>
                            Edit
                        </a>
                    </td>
                    <td>
                        <a href="" class="btn btn-danger btn-sm btn-flat">
                            <i class="fas fa-user-times"></i>
                            Delete
                        </a>
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

import TableComponent from "@components/Table.vue";
import Pagination from "@components/Pagination.vue";
import Modal from "@components/Modal.vue";
import D500 from "@components/Dashboard500.vue";
import { Student, User, Department } from "@classes/Models/index";
import { StudentCollection } from "@classes/Collections/index";

@Component({
    components: {
        appTable: TableComponent,
        pagination: Pagination,
        error: D500,
        modal: Modal
    }
})
export default class StudentComponent extends Vue {
    students: Array<Student> = [];
    pagination = {};
    loaded = false;
    error = false;
    created() {
        this.navigate("/students");
    }
    navigate(url: string) {
        Axios.get(url)
            .then(response => response.data)
            .then((collection: StudentCollection) => {
                collection = new StudentCollection(collection);
                this.students = collection.data.map(student => {
                    const user = student.user as User;
                    const department = student.department as Department;
                    student.avatar = {
                        url: user.profile_picture
                            ? user.profile_picture.url
                            : "https://i.pravatar.cc/128",
                        class: "img-circle img-size-32 mr-2"
                    };
                    student.email = user.email;
                    student.department_name = department.abbreviation;
                    return student;
                });
                delete collection.data;
                this.pagination = collection;
                this.loaded = true;
            })
            .catch(error => {
                this.loaded = true;
                this.error = true;
            });
    }
    initSearch(query: string) {
        console.log(query);
    }
}
</script>
