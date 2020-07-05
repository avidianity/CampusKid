<template>
    <div class="wrapper">
        <app-main-header :user="user"></app-main-header>
        <app-main-sidebar>
            <slot name="main-sidebar"></slot>
        </app-main-sidebar>
        <app-content>
            <template v-slot:content-header>
                <slot name="content-header"></slot>
            </template>
            <template v-slot:content>
                <slot name="content"></slot>
            </template>
        </app-content>
        <app-control-sidebar></app-control-sidebar>
    </div>
</template>

<script lang="ts">
import ParentVue from "vue";
import Component from "vue-class-component";

import MainHeaderComponent from "@components/Dashboard/MainHeader.vue";
import MainSidebarComponent from "@components/Dashboard/MainSidebar.vue";
import ContentComponent from "@components/Dashboard/Content/Wrapper.vue";
import ControlSidebarComponent from "@components/Dashboard/ControlSidebar.vue";
import FooterComponent from "@components/Dashboard/Footer.vue";

import { User } from "@classes/Models/index";

const Vue = ParentVue.extend({
    props: {
        user: User
    }
});

@Component({
    components: {
        appMainHeader: MainHeaderComponent,
        appMainSidebar: MainSidebarComponent,
        appContent: ContentComponent,
        appControlSidebar: ControlSidebarComponent,
        appFooter: FooterComponent
    }
})
export default class AdminLTEComponent extends Vue {
    mounted() {
        require("@assets/AdminLTE/AdminLTE.js");
        $("body").addClass(
            "hold-transition sidebar-mini layout-fixed sidebar-collapse"
        );
    }
}
</script>
