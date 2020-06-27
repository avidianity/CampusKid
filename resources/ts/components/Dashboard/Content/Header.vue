<template>
    <div class="content-header" v-if="show">
        <div class="container-fluid">
            <div class="row mb-2">
                <slot></slot>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import Vue from "vue";
import Component from "vue-class-component";

@Component
export default class HeaderComponent extends Vue {
    get show() {
        return this.$store.getters.shows.contentHeader;
    }
}
</script>
