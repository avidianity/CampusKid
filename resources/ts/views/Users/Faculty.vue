<template>
    <div class="container-fluid">
        <div v-if="!loaded">
            <h4 class="d-inline">Loading...</h4>
            <i class="fas fa-circle-notch fa-spin"></i>
        </div>
        <error v-if="error"></error>
        <app-table
            v-if="loaded && !error"
            :title="'Faculties'"
            @search="initSearch"
        >
            <template v-slot:buttons>
                <router-link
                    to="/dashboard/users/faculty/add"
                    class="btn btn-tool"
                    tag="button"
                    title="Add Faculty"
                >
                    <i class="fas fa-user-tie"></i>
                </router-link>
            </template>
            <template v-slot:headers>
                <th>ID</th>
                <th>UID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Occupation</th>
                <th>Department</th>
                <th class="text-center" colspan="3">Actions</th>
            </template>
            <template v-slot:body>
                <tr v-for="(faculty, index) in faculties" :key="index">
                    <td>{{ faculty.id }}</td>
                    <td>{{ faculty.user.id }}</td>
                    <td>
                        <img
                            :src="faculty.avatar.url"
                            alt=""
                            :class="faculty.avatar.class"
                        />
                        {{ faculty.avatar.name }}
                    </td>
                    <td>
                        {{ faculty.email }}
                    </td>
                    <td>
                        {{ faculty.occupation_name }}
                    </td>
                    <td>
                        {{ faculty.department_name }}
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
                            :title="`${faculty.user.username}'s Details`"
                        >
                            <template v-slot:name>
                                <i class="fas fa-info-circle"></i>
                                View
                            </template>
                            <template v-slot:body>
                                <div
                                    class="container-fluid"
                                    v-if="faculty.user.detail"
                                >
                                    <label for="first_name">First Name:</label>
                                    <p id="first_name">
                                        {{ faculty.user.detail.first_name }}
                                    </p>
                                    <label for="last_name">Last Name:</label>
                                    <p id="last_name">
                                        {{ faculty.user.detail.last_name }}
                                    </p>
                                    <label for="gender">Gender:</label>
                                    <p id="gender">
                                        {{ faculty.user.detail.gender }}
                                    </p>
                                    <label for="birthday">Birthday:</label>
                                    <p id="birthday">
                                        {{
                                            faculty.user.detail.birthday.format(
                                                "F j, Y"
                                            )
                                        }}
                                    </p>
                                    <label for="address">Address:</label>
                                    <p id="address">
                                        {{ faculty.user.detail.address }}
                                    </p>
                                </div>
                                <div class="container" v-else>
                                    <p>
                                        <b>{{ faculty.user.username }}</b> has
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
import { Faculty, User, Occupation, Department } from "@classes/Models/index";
import { FacultyCollection } from "@classes/Collections/index";

@Component({
    components: {
        appTable: TableComponent,
        pagination: Pagination,
        error: D500,
        modal: Modal
    }
})
export default class FacultyComponent extends Vue {
    faculties: Array<Faculty> = [];
    pagination = {};
    loaded = false;
    error = false;
    created() {
        this.navigate("/faculties");
    }
    navigate(url: string) {
        Axios.get(url)
            .then(response => response.data)
            .then((collection: FacultyCollection) => {
                collection = new FacultyCollection(collection);
                this.faculties = collection.data.map(faculty => {
                    const user = faculty.user as User;
                    const occupation = faculty.occupation as Occupation;
                    const department = faculty.department as Department;
                    faculty.avatar = {
                        url: user.profile_picture
                            ? user.profile_picture.url
                            : "https://i.pravatar.cc/128",
                        class: "img-circle img-size-32 mr-2",
                        name: user.username
                    };
                    faculty.email = user.email;
                    faculty.occupation_name = occupation.name;
                    faculty.department_name = department.abbreviation;
                    return faculty;
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
