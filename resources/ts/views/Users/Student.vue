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
                    to="/dashboard/users/add/student"
                    class="btn btn-tool"
                    tag="button"
                    title="Add Student"
                >
                    <i class="fas fa-user-graduate"></i>
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
                            :title="`${student.user.username}'s Details`"
                        >
                            <template v-slot:name>
                                <i class="fas fa-info-circle"></i>
                                View
                            </template>
                            <template v-slot:body>
                                <div
                                    class="container-fluid text-left"
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
                                <div class="container text-left" v-else>
                                    <p>
                                        <b>{{ student.user.username }}</b> has
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
                            :title="`Edit ${student.user.username}`"
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
                                                :id="student.id"
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
                                                :id="student.id"
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
                                                :id="student.id"
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
                                                :id="student.id"
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
                                                :id="student.id"
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
                                                :id="student.id"
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
                                                :id="student.id"
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
                                                :id="student.id"
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
                                            <form-input
                                                :id="student.id"
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
                                                :id="student.id"
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
import { Student, User, Department, Detail } from "@classes/Models/index";
import {
    StudentCollection,
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
export default class StudentComponent extends Vue {
    forms = Array<object>();
    students: Array<Student> = [];
    pagination = {};
    loaded = false;
    error = false;
    get self() {
        return this.$store.getters.user;
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
        this.navigate("/students");
    }
    submit(index: number) {
        (this.forms[index] as any).processing = true;
        const form = this.forms[index] as any;
        const user = this.students[index].user as User;

        const requests = [];
        const credentials = {
            email: user.email,
            username: user.username,
            password: form.confirm
        };

        requests.push(
            Axios.put(`/other/student/${user.role_id}`, {
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
            .then((collection: StudentCollection) => {
                collection = new StudentCollection(collection);
                this.students = collection.data.map(student => {
                    const user = student.user as User;
                    const department = student.department as Department;
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
                        department_id: department.id,
                        confirm: "",
                        processing: false,
                        passwordMessager
                    });
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
