<template>
    <div :class="{ 'd-inline': inline }">
        <component
            :is="tag"
            href=""
            :class="styles"
            @click.prevent.stop="modal()"
            :title="title"
        >
            <slot name="name"></slot>
        </component>
        <div class="modal fade" :id="`modal${id}`" aria-modal="false">
            <div
                class="modal-dialog modal-dialog-centered"
                :class="{
                    'modal-lg': size === 'large',
                    'modal-md': size === 'medium',
                    'modal-sm': size === 'small',
                    'modal-xl': size === 'xl-large'
                }"
            >
                <div class="modal-content">
                    <div class="modal-header" v-if="title.length > 0">
                        <h4 class="modal-title">
                            {{ title }}
                        </h4>
                        <button
                            type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Close"
                        >
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <slot name="body"></slot>
                    </div>
                    <div class="modal-footer">
                        <div class="d-flex">
                            <slot name="footer"></slot>
                            <button
                                type="button"
                                class="btn btn-default btn-sm btn-flat ml-auto"
                                data-dismiss="modal"
                            >
                                Close
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import ParentVue from "vue";
import Component from "vue-class-component";

const Vue = ParentVue.extend({
    props: {
        id: [String, Number],
        classes: Array,
        title: {
            type: String,
            default: ""
        },
        size: {
            type: String,
            default: "medium",
            validator(value) {
                return (
                    ["large", "medium", "small", "xl-large"].indexOf(value) !==
                    -1
                );
            }
        },
        tag: {
            type: String,
            default: "button"
        },
        inline: {
            type: Boolean,
            default: false
        }
    }
});

@Component
export default class ModalComponent extends Vue {
    get styles() {
        const result: Object = {};
        for (const style of this.classes) {
            result[style as string] = true;
        }
        return result;
    }
    modal() {
        $(`#modal${this.id}`).modal("toggle");
    }
}
</script>

<style lang="scss" scoped>
.modal-body {
    font-family: "Lato-Light";
}
</style>
