<template>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        {{ title }}
                    </h3>
                    <div class="card-tools float-none d-flex">
                        <div class="ml-auto d-flex pt-1">
                            <slot name="buttons"></slot>
                            <div
                                class="input-group input-group-sm ml-2"
                                style="width: 150px;"
                            >
                                <input
                                    type="text"
                                    name="table_search"
                                    class="form-control float-right"
                                    placeholder="Search"
                                    v-model="query"
                                />

                                <div class="input-group-append">
                                    <button
                                        type="submit"
                                        class="btn btn-default"
                                        @click.prevent.stop="search()"
                                    >
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th
                                    v-for="(header, index) in headers"
                                    :key="index"
                                >
                                    {{ header }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, index) in data" :key="index">
                                <td v-for="(key, nth) in keys" :key="nth">
                                    {{
                                        printable(item[key]) &&
                                        !image(item[key])
                                            ? item[key]
                                            : ""
                                    }}

                                    <span
                                        v-if="badge(item[key])"
                                        :class="item[key].class"
                                    >
                                        {{ item[key].name }}
                                    </span>
                                    <img
                                        v-if="image(item[key])"
                                        :src="item[key].url"
                                        alt=""
                                        :class="item[key].class"
                                    />
                                    {{ image(item[key]) ? item[key].name : "" }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <slot></slot>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import Vue from "vue";
import Component from "vue-class-component";

@Component({
    props: {
        headers: Array,
        title: String,
        data: Array,
        keys: Array
    }
})
export default class TableComponent extends Vue {
    query = "";
    search() {
        this.$emit("search", this.query);
    }
    type(item: any) {
        return typeof item;
    }
    printable(item: any) {
        return this.type(item) !== "object";
    }
    badge(item: any) {
        return (
            this.type(item) === "object" &&
            item.name &&
            item.class &&
            item.type === "badge"
        );
    }
    image(item: any) {
        return (
            this.type(item) === "object" &&
            item.name &&
            item.url &&
            item.class &&
            item.type === "image"
        );
    }
}
</script>

<style lang="scss" scoped>
.card {
    max-width: none;
    max-height: none;
}
</style>
