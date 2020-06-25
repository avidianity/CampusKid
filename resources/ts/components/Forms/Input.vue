<template>
    <div class="form-group">
        <label :for="inputID">{{ inputTitle }}:</label>
        <input
            :type="inputType"
            :name="inputID"
            :placeholder="inputTitle"
            class="form-control form-control-sm"
            :id="inputID"
            :value="value"
            @input="$emit('input', $event.target.value)"
        />
        <div class="form-check ml-1 mt-1" v-if="isPassword">
            <input
                class="form-check-input"
                type="checkbox"
                v-model="toggledPassword"
            />
            <small class="form-check-label">
                Show Password
            </small>
        </div>
        <small
            v-if="messager"
            class="form-text text-muted"
            :class="messager.class"
        >
            <div v-for="(message, index) in messager.messages" :key="index">
                {{ message }}
            </div>
        </small>
    </div>
</template>

<script lang="ts">
import ParentVue from "vue";
import Component from "vue-class-component";

const Vue = ParentVue.extend({
    props: {
        messager: {
            type: Object,
            default: null
        },
        title: String,
        type: String,
        value: [String, Number],
        id: {
            type: [String, Number],
            default: ""
        }
    }
});

@Component
export default class InputComponent extends Vue {
    toggledPassword = false;
    isPassword = false;
    created() {
        this.isPassword = this.type === "password";
    }
    get inputType() {
        return this.type === "password"
            ? this.toggledPassword
                ? "text"
                : "password"
            : this.type;
    }
    get inputTitle() {
        return this.title
            .split("")
            .map((letter, index) => {
                if (index === 0) {
                    return letter.toUpperCase();
                }
                return letter;
            })
            .join("");
    }
    get inputID() {
        return this.title.toLowerCase() + this.id;
    }
}
</script>

<style lang="scss" scoped>
label {
    margin: 12px 0 4px 0;
    font-family: "Lato-Light";
}

.form-control,
.btn {
    border-radius: 20px;
}
</style>
