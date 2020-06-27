<template>
    <div class="container d-flex h-100 w-100">
        <div class="error-page align-self-center mx-auto pt-5">
            <h2 class="headline text-warning">404</h2>
            <div class="error-content">
                <h3>
                    <i class="fas fa-exclamation-triangle text-warning"></i>
                    {{ title }}
                </h3>
                <p>
                    {{ body }} Meanwhile, you may
                    <a href="" @click.prevent.stop="redirect()">
                        go back to the last page you visited.
                    </a>
                </p>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        title: {
            type: String,
            default: "Oops! Page not found."
        },
        body: {
            type: String,
            default: "We could not find the page you were looking for."
        }
    },
    methods: {
        redirect() {
            this.$router.go(-1);
        }
    }
};
</script>

<style scoped>
.btn-outline-danger {
    transition: none;
}
.btn-outline-danger:hover {
    text-decoration: underline;
}
</style>
