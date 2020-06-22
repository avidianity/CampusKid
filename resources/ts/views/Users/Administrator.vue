<template>
    <div class="container-fluid">
        <div v-if="!loaded">
            <h4 class="d-inline">Loading...</h4>
            <i class="fas fa-circle-notch fa-spin"></i>
        </div>
        <error v-if="error"></error>
        <app-table
            v-if="loaded && !error"
            :title="'Administrators'"
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
            </template>
            <template v-slot:headers>
                <th>ID</th>
                <th>UID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Occupation</th>
                <th class="text-center" colspan="3">Actions</th>
            </template>
            <template v-slot:body>
                <tr v-for="(admin, index) in administrators" :key="index">
                    <td>{{ admin.id }}</td>
                    <td>{{ admin.user.id }}</td>
                    <td>
                        <img
                            :src="admin.avatar.url"
                            alt=""
                            :class="admin.avatar.class"
                        />
                        {{ admin.avatar.name }}
                    </td>
                    <td>
                        {{ admin.email }}
                    </td>
                    <td>
                        {{ admin.occupation_name }}
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
                            :title="`${admin.user.username}'s Details`"
                        >
                            <template v-slot:name>
                                <i class="fas fa-info-circle"></i>
                                View
                            </template>
                            <template v-slot:body>
                                <div
                                    class="container-fluid"
                                    v-if="admin.user.detail"
                                >
                                    <label for="first_name">First Name:</label>
                                    <p id="first_name">
                                        {{ admin.user.detail.first_name }}
                                    </p>
                                    <label for="last_name">Last Name:</label>
                                    <p id="last_name">
                                        {{ admin.user.detail.last_name }}
                                    </p>
                                    <label for="gender">Gender:</label>
                                    <p id="gender">
                                        {{ admin.user.detail.gender }}
                                    </p>
                                    <label for="birthday">Birthday:</label>
                                    <p id="birthday">
                                        {{
                                            admin.user.detail.birthday.format(
                                                "F j, Y"
                                            )
                                        }}
                                    </p>
                                    <label for="address">Address:</label>
                                    <p id="address">
                                        {{ admin.user.detail.address }}
                                    </p>
                                </div>
                                <div class="container" v-else>
                                    <p>
                                        <b>{{ admin.user.username }}</b> has not
                                        added details yet.
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
import { Administrator, User, Occupation } from "@classes/Models/index";
import { AdministratorCollection } from "@classes/Collections/index";

@Component({
    components: {
        appTable: TableComponent,
        pagination: Pagination,
        error: D500,
        modal: Modal
    }
})
export default class AdministratorComponent extends Vue {
    administrators: Array<Administrator> = [];
    pagination = {};
    loaded = false;
    error = false;
    created() {
        this.navigate("/administrators");
    }
    navigate(url: string) {
        Axios.get(url)
            .then(response => response.data)
            .then((collection: AdministratorCollection) => {
                collection = new AdministratorCollection(collection);
                this.administrators = collection.data.map(admin => {
                    const user = admin.user as User;
                    const occupation = admin.occupation as Occupation;
                    admin.avatar = {
                        url: user.profile_picture
                            ? user.profile_picture.url
                            : "https://i.pravatar.cc/128",
                        class: "img-circle img-size-32 mr-2",
                        name: user.username
                    };
                    admin.email = user.email;
                    admin.occupation_name = occupation.name;
                    return admin;
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
