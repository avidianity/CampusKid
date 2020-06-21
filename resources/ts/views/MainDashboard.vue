<template>
    <div class="container-fluid border-top pt-3">
        <div v-if="!loaded">
            <h3>Loading...</h3>
            <i class="fas fa-circle-notch fa-spin fa-2x"></i>
        </div>
        <div class="row" v-if="loaded">
            <div
                class="col-6 col-lg-4"
                v-for="(box, index) in analytics"
                :key="index"
            >
                <div class="small-box" :class="box.bg">
                    <div class="inner">
                        <h3>{{ box.count }}</h3>

                        <p>{{ box.title }}</p>
                    </div>
                    <div class="icon">
                        <i class="fas" :class="box.icon"></i>
                    </div>
                    <a href="" class="small-box-footer">
                        More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import Vue from "vue";
import Component from "vue-class-component";
import { AxiosResponse, AxiosError } from "axios";

@Component
export default class MainDashboard extends Vue {
    loaded = false;
    analytics = Array<object>();
    created() {
        const bgs = [
            "bg-success",
            "bg-primary",
            "bg-info",
            "bg-warning text-white",
            "bg-danger",
            "bg-tradewind"
        ];
        const names = [
            "New Users",
            "Administrators",
            "Faculties",
            "Students",
            "Classrooms",
            "Logins"
        ];
        const icons = [
            "fa-user-plus",
            "fa-user-lock",
            "fa-user-tie",
            "fa-user-graduate",
            "fa-chalkboard",
            "fa-users"
        ];
        const titles = [
            "user",
            "admin",
            "faculty",
            "student",
            "classroom",
            "login"
        ];
        Axios.get("/avidian")
            .then(response => response.data)
            .then(data => {
                for (const [index, value] of names.entries()) {
                    this.analytics.push({
                        bg: bgs[index],
                        title: value,
                        icon: icons[index],
                        count: data[titles[index]]
                    });
                }
                this.loaded = true;
            })
            .catch(errors => {
                console.log(errors.toJSON ? errors.toJSON() : errors);
                for (const [index, value] of names.entries()) {
                    this.analytics.push({
                        bg: bgs[index],
                        title: value,
                        icon: icons[index],
                        count: 0
                    });
                }
                this.loaded = true;
            });
    }
}
</script>
