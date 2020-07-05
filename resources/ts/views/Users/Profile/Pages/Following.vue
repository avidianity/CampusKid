<template> </template>

<script lang="ts">
import Vue from "vue";
import Component from "vue-class-component";
import { Action } from "vuex-class";

@Component
export default class VueComponent extends Vue {
    @Action toggleContentHeader: any;
    created() {
        this.toggleContentHeader(false);
    }
}
</script>

<style lang="scss" scoped></style>
