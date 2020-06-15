<template>
    <div class="container pt-3">
        <div class="row">
            <div class="col-sm-12 col-md-4 offset-md-4">
                <h3 class="mb-4">I am a...</h3>
                <div class="text-center mb-5">
                    <button
                        class="btn btn-tradewind mr-3"
                        @click.prevent.stop="next('Teacher')"
                    >
                        Teacher
                        <i class="fas fa-user-tie"></i>
                    </button>
                    <button
                        class="btn btn-cutty-sark ml-3"
                        @click.prevent.stop="next('Student')"
                    >
                        Student
                        <i class="fas fa-user-graduate"></i>
                    </button>
                </div>
                <router-link to="/sign-in">
                    Already have an account? Login
                </router-link>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import Vue from "vue";
export default class Role extends Vue {
    next(role: string) {
        this.$emit("next", "appCredentials");
    }
}
</script>

<style lang="scss" scoped>
.btn {
    border-radius: 20px;
}
</style>
