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
                    to="/dashboard/users/add/faculty"
                    class="btn btn-tool"
                    tag="button"
                    title="Add Faculty"
                    v-if="self.isAdministrator()"
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
                    <td :class="{
                        'text-right': self.isAdministrator()
                    }">
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
                                    class="container-fluid text-left"
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
                                <div class="container text-left" v-else>
                                    <p>
                                        <b>{{ faculty.user.username }}</b> has
                                        not added details yet.
                                    </p>
                                </div>
                            </template>
                        </modal>
                    </td>
                    <td class="text-center" v-if="self.isAdministrator()">
                        <modal
                            :id="`edit${index}`"
                            :classes="[
                                'btn',
                                'btn-warning',
                                'btn-sm',
                                'btn-flat'
                            ]"
                            :size="'large'"
                            :title="`Edit ${faculty.user.username}`"
                        >
                            <template v-slot:name>
                                <i class="fas fa-user-edit"></i>
                                Edit
                            </template>
                            <template v-slot:body>
                                <div class="container-fluid text-left">
                                    <p class="text-muted">
                                        All of the fields are optional. Only
                                        change what needs to be changed.
                                    </p>
                                    <div class="row">
                                        <div
                                            class="col-sm-12 col-md-6 col-lg-4"
                                        >
                                            <form-input
                                                :id="faculty.id"
                                                :title="'Email'"
                                                :type="'email'"
                                                v-model="
                                                    forms[index].user.email
                                                "
                                            ></form-input>
                                        </div>
                                        <div
                                            class="col-sm-12 col-md-6 col-lg-4"
                                        >
                                            <form-input
                                                :id="faculty.id"
                                                :title="'Username'"
                                                :type="'text'"
                                                v-model="
                                                    forms[index].user.username
                                                "
                                            ></form-input>
                                        </div>
                                        <div
                                            class="col-sm-12 col-md-6 col-lg-4"
                                        >
                                            <form-input
                                                :id="faculty.id"
                                                :title="'First Name'"
                                                :type="'text'"
                                                v-model="
                                                    forms[index].detail
                                                        .first_name
                                                "
                                            ></form-input>
                                        </div>
                                        <div
                                            class="col-sm-12 col-md-6 col-lg-4"
                                        >
                                            <form-input
                                                :id="faculty.id"
                                                :title="'Last Name'"
                                                :type="'text'"
                                                v-model="
                                                    forms[index].detail
                                                        .last_name
                                                "
                                            ></form-input>
                                        </div>
                                        <div
                                            class="col-sm-12 col-md-6 col-lg-4"
                                        >
                                            <form-input
                                                :id="faculty.id"
                                                :title="'Birthday'"
                                                :type="'date'"
                                                v-model="
                                                    forms[index].detail.birthday
                                                "
                                            ></form-input>
                                        </div>
                                        <div
                                            class="col-sm-12 col-md-6 col-lg-4"
                                        >
                                            <form-input
                                                :id="faculty.id"
                                                :title="'Address'"
                                                :type="'text'"
                                                v-model="
                                                    forms[index].detail.address
                                                "
                                            ></form-input>
                                        </div>
                                        <div
                                            class="col-sm-12 col-md-6 col-lg-4"
                                        >
                                            <form-select
                                                :id="faculty.id"
                                                :title="'Gender'"
                                                :options="['Male', 'Female']"
                                                v-model="
                                                    forms[index].detail.gender
                                                "
                                            ></form-select>
                                        </div>
                                        <div
                                            class="col-sm-12 col-md-6 col-lg-4"
                                        >
                                            <form-select
                                                :id="faculty.id"
                                                :title="'Department'"
                                                :options="departments"
                                                v-model="
                                                    forms[index].department_id
                                                "
                                            ></form-select>
                                        </div>
                                        <div
                                            class="col-sm-12 col-md-6 col-lg-4"
                                        >
                                            <form-select
                                                :id="faculty.id"
                                                :title="'Occupation'"
                                                :options="occupations"
                                                v-model="
                                                    forms[index].occupation_id
                                                "
                                            ></form-select>
                                        </div>
                                        <div
                                            class="col-sm-12 col-md-6 col-lg-4"
                                        >
                                            <form-input
                                                :id="faculty.id"
                                                :title="'New Password'"
                                                :type="'password'"
                                                v-model="
                                                    forms[index].user.password
                                                "
                                            ></form-input>
                                        </div>
                                    </div>
                                    <hr />
                                    <div class="row">
                                        <div
                                            class="col-sm-12 col-md-6 col-lg-4"
                                        >
                                            <form-input
                                                :id="faculty.id"
                                                :title="'Confirm Password'"
                                                :type="'password'"
                                                :messager="
                                                    forms[index]
                                                        .passwordMessager
                                                "
                                                v-on:keyup.enter.native="
                                                    submit(index)
                                                "
                                                v-model="forms[index].confirm"
                                            ></form-input>
                                        </div>
                                    </div>
                                </div>
                            </template>
                            <template v-slot:footer>
                                <button
                                    class="btn btn-cutty-sark btn-sm btn-flat ml-auto mr-1"
                                    @click.prevent.stop="submit(index)"
                                    :disabled="forms[index].processing"
                                    :class="{
                                        disabled: forms[index].processing
                                    }"
                                >
                                    {{
                                        forms[index].processing
                                            ? "Saving"
                                            : "Save"
                                    }}
                                    <i
                                        class="fas fa-circle-notch fa-spin"
                                        v-if="forms[index].processing"
                                    ></i>
                                </button>
                            </template>
                        </modal>
                    </td>
                    <td class="text-left" v-if="self.isAdministrator()">
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
import Input from "@components/Forms/Input.vue";
import Select from "@components/Forms/Select.vue";
import D500 from "@components/Dashboard500.vue";
import {
    Faculty,
    User,
    Occupation,
    Department,
    Detail
} from "@classes/Models/index";
import {
    FacultyCollection,
    OccupationCollection,
    DepartmentCollection
} from "@classes/Collections/index";
import { ValidationMessage } from "@classes/FormValidation";

@Component({
    components: {
        appTable: TableComponent,
        pagination: Pagination,
        error: D500,
        modal: Modal,
        formInput: Input,
        formSelect: Select
    }
})
export default class FacultyComponent extends Vue {
    forms = Array<object>();
    faculties: Array<Faculty> = [];
    pagination = {};
    loaded = false;
    error = false;
    get self() {
        return this.$store.getters.user;
    }
    get occupations() {
        return this.$store.getters.occupations.data
            ? this.$store.getters.occupations.data.map(
                  (occupation: Occupation) => {
                      return {
                          name: occupation.name,
                          value: occupation.id as number
                      };
                  }
              )
            : Session.get("occupations").data.map((occupation: Occupation) => {
                  return {
                      name: occupation.name,
                      value: occupation.id as number
                  };
              });
    }
    get departments() {
        return this.$store.getters.departments.data
            ? this.$store.getters.departments.data.map(
                  (department: Department) => {
                      return {
                          name: department.name,
                          value: department.id as number
                      };
                  }
              )
            : Session.get("departments").data.map((department: Department) => {
                  return {
                      name: department.name,
                      value: department.id as number
                  };
              });
    }
    created() {
        this.navigate("/faculties");
    }
    submit(index: number) {
        (this.forms[index] as any).processing = true;
        const form = this.forms[index] as any;
        const user = this.faculties[index].user as User;

        const requests = [];
        const credentials = {
            email: user.email,
            username: user.username,
            password: form.confirm
        };

        requests.push(
            Axios.put(`/other/faculty/${user.role_id}`, {
                occupation_id: form.occupation_id,
                credentials
            })
        );

        requests.push(
            user.detail
                ? Axios.put(
                      `/other/detail/${(user.detail as Detail).id as number}`,
                      {
                          ...form.detail,
                          credentials
                      }
                  )
                : Axios.post(`/other/detail`, {
                      ...form.detail,
                      credentials
                  })
        );

        requests.push(
            Axios.put(`/other/user/${user.id}`, {
                ...form.user,
                credentials
            })
        );

        Promise.all(requests)
            .then(responses => {
                (this.forms[index] as any).confirm = "";
                (this.forms[index] as any).processing = false;
                toastr.success(
                    `${user.username} edited successfully.`,
                    `${form.detail.first_name} ${form.detail.last_name}`
                );
                this.navigate(Session.get("current-nav-url"));
            })
            .catch(error => {
                (this.forms[index] as any).confirm = "";
                (this.forms[index] as any).processing = false;
                if (form.confirm.length === 0) {
                    (this.forms[index] as any).passwordMessager.clear();
                    (this.forms[index] as any).passwordMessager.danger(
                        "You must provide a password."
                    );
                    setTimeout(() => {
                        (this.forms[index] as any).passwordMessager.clear();
                        (this.forms[index] as any).passwordMessager.normal(
                            "We require you to provide the current password to determine that you have permission from the owner of this account."
                        );
                        (this.forms[index] as any).passwordMessager.addClass(
                            "text-wrap"
                        );
                    }, 5000);
                }
                if (error.response && error.response.data.errors) {
                    error.response.data.errors.map((error: string) => {
                        toastr.error(error, "Error", {
                            progressBar: true
                        });
                    });
                } else if (error.response) {
                    toastr.error(
                        "Something went wrong. Please try again later.",
                        error.response.status
                    );
                } else {
                    toastr.warning("Something went wrong. Please try again.");
                }
            });
    }
    navigate(url: string) {
        Session.set("current-nav-url", url);
        Axios.get(url)
            .then(response => response.data)
            .then((collection: FacultyCollection) => {
                collection = new FacultyCollection(collection);
                this.faculties = collection.data.map(faculty => {
                    const user = faculty.user as User;
                    const occupation = faculty.occupation as Occupation;
                    const department = faculty.department as Department;
                    const passwordMessager = new ValidationMessage(
                        "We require you to provide the current password to determine that you have permission from the owner of this account."
                    );
                    passwordMessager.addClass("text-wrap");
                    this.forms.push({
                        user: {
                            email: user.email,
                            username: user.username,
                            password: ""
                        },
                        detail: user.detail
                            ? {
                                  first_name: user.detail.first_name,
                                  last_name: user.detail.last_name,
                                  gender: user.detail.gender,
                                  birthday: user.detail.birthday.format(
                                      "Y-m-d"
                                  ),
                                  address: user.detail.address
                              }
                            : {
                                  first_name: "",
                                  last_name: "",
                                  gender: "Male",
                                  birthday: "",
                                  address: ""
                              },
                        occupation_id: faculty.occupation_id,
                        department_id: department.id,
                        confirm: "",
                        processing: false,
                        passwordMessager
                    });
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
