<template>
    <component :is="mainComponent"></component>
</template>

<script lang="ts">
import Vue from "vue";
import Component from "vue-class-component";
import { Action } from "vuex-class";

import { User } from '@classes/Models';

import Admin from "@components/Admin.vue";
import Faculty from "@components/Faculty.vue";

@Component({
    components: {
        appAdministrator: Admin,
        appFaculty: Faculty
    }
})
export default class Dashboard extends Vue {
    @Action fetchDepartments: any;
    @Action fetchOccupations: any;
    @Action fetchSubjects: any;
    @Action fetchClassrooms: any;
    mainComponent = '';
    created() {
        const user = Session.user() as User;
        this.mainComponent = `app-${(user.access_level as string).toLowerCase()}`;
        this.fetchAssets();
    }
    fetchAssets(): any {
        return Promise.all([
            this.fetchDepartments(),
            this.fetchOccupations(),
            this.fetchClassrooms(),
            this.fetchSubjects(),
        ]).catch(error => {
            return this.fetchAssets();
        });
    }
    mounted() {
        if (Session.flash.has("toastr")) {
            const toast = Session.flash.get("toastr");
            if (toast.type === "success") {
                const alert = toastr.success(toast.message);
            }
        }
    }
}
</script>
