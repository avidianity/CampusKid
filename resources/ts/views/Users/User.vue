<template>
    <div class="container-fluid">
        <div v-if="!loaded">
            <h4 class="d-inline">Loading...</h4>
            <i class="fas fa-circle-notch fa-spin"></i>
        </div>
        <error v-if="error"></error>
        <app-table
            v-if="loaded && !error"
            :title="'Users'"
            @search="initSearch"
        >
            <template v-slot:buttons>
                <router-link
                    to="/dashboard/users/administrator/add"
                    class="btn btn-tool"
                    tag="button"
                    title="Add Administrator"
                >
                    <i class="fas fa-user-lock"></i>
                </router-link>
                <router-link
                    to="/dashboard/users/faculty/add"
                    class="btn btn-tool"
                    tag="button"
                    title="Add Faculty"
                >
                    <i class="fas fa-user-tie"></i>
                </router-link>
                <router-link
                    to="/dashboard/users/student/add"
                    class="btn btn-tool"
                    tag="button"
                    title="Add Student"
                >
                    <i class="fas fa-user-graduate"></i>
                </router-link>
            </template>
            <template v-slot:headers>
                <th>ID.</th>
                <th>Username</th>
                <th>Email</th>
                <th>Type</th>
                <th class="text-center" colspan="3">Actions</th>
            </template>
            <template v-slot:body>
                <tr v-for="(user, index) in users" :key="index">
                    <td>{{ user.id }}</td>
                    <td>
                        <img
                            :src="user.avatar.url"
                            alt=""
                            :class="user.avatar.class"
                        />
                        {{ user.avatar.name }}
                    </td>
                    <td>
                        {{ user.email }}
                    </td>
                    <td>
                        <span :class="user.type.class">
                            <i :class="user.type.icon"></i>
                            {{ user.type.name }}
                        </span>
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
                            :title="`${user.username}'s Details`"
                        >
                            <template v-slot:name>
                                <i class="fas fa-info-circle"></i>
                                View
                            </template>
                            <template v-slot:body>
                                <div class="container-fluid" v-if="user.detail">
                                    <label for="first_name">First Name:</label>
                                    <p id="first_name">
                                        {{ user.detail.first_name }}
                                    </p>
                                    <label for="last_name">Last Name:</label>
                                    <p id="last_name">
                                        {{ user.detail.last_name }}
                                    </p>
                                    <label for="gender">Gender:</label>
                                    <p id="gender">
                                        {{ user.detail.gender }}
                                    </p>
                                    <label for="birthday">Birthday:</label>
                                    <p id="birthday">
                                        {{
                                            user.detail.birthday.format(
                                                "F j, Y"
                                            )
                                        }}
                                    </p>
                                    <label for="address">Address:</label>
                                    <p id="address">
                                        {{ user.detail.address }}
                                    </p>
                                </div>
                                <div class="container" v-else>
                                    <p>
                                        <b>{{ user.username }}</b> has not added
                                        details yet.
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
import { User, File } from "@classes/Models/index";
import { UserCollection } from "@classes/Collections/index";

@Component({
    components: {
        appTable: TableComponent,
        pagination: Pagination,
        error: D500,
        modal: Modal
    }
})
export default class UserComponent extends Vue {
    users: Array<User> = [];
    pagination = {};
    loaded = false;
    error = false;
    created() {
        this.navigate("/users");
    }
    navigate(url: string) {
        Axios.get(url)
            .then(response => response.data)
            .then((collection: UserCollection) => {
                collection = new UserCollection(collection);
                this.users = collection.data.map(user => {
                    if (user.isAdministrator()) {
                        user.type = {
                            class: {
                                badge: true,
                                "badge-primary": true
                            },
                            icon: {
                                fas: true,
                                "fa-user-lock": true
                            },
                            name: user.access_level
                        };
                    } else if (user.isFaculty()) {
                        user.type = {
                            class: {
                                badge: true,
                                "badge-warning": true
                            },
                            icon: {
                                fas: true,
                                "fa-user-tie": true
                            },
                            name: user.access_level
                        };
                    } else if (user.isStudent()) {
                        user.type = {
                            class: {
                                badge: true,
                                "badge-success": true
                            },
                            icon: {
                                fas: true,
                                "fa-user-graduate": true
                            },
                            name: user.access_level
                        };
                    }
                    user.avatar = {
                        url: user.profile_picture
                            ? user.profile_picture.url
                            : "https://i.pravatar.cc/128",
                        class: "img-circle img-size-32 mr-2",
                        name: user.username
                    };
                    return user;
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
