<template>
    <footer class="main-footer">
        Copyright &copy; 2014-2019
        <a href="#">CampusKid.com</a>. All rights reserved.
        <div class="float-right d-none d-sm-inline">
            {{ time }}
        </div>
    </footer>
</template>

<script lang="ts">
import Vue from "vue";
import Component from "vue-class-component";

@Component
export default class FooterComponent extends Vue {
    time = new Date(Date.now()).format("F d, Y");
}
</script>
