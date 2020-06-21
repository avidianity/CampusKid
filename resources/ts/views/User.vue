<template>
    <div class="container-fluid">
        <div v-if="!loaded">
            <h4 class="d-inline">Loading...</h4>
            <i class="fas fa-circle-notch fa-spin"></i>
        </div>
        <div v-if="error">
            <i class="fas fa-exclamation-triangle text-warning fa-2x"></i>
            <h4 class="d-inline">Error</h4>
            <p class="d-block">
                Something went wrong. Please come back later.
            </p>
        </div>
        <app-table
            v-if="loaded && !error"
            :title="'Users'"
            :headers="['#', 'Username', 'Email', 'Type']"
            :data="users"
            :keys="['id', 'avatar', 'email', 'type']"
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
import { User, File } from "@classes/Models/index";
import { UserCollection } from "@classes/Collections/index";
import Pagination from "@components/Pagination.vue";

@Component({
    components: {
        appTable: TableComponent,
        pagination: Pagination
    }
})
export default class UserComponent extends Vue {
    users: Array<User> = [];
    pagination = {};
    loaded = false;
    error = false;
    created() {
        Axios.get("/users")
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
                            name: user.access_level,
                            type: "badge"
                        };
                    } else if (user.isFaculty()) {
                        user.type = {
                            class: {
                                badge: true,
                                "badge-warning text-light": true
                            },
                            name: user.access_level,
                            type: "badge"
                        };
                    } else if (user.isStudent()) {
                        user.type = {
                            class: {
                                badge: true,
                                "badge-success": true
                            },
                            name: user.access_level,
                            type: "badge"
                        };
                    }
                    user.avatar = {
                        url: user.profile_picture
                            ? user.profile_picture.url
                            : "https://via.placeholder.com/128",
                        class: "img-circle img-size-32 mr-2",
                        name: user.username,
                        type: "image"
                    };
                    return user;
                });
                delete collection.data;
                this.pagination = collection;
                this.loaded = true;
            })
            .catch(error => {
                console.log(error);
                this.loaded = true;
                this.error = true;
            });
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
                            name: user.access_level,
                            type: "badge"
                        };
                    } else if (user.isFaculty()) {
                        user.type = {
                            class: {
                                badge: true,
                                "badge-warning text-light": true
                            },
                            name: user.access_level,
                            type: "badge"
                        };
                    } else if (user.isStudent()) {
                        user.type = {
                            class: {
                                badge: true,
                                "badge-success": true
                            },
                            name: user.access_level,
                            type: "badge"
                        };
                    }
                    user.avatar = {
                        url: user.profile_picture
                            ? user.profile_picture.url
                            : "https://via.placeholder.com/128",
                        class: "img-circle img-size-32 mr-2",
                        name: user.username,
                        type: "image"
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
