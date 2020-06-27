<template>
    <div class="tab-pane" id="tasks">
        <div class="card" v-for="(task, index) in classroom.tasks" :key="index">
            <div class="card-body pb-0">
                <div class="post">
                    <div class="user-block ml-0">
                        <span class="username ml-0">
                            {{ task.name }}
                        </span>
                        <span class="description ml-0">
                            {{ task.updated_at.format("F d, Y - g:i A") }}
                        </span>
                    </div>
                    <p>
                        {{ task.description }}
                    </p>
                    <div class="my-2" v-if="task.files.length > 0">
                        <h4>Files</h4>
                        <a
                            v-for="(file, index) in task.files"
                            :key="index"
                            :href="file.url"
                            class="d-inline m-1"
                        >
                            {{ file.name }}
                        </a>
                    </div>
                    <p class="mb-1 d-flex">
                        <span class="mr-auto">
                            <a href="#" class="link-black text-sm">
                                <i class="fas fa-calendar-alt mr-1"></i>
                                Deadline:
                                {{ task.deadline.format("F d, Y g:i A") }}
                            </a>
                        </span>
                        <span class="ml-auto">
                            <a href="#" class="link-black text-sm">
                                <i class="fas fa-file mr-1"></i>
                                Submissions({{ task.submissions.length }})
                            </a>
                            <a
                                href="#"
                                class="link-black text-sm ml-1"
                                v-if="task.comments.length > 0"
                            >
                                <i class="far fa-comments mr-1"></i>
                                Comments ({{ task.comments.length }})
                            </a>
                        </span>
                    </p>
                </div>
            </div>
            <div
                class="card-footer card-comments"
                v-if="task.comments.length > 0"
            >
                <div
                    class="card-comment"
                    v-for="(comment, index) in task.comments"
                    :key="index"
                >
                    <img
                        class="img-circle img-sm"
                        :src="
                            comment.user.profile_picture
                                ? comment.user.profile_picture
                                : 'https://via.placeholder.com/128'
                        "
                        alt="User Image"
                    />

                    <div class="comment-text">
                        <span class="username">
                            <a href="#">
                                {{ comment.user.detail.first_name }}
                                {{ comment.user.detail.last_name }}
                            </a>
                            <span class="text-muted float-right">
                                {{
                                    comment.updated_at.format("F d, Y - g:i A")
                                }}
                            </span>
                        </span>
                        {{ comment.body }}
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <form action="#" method="post">
                    <img
                        class="img-fluid img-circle img-sm"
                        :src="
                            profilePicture
                                ? profilePicture.url
                                : 'https://via.placeholder.com/128'
                        "
                        alt="Alt Text"
                    />
                    <div class="img-push">
                        <div class="input-group">
                            <input
                                type="text"
                                class="form-control form-control-sm"
                                placeholder="Press enter to post comment"
                            />
                            <span class="input-group-append">
                                <button class="btn btn-sm bg-primary">
                                    <i class="fas fa-paper-plane"></i>
                                </button>
                            </span>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import ParentVue from "vue";
import Component from "vue-class-component";
import { Classroom, File } from "@classes/Models";

const Vue = ParentVue.extend({
    props: {
        classroom: Classroom,
        profilePicture: File || null
    }
});
@Component
export default class VueComponent extends Vue {}
</script>

<style lang="scss"></style>
