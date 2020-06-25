<template>
    <router-view></router-view>
</template>

<script lang="ts">
import Vue from "vue";
import Component from "vue-class-component";
import { Action } from "vuex-class";

@Component
export default class ClassroomIndexComponent extends Vue {
    @Action fetchClassrooms: any;
    created() {
        this.fetchClassrooms();
    }
}
</script>
