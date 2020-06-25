<template>
    <div class="form-group">
        <label :for="inputID">{{ title }}:</label>
        <select
            :name="inputID"
            :id="inputID"
            class="form-control form-control-sm"
            @input="$emit('input', $event.target.value)"
        >
            <option
                v-for="(option, index) in options"
                :value="getVal(option)"
                :selected="getVal(option) === value"
                :key="index"
            >
                {{ getName(option) }}
            </option>
        </select>
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
        value: [String, Number],
        options: Array,
        id: {
            type: [String, Number],
            default: ""
        }
    }
});

@Component
export default class InputComponent extends Vue {
    getVal(option: any) {
        return option.value ? option.value : option;
    }
    getName(option: any) {
        return option.name ? option.name : option;
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
