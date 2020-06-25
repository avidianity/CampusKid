<template>
    <div class="content pb-5">
        <slot></slot>
    </div>
</template>

<script lang="ts">
import Vue from "vue";
import Component from "vue-class-component";

@Component
export default class ContentComponent extends Vue {}
</script>
