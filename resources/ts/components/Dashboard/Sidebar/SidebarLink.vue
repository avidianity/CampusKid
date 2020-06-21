<template>
    <li
        class="nav-item"
        :class="{ 'has-treeview': hasTreeview, 'menu-open': hasTreeview }"
    >
        <router-link :to="link.url" class="nav-link" :exact="exact">
            <i class="nav-icon" :class="link.icon"></i>
            <p>
                {{ link.name }}
                <i class="right fas fa-angle-left" v-if="hasTreeview"></i>
            </p>
        </router-link>
        <slot></slot>
    </li>
</template>

<script lang="ts">
import ParentVue from "vue";
import Component from "vue-class-component";

const Vue = ParentVue.extend({
    props: {
        "has-treeview": Boolean,
        link: Object,
        exact: {
            type: Boolean,
            default() {
                return false;
            }
        }
    }
});

@Component
export default class SidebarLinkComponent extends Vue {}
</script>
