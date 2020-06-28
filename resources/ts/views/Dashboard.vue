<template>
    <div>
        <app-admin></app-admin>
    </div>
</template>

<script lang="ts">
import Vue from "vue";
import Component from "vue-class-component";
import { Action } from "vuex-class";
import Admin from "@components/Admin.vue";

@Component({
    components: {
        appAdmin: Admin
    }
})
export default class Dashboard extends Vue {
    @Action fetchDepartments: any;
    @Action fetchOccupations: any;
    @Action fetchSubjects: any;
    @Action fetchClassrooms: any;
    created() {
        this.fetchAssets();
    }
    fetchAssets(): any {
        return Promise.all([
            this.fetchDepartments(),
            this.fetchOccupations(),
            this.fetchClassrooms()
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
