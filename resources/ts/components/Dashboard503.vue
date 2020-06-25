<template>
    <div class="container d-flex h-100 w-100">
        <div class="error-page">
            <h2 class="headline text-primary">503</h2>

            <div class="error-content">
                <h3>
                    <i class="fas fa-exclamation-triangle text-primary"></i>
                    Page Under Construction
                </h3>

                <p>
                    We are working in finishing this section of the site right
                    away. Meanwhile, you may
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
    methods: {
        redirect() {
            this.$router.go(-1);
        }
    }
};
</script>
