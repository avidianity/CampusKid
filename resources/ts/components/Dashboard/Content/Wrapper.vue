<template>
    <div class="content-wrapper">
        <app-header>
            <slot name="content-header"></slot>
        </app-header>
        <app-content>
            <slot name="content"></slot>
        </app-content>
    </div>
</template>

<script lang="ts">
import Vue from "vue";
import Component from "vue-class-component";

import HeaderComponent from "./Header.vue";
import ContentComponent from "./Content.vue";

@Component({
    components: {
        appHeader: HeaderComponent,
        appContent: ContentComponent
    }
})
export default class WrapperComponent extends Vue {}
</script>
