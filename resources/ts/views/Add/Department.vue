<template>
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-6 col-lg-4">
                <form-input
                    id="name"
                    :title="'Name'"
                    :type="'text'"
                    v-model="form.name"
                    :messager="messagers.name"
                    @keyup.enter.native="submit()"
                ></form-input>
                <form-input
                    id="abbreviation"
                    :title="'Abbreviation'"
                    :type="'text'"
                    v-model="form.abbreviation"
                    :messager="messagers.abbreviation"
                    @keyup.enter.native="submit()"
                ></form-input>
            </div>
            <div class="col-12 mt-2">
                <button
                    type="submit"
                    class="btn btn-emperor btn-sm btn-flat"
                    @click.prevent.stop="submit()"
                    :disabled="processing"
                    :class="{ disabled: processing }"
                >
                    {{ processing ? "Processing..." : "Submit" }}
                    <i
                        class="fas fa-circle-notch fa-spin"
                        v-if="processing"
                    ></i>
                </button>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import Vue from "vue";
import Component from "vue-class-component";

import Input from "@components/Forms/Input.vue";

import { ValidationMessage } from "@classes/FormValidation";

@Component({
    components: {
        formInput: Input
    }
})
export default class VueComponent extends Vue {
    processing = false;
    form = {
        name: "",
        abbreviation: ""
    };
    messagers = {
        ["name" as string]: new ValidationMessage(),
        ["abbreviation" as string]: new ValidationMessage()
    };
    submit() {
        this.processing = true;
        Axios.post("/departments", this.form)
            .then(response => response.data)
            .then(data => {
                this.processing = false;
                toastr.success(
                    `Department added successfully.`,
                    this.form.abbreviation
                );
                this.clear();
            })
            .catch(error => {
                this.processing = false;
                if (error.response && error.response.status === 422) {
                    toastr.error("Oops! You are missing some fields.", "422", {
                        progressBar: true
                    });
                    for (const key in error.response.data.errors) {
                        for (const message of error.response.data.errors[key]) {
                            this.messagers[key].clear();
                            this.messagers[key].timeout(message, "danger");
                        }
                    }
                } else if (error.response) {
                    toastr.error(
                        "Oops! Something went wrong. Please try again later.",
                        error.response.status,
                        { progressBar: true }
                    );
                } else {
                    toastr.error(
                        "Oops! Something went wrong. Please try again later.",
                        "Error",
                        { progressBar: true }
                    );
                    console.log("Error", error.toJSON ? error.toJSON() : error);
                }
            });
    }
    clear() {
        this.form = {
            name: "",
            abbreviation: ""
        };
    }
}
</script>

<style lang="scss"></style>
