<template>
    <div class="container-fluid">
        <div v-if="!loaded && !error">
            <h4 class="d-inline">Loading...</h4>
            <i class="fas fa-circle-notch fa-spin"></i>
        </div>
        <error v-if="error"></error>
        <app-table
            v-if="loaded && !error"
            :title="'Subjects'"
            @search="initSearch"
        >
            <template v-slot:buttons>
                <router-link
                    to="/dashboard/add/subject"
                    class="btn btn-tool"
                    tag="button"
                    title="Add Subject"
                >
                    <i class="fas fa-book-open"></i>
                </router-link>
            </template>
            <template v-slot:headers>
                <th>ID</th>
                <th>Code</th>
                <th>Name</th>
                <th>Units</th>
                <th class="text-center">Classrooms</th>
                <th colspan="2" class="text-center">
                    Actions
                </th>
            </template>
            <template v-slot:body>
                <tr v-for="(subject, index) in subjects" :key="index">
                    <td>{{ subject.id }}</td>
                    <td>{{ subject.code }}</td>
                    <td>{{ subject.name }}</td>
                    <td>{{ subject.units }}</td>
                    <td class="text-center">
                        {{ subject.classrooms.length }}
                    </td>
                    <td class="text-right">
                        <modal
                            :id="`edit${index}`"
                            :classes="[
                                'btn',
                                'btn-warning',
                                'btn-sm',
                                'btn-flat'
                            ]"
                            :size="'medium'"
                            :title="`Edit ${subject.name}`"
                        >
                            <template v-slot:name>
                                <i class="fas fa-edit"></i>
                                Edit
                            </template>
                            <template v-slot:body>
                                <div class="container-fluid text-left">
                                    <div class="row">
                                        <div class="col-12">
                                            <form-input
                                                :id="subject.id"
                                                :title="'Name'"
                                                :type="'text'"
                                                v-model="forms[index].name"
                                                @keyup.enter.native="
                                                    submit(index)
                                                "
                                            ></form-input>
                                        </div>
                                        <div class="col-12">
                                            <form-input
                                                :id="subject.id"
                                                :title="'Description'"
                                                :type="'text'"
                                                v-model="
                                                    forms[index].description
                                                "
                                                @keyup.enter.native="
                                                    submit(index)
                                                "
                                            ></form-input>
                                        </div>
                                        <div class="col-12">
                                            <form-input
                                                :id="subject.id"
                                                :title="'Code'"
                                                :type="'text'"
                                                v-model="forms[index].code"
                                                @keyup.enter.native="
                                                    submit(index)
                                                "
                                            ></form-input>
                                        </div>
                                        <div class="col-12">
                                            <form-input
                                                :id="subject.id"
                                                :title="'Units'"
                                                :type="'number'"
                                                v-model="forms[index].units"
                                                @keyup.enter.native="
                                                    submit(index)
                                                "
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
                    <td class="text-left">
                        <a href="" class="btn btn-danger btn-sm btn-flat">
                            <i class="fas fa-times"></i>
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
import { Action } from "vuex-class";

import Table from "@components/Table.vue";
import Pagination from "@components/Pagination.vue";
import Modal from "@components/Modal.vue";
import Input from "@components/Forms/Input.vue";
import D500 from "@components/Dashboard500.vue";

import { Subject } from "@classes/Models";
import { SubjectCollection } from "@classes/Collections";

@Component({
    components: {
        appTable: Table,
        Pagination,
        Error: D500,
        modal: Modal,
        formInput: Input
    }
})
export default class SubjectComponent extends Vue {
    forms = Array<object>();
    @Action fetchSubjects: any;
    pagination = {};
    subjects: Array<Subject> = [];
    loaded = false;
    error = false;
    created() {
        this.navigate("/subjects");
    }
    submit(index: number) {
        (this.forms[index] as any).processing = true;
        const data = this.forms[index] as any;
        Axios.put(`/subjects/${data.id}`, data)
            .then(response => response.data)
            .then((data: Subject) => {
                (this.forms[index] as any).processing = false;
                toastr.success(`Subject edited successfully.`, `${data.name}`);
                this.navigate(Session.get("current-nav-url"));
            })
            .catch(error => {
                (this.forms[index] as any).processing = false;
                if (error.response) {
                    toastr.error(
                        "Something went wrong. Please try again.",
                        error.response.status
                    );
                } else {
                    toastr.error(
                        error.toJSON ? error.toJSON() : error,
                        "Error"
                    );
                }
            });
    }
    navigate(url: string) {
        this.error = false;
        Session.set("current-nav-url", url);
        this.fetchSubjects(url)
            .then((subjects: SubjectCollection) => {
                const data = subjects.data;
                data.forEach(subject => {
                    this.forms.push({
                        ...subject,
                        processing: false
                    });
                });
                this.subjects = data;
                delete subjects.data;
                this.pagination = subjects;
                this.loaded = true;
            })
            .catch((error: any) => {
                this.error = true;
                console.log(error);
            });
    }
    initSearch(query: string) {
        console.log(query);
    }
}
</script>
