<template>
    <div class="tab-pane active" id="posts">
        <div class="card">
            <div class="card-body">
                <div class="post">
                    <div class="user-block row mb-0">
                        <div class="col-12">
                            <div class="form-group mb-0">
                                <textarea
                                    cols="5"
                                    rows="2"
                                    :disabled="processes.save"
                                    class="form-control"
                                    placeholder="What's on your mind?"
                                    v-model="body"
                                ></textarea>
                                <button
                                    type="submit"
                                    class="btn btn-primary btn-sm mt-2"
                                    @click.prevent.stop="post()"
                                    :disabled="processes.save"
                                    :class="{ disabled: processes.save }"
                                >
                                    <i
                                        class="fas fa-circle-notch fa-spin"
                                        v-if="processes.save"
                                    ></i>
                                    {{ processes.save ? "Posting..." : "Post" }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card" v-for="(post, index) in filteredPosts" :key="index">
            <div class="card-body pb-0">
                <div class="post">
                    <div class="user-block">
                        <img
                            class="img-circle img-bordered-sm"
                            :src="
                                post.user.profile_picture
                                    ? post.user.profile_picture.url
                                    : 'https://via.placeholder.com/128'
                            "
                            alt="user image"
                        />
                        <span class="username d-flex">
                            <a href="#" class="lato-light">
                                {{ post.user.detail.first_name }}
                                {{ post.user.detail.last_name }}
                            </a>
                            <div
                                class="ml-auto"
                                v-if="post.user_id === self.id"
                            >
                                <a
                                    href=""
                                    class="btn-tool"
                                    title="Edit Post"
                                    @click.prevent.stop="showPostEdit(index)"
                                >
                                    <i class="fas fa-edit"></i>
                                </a>
                                <app-modal
                                    :id="`deletepost${post.id}`"
                                    title="Delete Post"
                                    :classes="['btn-tool']"
                                    tag="a"
                                    :inline="true"
                                >
                                    <template v-slot:name>
                                        <i class="fas fa-trash-alt"></i>
                                    </template>
                                    <template v-slot:body>
                                        <p class="lato-light">
                                            Are you sure you want to delete this
                                            post?
                                        </p>
                                    </template>
                                    <template v-slot:footer>
                                        <button
                                            class="btn btn-danger btn-sm btn-flat ml-auto mr-1"
                                            @click.prevent.stop="
                                                deletePost(index)
                                            "
                                            :disabled="processes.delete"
                                            :class="{
                                                disabled: processes.delete,
                                            }"
                                        >
                                            <i
                                                class="fas fa-circle-notch fa-spin"
                                                v-if="processes.delete"
                                            ></i>
                                            {{
                                                processes.delete
                                                    ? "Deleting..."
                                                    : "Confirm"
                                            }}
                                        </button>
                                    </template>
                                </app-modal>
                            </div>
                        </span>
                        <span class="description">
                            {{ post.updated_at.format("F d, Y - g:i A") }}
                            {{
                                post.created_at.isLessThan(post.updated_at)
                                    ? "(edited)"
                                    : ""
                            }}
                        </span>
                    </div>
                    <div v-if="!forms[index].show">
                        <p class="pre">{{ post.body }}</p>
                    </div>
                    <p class="mb-1">
                        <a href="#" class="link-black text-sm">
                            <i class="far fa-thumbs-up mr-1"></i>
                            Like
                        </a>
                        <span
                            class="float-right"
                            v-if="post.comments.length > 0"
                        >
                            <a href="#" class="link-black text-sm">
                                <i class="far fa-comments mr-1"></i>
                                Comments ({{ post.comments.length }})
                            </a>
                        </span>
                    </p>
                </div>
            </div>
            <div class="card-footer" v-if="forms[index].show">
                <div class="post">
                    <div class="user-block row mb-0">
                        <div class="col-12">
                            <div class="form-group mb-0">
                                <textarea
                                    cols="5"
                                    rows="2"
                                    class="form-control"
                                    :disabled="processes.edit"
                                    v-model="forms[index].body"
                                ></textarea>
                                <button
                                    type="submit"
                                    class="btn btn-primary btn-sm mt-2"
                                    @click.prevent.stop="editPost(index)"
                                    :disabled="processes.edit"
                                    :class="{ disabled: processes.edit }"
                                >
                                    <i
                                        class="fas fa-circle-notch fa-spin"
                                        v-if="processes.edit"
                                    ></i>
                                    {{ processes.edit ? "Saving..." : "Save" }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div
                class="card-footer card-comments"
                v-if="post.comments.length > 0"
            >
                <div
                    class="card-comment"
                    v-for="(comment, commentIndex) in post.comments"
                    :key="commentIndex"
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
                                    comment.created_at.isLessThan(
                                        comment.updated_at
                                    )
                                        ? "(edited)"
                                        : ""
                                }}
                            </span>
                        </span>
                        <div class="pre lato-light">{{ comment.body }}</div>
                        <div class="d-flex" v-if="comment.user_id === self.id">
                            <app-modal
                                :id="`editcomment${comment.id}`"
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
                                            :disabled="comments.edit"
                                            v-model="
                                                forms[index].comments[
                                                    commentIndex
                                                ].body
                                            "
                                        ></textarea>
                                    </div>
                                </template>
                                <template v-slot:footer>
                                    <button
                                        class="btn btn-tradewind btn-sm btn-flat ml-auto mr-1"
                                        @click.prevent.stop="
                                            editComment(index, commentIndex)
                                        "
                                        :disabled="comments.edit"
                                        :class="{
                                            disabled: comments.edit,
                                        }"
                                    >
                                        <i
                                            class="fas fa-circle-notch fa-spin"
                                            v-if="comments.edit"
                                        ></i>
                                        {{
                                            comments.edit ? "Saving..." : "Save"
                                        }}
                                    </button>
                                </template>
                            </app-modal>
                            <app-modal
                                :id="`deletecomment${comment.id}`"
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
                                            deleteComment(index, commentIndex)
                                        "
                                        :disabled="comments.delete"
                                        :class="{
                                            disabled: comments.delete,
                                        }"
                                    >
                                        <i
                                            class="fas fa-circle-notch fa-spin"
                                            v-if="comments.delete"
                                        ></i>
                                        {{
                                            comments.delete
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
                <form>
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
                                v-model="commentForms[index].body"
                                placeholder="Press enter to post comment"
                                :disabled="comments.save"
                                @keyup.enter="comment(index)"
                            />
                            <span class="input-group-append">
                                <button
                                    class="btn btn-sm bg-primary"
                                    @click.prevent.stop="comment(index)"
                                    :disabled="comments.save"
                                    :class="{ disabled: comments.save }"
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

import Modal from "@components/Modal.vue";

import { Post, PostComment } from "@classes/Models";

const Vue = ParentVue.extend({
    props: ["profilePicture", "posts", "classroomID"],
});
@Component({
    components: {
        appModal: Modal,
    },
})
export default class VueComponent extends Vue {
    body = "";
    commentForms: Object[] = [];
    filteredPosts: Array<Post> = [];
    processes = {
        save: false,
        edit: false,
        delete: false,
    };
    comments = {
        save: false,
        edit: false,
        delete: false,
    };
    forms: Object[] = [];
    created() {
        this.filteredPosts = this.posts;
        this.filteredPosts.forEach((post, index) => {
            this.commentForms[index] = {
                id: post.id,
                body: "",
            };
            this.forms[index] = {
                id: post.id,
                body: post.body,
                show: false,
                comments: [...post.comments],
            };
        });
    }
    get self() {
        return this.$store.getters.user;
    }
    post() {
        this.processes.save = true;
        Axios.post("/posts", {
            classroom_id: this.classroomID,
            body: this.body,
        })
            .then((response) => response.data)
            .then((data: Post) => {
                this.processes.save = false;
                this.body = "";
                const post = new Post(data);
                this.commentForms.unshift({
                    id: post.id,
                    body: "",
                });
                this.filteredPosts.unshift(post);
                this.forms.unshift({
                    id: post.id,
                    body: post.body,
                    show: false,
                    comments: [],
                });
                toastr.success("Post saved.");
            })
            .catch((error) => {
                this.processes.save = false;
                if (error.response) {
                    if (error.response.status === 422) {
                        for (const key in error.response.data.errors) {
                            for (const message of error.response.data.errors[
                                key
                            ]) {
                                toastr.error(message);
                            }
                        }
                    } else if (error.response.status === 403) {
                        for (const key in error.response.data.errors) {
                            for (const message of error.response.data.errors[
                                key
                            ]) {
                                toastr.error(message);
                            }
                        }
                    } else {
                        toastr.error(
                            "Something went wrong. Please try again later."
                        );
                    }
                } else {
                    toastr.error(
                        "Something went wrong. Please try again later."
                    );
                }
            });
    }
    comment(index: number) {
        this.comments.save = true;
        const form = this.commentForms[index];
        Axios.post(`/post/comments`, {
            post_id: form.id,
            body: form.body,
        })
            .then((response) => response.data)
            .then((data: PostComment) => {
                this.commentForms[index].body = "";
                this.comments.save = false;
                const post = this.posts[index];
                post.comments.push(new PostComment(data));
                this.posts.splice(index, 1, post);
                this.forms[index].comments.push(data);
            })
            .catch((error) => {
                this.comments.save = false;
                toastr.error("Error saving comment. Please try again later.");
            });
    }
    editComment(PostIndex: number, CommentIndex: number) {
        this.comments.edit = true;
        const comment = this.forms[PostIndex].comments[CommentIndex];
        Axios.put(`/post/comments/${comment.id}`, {
            body: comment.body,
        })
            .then((response) => response.data)
            .then((data: PostComment) => {
                this.comments.edit = false;
                $(`#modaleditcomment${comment.id}`).modal("hide");
                const post = this.filteredPosts[PostIndex];
                (post.comments as Array<PostComment>)[
                    CommentIndex
                ] = new PostComment(data);
                this.posts.splice(PostIndex, 1, post);
                toastr.success("Comment saved.");
            })
            .catch((error) => {
                this.comments.edit = false;
                toastr.error("Error saving comment. Please try again.");
            });
    }
    deleteComment(PostIndex: number, CommentIndex: number) {
        const post = this.filteredPosts[PostIndex] as Post;
        const comment = (post.comments as Array<PostComment>)[CommentIndex];
        this.comments.delete = true;
        Axios.delete(`post/comments/${comment.id}`)
            .then(() => {
                this.comments.delete = false;
                $(`#modaldeletecomment${comment.id}`).modal("hide");
                $(`#modaldeletecomment${comment.id}`).on(
                    "hidden.bs.modal",
                    (e) => {
                        const post = this.filteredPosts[PostIndex];
                        const form = this.forms[PostIndex];
                        form.comments.splice(CommentIndex, 1);
                        this.forms.splice(PostIndex, 1, form);
                        (post.comments as Array<PostComment>).splice(
                            CommentIndex,
                            1
                        );
                        this.filteredPosts.splice(PostIndex, 1, post);
                        toastr.info("Comment deleted.");
                    }
                );
            })
            .catch((error) => {
                this.comments.delete = false;
                toastr.error("Error deleting comment. Please try again.");
            });
    }
    showPostEdit(index: number) {
        const forms = [...this.forms];
        forms[index].show = !forms[index].show;
        forms.forEach((form, i) => {
            if (i !== index) {
                forms[i].show = false;
            }
        });
        this.forms = forms;
    }
    editPost(index: number) {
        this.processes.edit = true;
        Axios.put(`/posts/${this.forms[index].id}`, {
            body: this.forms[index].body,
        })
            .then((response) => response.data)
            .then((data: Post) => {
                this.processes.edit = false;
                const forms = [...this.forms];
                forms[index].show = false;
                this.forms = forms;
                this.body = "";
                this.filteredPosts.splice(index, 1, new Post(data));
                toastr.success("Post edited successfully.");
            })
            .catch((error) => {
                this.processes.edit = false;
                if (error.response && error.response.status === 422) {
                    for (const key in error.response.data.errors) {
                        for (const message of error.response.data.errors[key]) {
                            toastr.error(message);
                        }
                    }
                } else {
                    toastr.error(
                        "Something went wrong. Please try again later."
                    );
                }
            });
    }
    deletePost(index: number) {
        const post = this.filteredPosts[index] as Post;
        this.processes.delete = true;
        Axios.delete(`/posts/${post.id}`)
            .then((response) => response.data)
            .then(() => {
                this.processes.delete = false;
                $(`#modaldeletepost${post.id}`).modal("hide");
                $(`#modaldeletepost${post.id}`).on("hidden.bs.modal", (e) => {
                    toastr.info("Post deleted.");
                    this.commentForms.splice(index, 1);
                    this.forms.splice(index, 1);
                    this.filteredPosts.splice(index, 1);
                });
            })
            .catch((error) => {
                toastr.error("Oops! Something went wrong. Please try again.");
            });
    }
}
</script>

<style lang="scss"></style>
