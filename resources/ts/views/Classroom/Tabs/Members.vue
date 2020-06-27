<template>
    <div class="tab-pane" id="members">
        <div class="card">
            <div class="card-body">
                <h3>Teacher</h3>
                <div class="list-group">
                    <a href="#" class="list-group-item list-group-item-action">
                        <img
                            :src="
                                classroom.faculty.user.profile_picture
                                    ? clasroom.faculty.user.profile_picture.url
                                    : 'https://via.placeholder.com/128'
                            "
                            alt=""
                            class="img-fluid img-circle img-sm mr-2"
                        />
                        <div class="pt-1">
                            {{ classroom.faculty.user.detail.first_name }}
                            {{ classroom.faculty.user.detail.last_name }}
                        </div>
                    </a>
                </div>
                <h3 class="mt-1">Students</h3>
                <div class="list-group">
                    <a
                        href="#"
                        class="list-group-item list-group-item-action"
                        v-for="(student, index) in classroom.students"
                        :key="index"
                    >
                        <img
                            :src="
                                student.user.profile_picture
                                    ? student.user.profile_picture.url
                                    : 'https://via.placeholder.com/128'
                            "
                            alt=""
                            class="img-fluid img-circle img-sm mr-2"
                        />
                        <div class="pt-1">
                            {{ student.user.detail.first_name }}
                            {{ student.user.detail.last_name }}
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import ParentVue from "vue";
import Component from "vue-class-component";
import { Classroom } from "@classes/Models";

const Vue = ParentVue.extend({
    props: {
        classroom: Classroom
    }
});

@Component
export default class VueComponent extends Vue {}
</script>

<style lang="scss"></style>
