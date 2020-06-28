<template>
	<div class="container-fluid pt-5 text-center">
		<div class="container d-flex h-100 w-100">
        <div class="error-page align-self-center mx-auto pt-5">
            <h2 class="headline" :class="style">
            	{{ code }}
            </h2>
            <div class="error-content">
                <h3>
                    <i class="fas fa-info-circle" :class="style"></i>
                    {{ title }}
                </h3>
                <p>
                    {{ body }}
                </p>
            </div>
        </div>
    </div>
	</div>
</template>

<script lang="ts">
import ParentVue from 'vue';
import Component from 'vue-class-component';

const Vue = ParentVue.extend({
	props: {
		title: String,
		body: String,
		color: String,
		code: String
	}
});

export default class MessageComponent extends Vue {
	get style() {
		return { `text-${this.color}`: true };
	}
}
</script>