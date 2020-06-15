<template>
    <div class="container pt-4">
        <form class="row">
            <div class="col-sm-12 col-md-4 offset-md-4">
                <label for="email" class="mt-0">Email:</label>
                <input
                    type="email"
                    name="email"
                    placeholder="Email"
                    class="form-control form-control-sm"
                    id="email"
                />
                <small class="form-text text-muted">
                    Email must be valid.
                </small>
                <label for="username">Username:</label>
                <input
                    type="text"
                    name="username"
                    placeholder="Username"
                    class="form-control form-control-sm"
                    id="username"
                />
                <label for="password">Password:</label>
                <input
                    type="password"
                    name="password"
                    placeholder="Password"
                    class="form-control form-control-sm"
                    id="password"
                />
                <small class="form-text text-muted">
                    Password should contain letters and numbers.
                </small>
                <button
                    type="submit"
                    class="btn btn-emperor btn-sm mt-3 px-3"
                    @click.prevent.stop="next()"
                >
                    Next
                </button>
            </div>
        </form>
    </div>
</template>

<script lang="ts">
import Vue from "vue";
export default Vue.extend({
    methods: {
        next(): void {
            this.$emit("next", "appDetail");
        }
    }
});
</script>

<style lang="scss" scoped>
label {
    margin: 12px 0 4px 0;
    font-family: "Lato-Light";
}

input,
.btn {
    border-radius: 20px;
}
</style>
