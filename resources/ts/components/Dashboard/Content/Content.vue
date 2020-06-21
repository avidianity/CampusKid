<template>
    <div class="content">
        <slot></slot>
    </div>
</template>

<script lang="ts">
import Vue from "vue";
import Component from "vue-class-component";

@Component
export default class ContentComponent extends Vue {}
</script>
