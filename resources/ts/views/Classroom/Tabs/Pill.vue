<template>
    <div class="col-sm-12 col-md-3">
        <div class="card">
            <div class="card-body">
                <ul class="nav nav-pills flex-column">
                    <li class="nav-item">
                        <a
                            class="nav-link active"
                            href="#posts"
                            data-toggle="tab"
                        >
                            <i class="fas fa-map-pin"></i>
                            Posts
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#members" data-toggle="tab">
                            <i class="fas fa-users"></i>
                            Members
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#tasks" data-toggle="tab">
                            <i class="fas fa-pencil-ruler"></i>
                            Tasks
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import Vue from "vue";
import Component from "vue-class-component";

@Component
export default class VueComponent extends Vue {}
</script>

<style lang="scss"></style>
