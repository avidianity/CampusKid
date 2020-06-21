<template>
    <app-admin></app-admin>
</template>

<script lang="ts">
import Vue from "vue";
import Component from "vue-class-component";
import Admin from "@components/Admin.vue";

@Component({
    components: {
        appAdmin: Admin
    }
})
export default class Dashboard extends Vue {}
</script>
