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
                                <slot name="headers"></slot>
                            </tr>
                        </thead>
                        <tbody>
                            <slot name="body"></slot>
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
        title: String
    }
})
export default class TableComponent extends Vue {
    query = "";
    search() {
        this.$emit("search", this.query);
    }
}
</script>

<style lang="scss" scoped>
.card {
    max-width: none;
    max-height: none;
}
td {
    font-size: 16px;
    font-family: "Lato-Light";
}
</style>
