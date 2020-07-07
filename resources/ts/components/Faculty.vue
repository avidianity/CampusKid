<template>
    <app :user="user">
        <template v-slot:main-sidebar>
            <sidebar-link
                v-for="(link, index) in links"
                :key="index"
                :has-treeview="link.hasTreeview"
                :link="link"
                :exact="link.exact"
                :menu-open="link.menuOpen"
                :isRouter="link.isRouter"
                :has-badge="link.hasBadge"
                :badge="link.badge"
            >
                <treeview
                    v-if="link.hasTreeview"
                    :links="link.children"
                ></treeview>
            </sidebar-link>
        </template>
        <template v-slot:content-header>
            <div class="col-sm-6">
                <h1>{{ route }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="">News</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="">Updates</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="">Blog</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="">Help</a>
                    </li>
                </ol>
            </div>
        </template>
        <template v-slot:content>
            <router-view></router-view>
        </template>
    </app>
</template>

<script lang="ts">
import Vue from "vue";
import Component from "vue-class-component";
import { Getter } from "vuex-class";

import AdminLTE from "@components/AdminLTE.vue";
import SidebarLink from "@components/Dashboard/Sidebar/SidebarLink.vue";
import Treeview from "@components/Dashboard/Sidebar/Treeview.vue";

import { User } from "@classes/Models/index";

@Component({
    components: {
        app: AdminLTE,
        SidebarLink,
        Treeview
    }
})
export default class FacultyComponent extends Vue {
    @Getter route: any;
    get user(): User {
        return this.$store.getters.user as User;
    }
    get links(): Array<object> {
        return [
            {
                url: "/dashboard",
                name: "Dashboard",
                icon: "fas fa-tachometer-alt",
                hasTreeview: false,
                exact: true
            },
            {
                url: "/dashboard/users",
                name: "Users",
                icon: "fas fa-users",
                hasTreeview: false,
                exact: true
            },
            {
                url: "/dashboard/users/faculties",
                icon: "fas fa-user-tie",
                name: "Faculties",
                hasTreeview: false,
                exact: false
            },
            {
                url: "/dashboard/users/students",
                icon: "fas fa-user-graduate",
                name: "Students",
                hasTreeview: false,
                exact: false
            },
            {
                url: "/dashboard/classrooms",
                name: "Classrooms",
                icon: "fas fa-chalkboard",
                hasTreeview: false,
                exact: false
            },
            {
                url: "/dashboard/departments",
                name: "Departments",
                icon: "fas fa-building",
                hasTreeview: false,
                exact: false
            },
            {
                url: "/dashboard/occupations",
                name: "Occupations",
                icon: "fas fa-briefcase",
                hasTreeview: false,
                exact: false
            },
            {
                url: "/dashboard/subjects",
                name: "Subjects",
                icon: "fas fa-book-open",
                hasTreeview: false,
                exact: false
            },
        ];
    }
}
</script>
