<template>
    <app :user="user">
        <template v-slot:main-sidebar>
            <sidebar-link
                :has-treeview="false"
                :link="{
                    url: '/dashboard',
                    name: 'Dashboard',
                    icon: 'fas fa-tachometer-alt'
                }"
                :exact="true"
            ></sidebar-link>
            <sidebar-link
                :link="{
                    url: '/dashboard/users',
                    name: 'Users',
                    icon: 'fas fa-users'
                }"
                :has-treeview="true"
            >
                <treeview :links="links"></treeview>
            </sidebar-link>
            <sidebar-link
                :has-treeview="false"
                :link="{
                    url: '/dashboard/classrooms',
                    name: 'Classrooms',
                    icon: 'fas fa-chalkboard'
                }"
            ></sidebar-link>
            <sidebar-link
                :has-treeview="false"
                :link="{
                    url: '/dashboard/departments',
                    name: 'Departments',
                    icon: 'fas fa-building'
                }"
            ></sidebar-link>
            <sidebar-link
                :has-treeview="false"
                :link="{
                    url: '/dashboard/occupations',
                    name: 'Occupations',
                    icon: 'fas fa-briefcase'
                }"
            ></sidebar-link>
        </template>
        <template v-slot:content-header>
            <div class="col-sm-6">
                <h1>{{ route_name }}</h1>
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
import { Action } from "vuex-class";

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
export default class AdminComponent extends Vue {
    @Action setRoute: any;
    created() {
        this.setRoute("Dashboard");
    }
    get user(): User {
        return this.$store.getters.user as User;
    }
    get links(): Array<object> {
        return [
            {
                url: "/dashboard/users/administrators",
                icons: "fas fa-user-lock",
                name: "Administrators"
            },
            {
                url: "/dashboard/users/faculties",
                icons: "fas fa-user-tie",
                name: "Faculties"
            },
            {
                url: "/dashboard/users/students",
                icons: "fas fa-user-graduate",
                name: "Students"
            }
        ];
    }
    get route_name(): string {
        return this.$store.getters.route;
    }
}
</script>
