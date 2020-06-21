<template>
    <aside class="control-sidebar control-sidebar-dark"></aside>
</template>

<script lang="ts">
import Vue from "vue";
import Component from "vue-class-component";

export default class ControlSidebarComponent extends Vue {
    created() {
        require("@assets/Sidebar.js");
    }
}
</script>
