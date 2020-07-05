<template>
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a
                    class="nav-link"
                    data-widget="pushmenu"
                    href="javascript:void(0)"
                    role="button"
                >
                    <i class="fas fa-bars"></i>
                </a>
            </li>
        </ul>
        <form class="form-inline ml-3">
            <div class="input-group input-group-sm">
                <input
                    class="form-control form-control-navbar"
                    type="search"
                    placeholder="Search"
                    aria-label="Search"
                />
                <div class="input-group-append">
                    <button class="btn btn-navbar" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </form>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="far fa-comments"></i>
                    <span class="badge badge-danger navbar-badge">
                        3
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <a href="#" class="dropdown-item">
                        <div class="media">
                            <img
                                src="https://i.pravatar.cc/160"
                                alt="User Avatar"
                                class="img-size-50 mr-3 img-circle"
                            />
                            <div class="media-body">
                                <h3 class="dropdown-item-title">
                                    Brad Diesel
                                    <span
                                        class="float-right text-sm text-danger"
                                    >
                                        <i class="fas fa-star"></i>
                                    </span>
                                </h3>
                                <p class="text-sm">
                                    Call me whenever you can...
                                </p>
                                <p class="text-sm text-muted">
                                    <i class="far fa-clock mr-1"></i>
                                    4 Hours Ago
                                </p>
                            </div>
                        </div>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <div class="media">
                            <img
                                src="https://i.pravatar.cc/160"
                                alt="User Avatar"
                                class="img-size-50 img-circle mr-3"
                            />
                            <div class="media-body">
                                <h3 class="dropdown-item-title">
                                    John Pierce
                                    <span class="float-right text-sm text-muted"
                                        ><i class="fas fa-star"></i
                                    ></span>
                                </h3>
                                <p class="text-sm">
                                    I got your message bro
                                </p>
                                <p class="text-sm text-muted">
                                    <i class="far fa-clock mr-1"></i> 4 Hours
                                    Ago
                                </p>
                            </div>
                        </div>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <div class="media">
                            <img
                                src="https://i.pravatar.cc/160"
                                alt="User Avatar"
                                class="img-size-50 img-circle mr-3"
                            />
                            <div class="media-body">
                                <h3 class="dropdown-item-title">
                                    Nora Silvester
                                    <span
                                        class="float-right text-sm text-warning"
                                        ><i class="fas fa-star"></i
                                    ></span>
                                </h3>
                                <p class="text-sm">
                                    The subject goes here
                                </p>
                                <p class="text-sm text-muted">
                                    <i class="far fa-clock mr-1"></i>
                                    4 Hours Ago
                                </p>
                            </div>
                        </div>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item dropdown-footer">
                        See All Messages
                    </a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="far fa-bell"></i>
                    <span class="badge badge-warning navbar-badge">
                        15
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <span class="dropdown-header">
                        15 Notifications
                    </span>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-envelope mr-2"></i>
                        4 new messages
                        <span class="float-right text-muted text-sm">
                            3 mins
                        </span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-users mr-2"></i>
                        8 friend requests
                        <span class="float-right text-muted text-sm">
                            12 hours
                        </span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-file mr-2"></i>
                        3 new reports
                        <span class="float-right text-muted text-sm">
                            2 days
                        </span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item dropdown-footer">
                        See All Notifications
                    </a>
                </div>
            </li>
            <li class="nav-item dropdown user-menu">
                <a
                    href="#"
                    class="nav-link dropdown-toggle"
                    data-toggle="dropdown"
                >
                    <img
                        :src="profile_picture"
                        class="user-image img-circle elevation-2"
                        alt="User Image"
                    />
                    <span class="d-none d-md-inline">
                        @{{ user.username }}
                    </span>
                </a>
                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <li class="user-header" :style="cover_photo">
                        <img
                            :src="profile_picture"
                            class="img-circle elevation-2"
                            alt="User Image"
                        />
                        <p>
                            @{{ user.username }}
                            <small>
                                Member since {{ user.created_at.getMonthAndYear() }}
                            </small>
                        </p>
                    </li>
                    <li class="user-body">
                        <div class="row">
                            <div class="col-4 text-center">
                                <router-link
                                    :to="`/dashboard/users/${self.id}/following`"
                                >
                                    Following
                                </router-link>
                            </div>
                            <div class="col-4 text-center">
                                <router-link
                                    :to="`/dashboard/users/${self.id}`"
                                >
                                    Posts
                                </router-link>
                            </div>
                            <div class="col-4 text-center">
                                <router-link
                                    :to="`/dashboard/users/${self.id}/settings`"
                                >
                                    Settings
                                </router-link>
                            </div>
                        </div>
                    </li>
                    <li class="user-footer">
                        <router-link
                            :to="`/dashboard/users/${self.id}`"
                            class="btn btn-default btn-flat"
                        >
                            Profile
                        </router-link>
                        <a
                            href=""
                            class="btn btn-default btn-flat float-right"
                            @click.prevent.stop="signout()"
                        >
                            Sign out
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a
                    class="nav-link"
                    data-widget="control-sidebar"
                    data-slide="true"
                    href="#"
                    role="button"
                >
                    <i class="fas fa-th-large"></i>
                </a>
            </li>
        </ul>
    </nav>
</template>

<script lang="ts">
import ParentVue from "vue";
import Component from "vue-class-component";
import { Action } from "vuex-class";

import { User, File } from "@classes/Models/index";

const Vue = ParentVue.extend({
    props: {
        user: User
    }
});

@Component
export default class MainHeaderComponent extends Vue {
    @Action logout: any;
    signout() {
        this.logout();
        this.$router.push({
            path: "/"
        });
    }
    get profile_picture(): string {
        return this.$store.getters.user.profile_picture
            ? this.$store.getters.user.profile_picture.url
            : "https://i.pravatar.cc/160";
    }
    get self() {
        return this.$store.getters.user;
    }
    get cover_photo() {
        return this.$store.getters.user.cover_photo
            ? {
                  background: `url("${this.$store.getters.user.cover_photo.url}") center center`,
                  "background-repeat": "no-repeat"
              }
            : {
                  background: "#007bff",
                  color: "#fff"
              };
    }
}
</script>

<style lang="scss" scoped>
.user-header {
    max-width: 280px;
    max-height: 175px;
}
</style>
