<template>
    <div class="content-header">
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
export default class HeaderComponent extends Vue {}
</script>
