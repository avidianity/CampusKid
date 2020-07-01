<template>
    <div class="tab-pane" id="tasks">
        <div class="card" v-for="(task, index) in tasks" :key="index">
            <div class="card-body pb-0">
                <div class="post">
                    <div class="user-block ml-0">
                        <span class="username ml-0 lato-light">
                            {{ task.name }}
                        </span>
                        <span class="description ml-0">
                            {{ task.updated_at.format("F d, Y - g:i A") }}
                            {{
                                task.created_at.isLessThan(task.updated_at)
                                    ? "(edited)"
                                    : ""
                            }}
                        </span>
                    </div>
                    <p class="pre lato-light">{{ task.description }}</p>
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
                    v-for="(comment, CommentIndex) in task.comments"
                    :key="CommentIndex"
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
                            <a href="#" class="lato-light">
                                {{ comment.user.detail.first_name }}
                                {{ comment.user.detail.last_name }}
                            </a>
                            <span class="text-muted float-right">
                                {{
                                    comment.updated_at.format("F d, Y - g:i A")
                                }} 
                                {{
                                    comment.created_at.isLessThan(comment.updated_at)
                                    ? '(edited)'
                                    : ''
                                }}
                            </span>
                        </span>
                        <p class="pre mb-0 lato-light">{{ comment.body }}</p>
                        <div class="d-flex" v-if="comment.user_id === self.id">
                            <app-modal
                                :id="`edittaskcomment${comment.id}`"
                                title="Edit Comment"
                                :classes="['lato-light', 'size-14', 'ml-1']"
                                tag="a"
                                :inline="true"
                            >
                                <template v-slot:name>
                                    Edit
                                </template>
                                <template v-slot:body>
                                    <div class="lato-light">
                                        <textarea
                                            cols="5"
                                            rows="2"
                                            class="form-control"
                                            :disabled="processes.edits.comment[index][CommentIndex]"
                                            :class="{
                                                disabled: processes.edits.comment[index][CommentIndex],
                                            }"
                                            v-model="
                                                forms[index].comments[
                                                    CommentIndex
                                                ].body
                                            "
                                        ></textarea>
                                    </div>
                                </template>
                                <template v-slot:footer>
                                    <button
                                        class="btn btn-tradewind btn-sm btn-flat ml-auto mr-1"
                                        @click.prevent.stop="
                                            editComment(index, CommentIndex)
                                        "
                                        :disabled="processes.edits.comment[index][CommentIndex]"
                                        :class="{
                                            disabled: processes.edits.comment[index][CommentIndex],
                                        }"
                                    >
                                        <i
                                            class="fas fa-circle-notch fa-spin"
                                            v-if="processes.edits.comment[index][CommentIndex]"
                                        ></i>
                                        {{
                                            processes.edits.comment[index][CommentIndex] ? "Saving..." : "Save"
                                        }}
                                    </button>
                                </template>
                            </app-modal>
                            <app-modal
                                :id="`deletetaskcomment${comment.id}`"
                                title="Delete Comment"
                                :classes="[
                                    'lato-light',
                                    'size-14',
                                    'no-underline',
                                    'ml-1',
                                ]"
                                tag="a"
                                :inline="true"
                            >
                                <template v-slot:name>
                                    Delete
                                </template>
                                <template v-slot:body>
                                    <div class="lato-light">
                                        Are you sure you want to delete this
                                        comment?
                                    </div>
                                </template>
                                <template v-slot:footer>
                                    <button
                                        class="btn btn-danger btn-sm btn-flat ml-auto mr-1"
                                        @click.prevent.stop="
                                            deleteComment(index, CommentIndex)
                                        "
                                        :disabled="processes.deletes.comment[index][CommentIndex]"
                                        :class="{
                                            disabled: processes.deletes.comment[index][CommentIndex],
                                        }"
                                    >
                                        <i
                                            class="fas fa-circle-notch fa-spin"
                                            v-if="processes.deletes.comment[index][CommentIndex]"
                                        ></i>
                                        {{
                                            processes.deletes.comment[index][CommentIndex]
                                                ? "Deleting..."
                                                : "Confirm"
                                        }}
                                    </button>
                                </template>
                            </app-modal>
                        </div>
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
                                @keyup.enter="comment(index)"
                                v-model="comments[index].body"
                                :class="{ disabled: processes.adds.comment }"
                                :disabled="processes.adds.comment"
                            />
                            <span class="input-group-append">
                                <button
                                    class="btn btn-sm bg-primary"
                                    @click.prevent.stop="comment(index)"
                                    :class="{ disabled: processes.adds.comment }"
                                    :disabled="processes.adds.comment"
                                >
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

import Modal from '@components/Modal.vue';

import { Classroom, File, Task, TaskComment } from "@classes/Models";

const Vue = ParentVue.extend({
    props: {
        classroom: Classroom,
        profilePicture: File || null,
    },
    components: {
        appModal: Modal,
    }
});
@Component
export default class VueComponent extends Vue {
    tasks: Array<Task> = [];
    forms: Array<Object> = [];
    comments: Array<Object> = [];
    processes: {
        adds: {
            task: boolean,
            comment: boolean,
        },
        edits: {
            tasks: Array<boolean>,
            /**
             * Comment[TaskIndex][CommentIndex]
             */
            comment: Array<Array<boolean>>,
        },
        deletes: {
            tasks: Array<boolean>,
            /**
             * Comment[TaskIndex][CommentIndex]
             */
            comment: Array<Array<boolean>>,
        }
    };
    constructor() {
        super();
        this.processes = {
            adds: {
                task: false,
                comment: false,
            },
            edits: {
                tasks: [],
                comment: []
            },
            deletes: {
                tasks: [],
                comment: []
            }
        }
    }
    get self() {
        return this.$store.getters.user;
    }
    created() {
        this.tasks = this.classroom.tasks as Array<Task>;
        this.tasks.forEach((task, index) => {
            const comments: Array<Object> = [];
            (task.comments as Array<TaskComment>).forEach(comment => {
                comments.push({...comment});
            });
            this.forms[index] = {
                id: task.id,
                body: task.body,
                comments,
                show: false
            };
            this.comments[index] = {
                id: task.id,
                body: '',
            };
            this.processes.edits.tasks[index] = false;
            this.processes.edits.comment[index] = [] as Array<boolean>;
            (task.comments as Array<TaskComment>).forEach((comment, i) => {
                this.processes.edits.comment[index][i] = false;
            })
            this.processes.deletes.tasks[index] = false;
            this.processes.deletes.comment[index] = [] as Array<boolean>;
            (task.comments as Array<TaskComment>).forEach((comment, i) => {
                this.processes.deletes.comment[index][i] = false;
            });
        });
    }
    comment(index: number) {
        this.processes.adds.comment = true;
        const form = this.comments[index];
        Axios.post('/classroom/task/comments', {
            task_id: form.id,
            body: form.body,
        })
        .then(response => response.data)
        .then((data: TaskComment) => {
            form.body = '';
            this.comments.splice(index, 1, form);
            this.processes.adds.comment = false;
            const task = this.tasks[index];
            const comment = new TaskComment(data);
            (task.comments as Array<TaskComment>).push(comment);
            this.tasks.splice(index, 1, task);
            this.forms[index].comments.push({...comment});
            this.processes.edits.comment[index].push(false);
            this.processes.deletes.comment[index].push(false);
            toastr.info('Comment saved.');
        })
        .catch(error => {
            this.processes.adds.comment = false;
            if(error.response && error.response.status === 422) {
                for(const key in error.response.data.errors) {
                    for(const message of error.response.data.errors[key]) {
                        toastr.error(message);
                    }
                }
            }
            else {
                toastr.error('Error saving comment. Please try again.');
            }
        })
    }
    editComment(TaskIndex: number, CommentIndex: number) {
        const comment = this.forms[TaskIndex].comments[CommentIndex];
        const process = this.processes.edits.comment[TaskIndex];
        process[CommentIndex] = true;
        this.processes.edits.comment.splice(TaskIndex, 1, process);
        Axios.put(`/classroom/task/comments/${comment.id}`, {
            body: comment.body
        })
        .then(response => response.data)
        .then((data: TaskComment) => {
            process[CommentIndex] = false;
            this.processes.edits.comment.splice(TaskIndex, 1, process);
            const modal = $(`#modaledittaskcomment${comment.id}`);
            if(modal.hasClass('show')) {
                modal.modal('hide');
                modal.on('hidden.bs.modal', e => {
                    const comment = new TaskComment(data);
                    const task = this.tasks[TaskIndex];
                    (task.comments as Array<TaskComment>)[CommentIndex] = comment;
                    this.tasks.splice(TaskIndex, 1, task);
                    const form = this.forms[TaskIndex];
                    form.comments.splice(CommentIndex, 1, {...comment});
                    this.forms.splice(TaskIndex, 1, form);
                    toastr.info('Comment saved.');
                });
            }
            else {
                const comment = new TaskComment(data);
                const task = this.tasks[TaskIndex];
                (task.comments as Array<TaskComment>)[CommentIndex] = comment;
                this.tasks.splice(TaskIndex, 1, task);
                const form = this.forms[TaskIndex];
                form.comments.splice(CommentIndex, 1, {...comment});
                this.forms.splice(TaskIndex, 1, form);
                toastr.info('Comment saved.');
            }
        })
        .catch(error => {
            process[CommentIndex] = false;
            this.processes.edits.comment.splice(TaskIndex, 1, process);
            if(error.response && error.response.status === 422) {
                for(const key in error.response.data.errors) {
                    for(const message of error.response.data.errors[key]) {
                        toastr.error(message);
                    }
                }
            }
            else {
                toastr.error('Error editing comment. Please try again.');
            }
        });
    }
    deleteComment(TaskIndex: number, CommentIndex: number) {
        const form = this.forms[TaskIndex];
        const comment = form.comments[CommentIndex];
        const process = this.processes.deletes.comment[TaskIndex];
        process[CommentIndex] = true;
        this.processes.deletes.comment.splice(TaskIndex, 1, process);
        const editProcess = this.processes.edits.comment[TaskIndex];
        editProcess.splice(CommentIndex, 1);
        Axios.delete(`/classroom/task/comments/${comment.id}`)
        .then(response => {
            process.splice(CommentIndex, 1);
            this.processes.deletes.comment.splice(TaskIndex, 1, process);
            const modal = $(`#modaldeletetaskcomment${comment.id}`);
            if(modal.hasClass('show')) {
                modal.modal('hide');
                modal.on('hidden.bs.modal', e => {
                    const commentEdits = this.processes.edits.comment[TaskIndex];
                    const commentDeletes = this.processes.deletes.comment[TaskIndex];
                    commentEdits.splice(CommentIndex, 1);
                    commentDeletes.splice(CommentIndex, 1);
                    this.processes.edits.comment.splice(TaskIndex, 1, commentEdits);
                    this.processes.deletes.comment.splice(TaskIndex, 1, commentDeletes);
                    form.comments.splice(CommentIndex, 1);
                    this.forms.splice(TaskIndex, 1, form);
                    const task = this.tasks[TaskIndex];
                    (task.comments as Array<TaskComment>).splice(CommentIndex, 1);
                    this.tasks.splice(TaskIndex, 1, task);
                    toastr.info('Comment deleted.');
                });
            }
            else {
                const commentEdits = this.processes.edits.comment[TaskIndex];
                const commentDeletes = this.processes.deletes.comment[TaskIndex];
                commentEdits.splice(CommentIndex, 1);
                commentDeletes.splice(CommentIndex, 1);
                this.processes.edits.comment.splice(TaskIndex, 1, commentEdits);
                this.processes.deletes.comment.splice(TaskIndex, 1, commentDeletes);
                form.comments.splice(CommentIndex, 1);
                this.forms.splice(TaskIndex, 1, form);
                const task = this.tasks[TaskIndex];
                (task.comments as Array<TaskComment>).splice(CommentIndex, 1);
                this.tasks.splice(TaskIndex, 1, task);
                toastr.info('Comment deleted.');
            }
        })
        .catch(error => {
            process[CommentIndex] = false;
            this.processes.deletes.comment.splice(TaskIndex, 1, process);
            if(error.response && error.response.status === 422) {
                for(const key in error.response.data.errors) {
                    for(const message of error.response.data.errors[key]) {
                        toastr.error(message);
                    }
                }
            }
            else {
                toastr.error('Error deleting comment. Please try again.');
            }
        });
    }
}
</script>

<style lang="scss"></style>
