<template>
    <nav aria-label="Page Navigation">
        <ul class="pagination pagination-sm mb-0">
            <li class="page-item">
                <a
                    class="page-link"
                    :href="pagination.first_page_url"
                    @click.prevent.stop="navigate(pagination.first_page_url)"
                    aria-label="First"
                >
                    <span aria-hidden="true">
                        <i class="fas fa-angle-double-left"></i>
                    </span>
                    <span class="sr-only">First</span>
                </a>
            </li>
            <li
                class="page-item"
                :class="{ disabled: !pagination.prev_page_url }"
            >
                <a
                    class="page-link"
                    :href="pagination.prev_page_url"
                    @click.prevent.stop="navigate(pagination.prev_page_url)"
                    aria-label="Previous"
                >
                    <span aria-hidden="true">
                        <i class="fas fa-angle-left"></i>
                    </span>
                    <span class="sr-only">Previous</span>
                </a>
            </li>
            <li
                class="page-item"
                v-for="(page, index) in pagination.last_page"
                :key="index"
                :class="{ disabled: page === pagination.current_page }"
            >
                <a
                    class="page-link"
                    :href="`${pagination.path}?page=${page}`"
                    @click.prevent.stop="
                        navigate(`${pagination.path}?page=${page}`)
                    "
                >
                    {{ page }}
                </a>
            </li>
            <li
                class="page-item"
                :class="{ disabled: !pagination.next_page_url }"
            >
                <a
                    class="page-link"
                    :href="pagination.next_page_url"
                    @click.prevent.stop="navigate(pagination.next_page_url)"
                    aria-label="Next"
                >
                    <span aria-hidden="true">
                        <i class="fas fa-angle-right"></i>
                    </span>
                    <span class="sr-only">Next</span>
                </a>
            </li>
            <li class="page-item">
                <a
                    class="page-link"
                    :href="pagination.last_page_url"
                    @click.prevent.stop="navigate(pagination.last_page_url)"
                    aria-label="Last"
                >
                    <span aria-hidden="true">
                        <i class="fas fa-angle-double-right"></i>
                    </span>
                    <span class="sr-only">Last</span>
                </a>
            </li>
        </ul>
    </nav>
</template>

<script lang="ts">
import Vue from "vue";
import Component from "vue-class-component";

@Component({
    props: {
        pagination: Object
    }
})
export default class PaginationComponent extends Vue {
    navigate(url: string) {
        const array = url.split('/');
        array.shift();
        array.shift();
        const final = `${window.location.protocol}//${array.join('/')}`;
        this.$emit("navigation", final);
    }
}
</script>
