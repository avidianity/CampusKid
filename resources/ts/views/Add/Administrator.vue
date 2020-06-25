<template>
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-6 col-lg-4">
                <form-input
                    id="email"
                    :title="'Email'"
                    :type="'email'"
                    v-model="form.email"
                    :messager="messagers.email"
                ></form-input>
                <form-input
                    id="username"
                    :title="'Username'"
                    :type="'text'"
                    v-model="form.username"
                    :messager="messagers.username"
                ></form-input>
                <form-input
                    id="password"
                    :title="'Password'"
                    :type="'password'"
                    v-model="form.password"
                    :messager="messagers.password"
                    @keyup.enter.native="submit()"
                ></form-input>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-4">
                <form-input
                    id="first_name"
                    :title="'First Name'"
                    :type="'text'"
                    v-model="form.detail.first_name"
                    :messager="messagers['detail.first_name']"
                ></form-input>
                <form-input
                    id="last_name"
                    :title="'Last Name'"
                    :type="'text'"
                    v-model="form.detail.last_name"
                    :messager="messagers['detail.last_name']"
                ></form-input>
                <form-select
                    id="gender"
                    :title="'Gender'"
                    :options="['Male', 'Female']"
                    v-model="form.detail.gender"
                    :messager="messagers['detail.gender']"
                ></form-select>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-4">
                <form-input
                    id="birthday"
                    :title="'Birthday'"
                    :type="'date'"
                    v-model="form.detail.birthday"
                    :messager="messagers['detail.birthday']"
                ></form-input>
                <form-input
                    id="address"
                    :title="'Address'"
                    :type="'text'"
                    v-model="form.detail.address"
                    :messager="messagers['detail.address']"
                ></form-input>
                <form-select
                    id="occupation"
                    :title="'Occupation'"
                    :options="occupations"
                    v-model="form.occupation_id"
                    :messager="messagers.occupation_id"
                ></form-select>
            </div>
            <div class="col-12 mt-2">
                <button
                    type="submit"
                    class="btn btn-emperor btn-sm btn-flat"
                    @click.prevent.stop="submit()"
                    :disabled="processing"
                    :class="{ disabled: processing }"
                >
                    {{ processing ? "Processing..." : "Submit" }}
                    <i
                        class="fas fa-circle-notch fa-spin"
                        v-if="processing"
                    ></i>
                </button>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import Vue from "vue";
import Component from "vue-class-component";

import Input from "@components/Forms/Input.vue";
import Select from "@components/Forms/Select.vue";

import {
    OccupationCollection,
    DepartmentCollection
} from "@classes/Collections";
import { ValidationMessage } from "@classes/FormValidation";

@Component({
    components: {
        formInput: Input,
        formSelect: Select
    }
})
export default class VueComponent extends Vue {
    processing = false;
    form = {
        detail: {
            first_name: "",
            last_name: "",
            gender: "Male",
            birthday: "1999-01-01",
            address: ""
        },
        occupation_id: "",
        email: "",
        username: "",
        password: ""
    };
    messagers = {
        ["detail.first_name" as string]: new ValidationMessage(),
        ["detail.last_name" as string]: new ValidationMessage(),
        ["detail.gender" as string]: new ValidationMessage(),
        ["detail.birthday" as string]: new ValidationMessage(),
        ["detail.address" as string]: new ValidationMessage(),
        ["department_id" as string]: new ValidationMessage(),
        ["email" as string]: new ValidationMessage(),
        ["username" as string]: new ValidationMessage(),
        ["password" as string]: new ValidationMessage(
            "Password must be atleast 6 characters."
        )
    };
    get occupations() {
        return (this.$store.getters
            .occupations as OccupationCollection).data.map(occupation => {
            return {
                name: occupation.name,
                value: occupation.id
            };
        });
    }
    created() {
        this.form.occupation_id = String(
            (this.$store.getters.occupations as OccupationCollection).data
                .length > 0
                ? (this.$store.getters.occupations as OccupationCollection)
                      .data[0].id
                : 1
        );
    }
    submit() {
        this.processing = true;
        Axios.post("/administrators", this.form)
            .then(response => response.data)
            .then(data => {
                this.processing = false;
                toastr.success(
                    `Administrator added successfully.`,
                    this.form.username
                );
                this.clear();
            })
            .catch(error => {
                this.processing = false;
                if (error.response && error.response.status === 422) {
                    toastr.error("Oops! You are missing some fields.", "422", {
                        progressBar: true
                    });
                    for (const key in error.response.data.errors) {
                        for (const message of error.response.data.errors[key]) {
                            this.messagers[key].clear();
                            this.messagers[key].timeout(message, "danger");
                        }
                    }
                } else if (error.response) {
                    toastr.error(
                        "Oops! Something went wrong. Please try again later.",
                        error.response.status,
                        { progressBar: true }
                    );
                } else {
                    toastr.error(
                        "Oops! Something went wrong. Please try again later.",
                        "Error",
                        { progressBar: true }
                    );
                    console.log("Error", error.toJSON ? error.toJSON() : error);
                }
            });
    }
    clear() {
        this.form = {
            detail: {
                first_name: "",
                last_name: "",
                gender: "Male",
                birthday: "1999-01-01",
                address: ""
            },
            occupation_id: this.form.occupation_id,
            email: "",
            username: "",
            password: ""
        };
    }
}
</script>

<style lang="scss"></style>
