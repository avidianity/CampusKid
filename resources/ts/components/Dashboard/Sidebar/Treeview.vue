<template>
    <ul class="nav nav-treeview">
        <li class="nav-item" v-for="(link, index) in links" :key="index">
            <router-link :to="link.url" class="nav-link">
                <i class="nav-icon" :class="link.icons"></i>
                <p>{{ link.name }}</p>
            </router-link>
        </li>
    </ul>
</template>

<script lang="ts">
import ParentVue from "vue";
import Component from "vue-class-component";

const Vue = ParentVue.extend({
    props: {
        links: Array
    }
});

@Component
export default class TreeviewComponent extends Vue {}
</script>
