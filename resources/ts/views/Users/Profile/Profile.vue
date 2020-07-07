<template>
    <div class="card card-primary card-outline">
        <div
            class="card-body box-profile"
            :style="{
                background: localUser.cover_photo
                    ? `url('${localUser.cover_photo.url}') center center`
                    : 'url(\'https://via.placeholder.com/500\') center center',
                backgroundRepeat: 'no-repeat',
                backgroundSize: '100%'
            }"
        >
            <div class="d-flex" v-if="isSelf">
                <button
                    type="button"
                    class="btn btn-emperor btn-sm ml-auto"
                    @click.prevent.stop="isSelf ? $refs.coverPhoto.click() : null"
                >
                    <i class="fas fa-camera"></i>
                    Cover Photo
                </button>
            </div>
            <div class="text-center">
                <img
                    class="profile-user-img img-fluid img-circle"
                    :class="{
                        'cursor-pointer': localUser.id == self.id
                    }"
                    :src="
                        localUser.profile_picture
                            ? localUser.profile_picture.url
                            : 'https://via.placeholder.com/128'
                    "
                    alt="User profile picture"
                    @click.stop="isSelf ? $refs.profilePicture.click() : null"
                />
                <input
                    type="file"
                    ref="profilePicture"
                    @change="profilePictureChange"
                    class="d-none"
                />
                <input
                    type="file"
                    ref="coverPhoto"
                    @change="coverPhotoChange"
                    class="d-none"
                />
            </div>
            <h3 class="profile-username text-center">
                {{ localUser.detail.first_name }} {{ localUser.detail.last_name }}
            </h3>
            <p class="text-muted text-center">
                {{ localUser.access_level }}
            </p>
            <div class="d-flex" v-if="this.hasForm">
                <button
                    type="button"
                    class="btn btn-emperor btn-sm ml-auto"
                    @click.prevent.stop="save()"
                    :disabled="saving"
                    :class="{
                        disabled: saving
                    }"
                >
                    <i class="fas fa-save"></i>
                    {{ saving ? 'Saving...' : 'Save' }}
                </button>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import ParentVue from "vue";
import Component from "vue-class-component";
import { Action } from "vuex-class";

import { User } from "@classes/Models";

const Vue = ParentVue.extend({
    props: {
        user: User
    }
});

@Component
export default class ProfileComponent extends Vue {
    @Action login: any;
    form = {
        ["profile_picture" as string]: null as any,
        ["cover_photo" as string]: null as any
    };
    hasForm = false;
    localUser : User | null = null;
    saving = false;
    created() {
        this.localUser = this.user;
    }
    get self() {
        return this.$store.getters.user;
    }
    get isSelf() {
        return (this.localUser as User).id === this.$store.getters.user.id;
    }
    save() {
        this.saving = true;
        const form = new FormData();
        if (this.form.profile_picture) {
            form.append("profile_picture", this.form.profile_picture);
            this.form.profile_picture = null;
        }
        if (this.form.cover_photo) {
            form.append("cover_photo", this.form.cover_photo);
            this.form.cover_photo = null;
        }
        form.append("_method", "PUT");
        Axios.post(`/user/${(Session.user() as User).id}`, form, {
            headers: {
                "Content-Type": "multipart/form-data"
            }
        })
            .then(response => response.data)
            .then((data: User) => {
                const user = new User(data);
                this.login(user);
                Session.user(user);
                this.localUser = user;
                toastr.success("Profile saved.");
                this.hasForm = false;
                this.saving = false;
            })
            .catch(error => {
                this.hasForm = false;
                this.saving = false;
                toastr.error("Unable to save. Please try again later.");
            });
    }
    profilePictureChange(event: any) {
        const files = event.target.files || event.dataTransfer.files;
        if (!files.length) {
            this.hasForm = false;
            return;
        }
        this.hasForm = true;
        this.form.profile_picture = files[0];
    }
    coverPhotoChange(event: any) {
        const files = event.target.files || event.dataTransfer.files;
        if (!files.length) {
            this.hasForm = false;
            return;
        }
        this.hasForm = true;
        this.form.cover_photo = files[0];
    }
    createImage(file: any, target: string) {
        const image = new Image();
        const reader = new FileReader();
        reader.onload = (e: any) => {
            this.form[target] = e.target.result;
        };
        reader.readAsDataURL(file);
    }
}
</script>

<style lang="scss" scoped>
a,
p,
div,
b {
    font-family: "Lato-Light" !important;
}
.cursor-pointer {
    cursor: pointer;
}
</style>
