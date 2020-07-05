<template>
    <div class="container">
        <h3>Account</h3>
        <div class="row">
            <div class="col-sm-12 col-md-6">
                <form-input
                    title="Username"
                    type="text"
                    v-model="form.username"
                ></form-input>
            </div>
            <div class="col-sm-12 col-md-6">
                <form-input
                    title="Email"
                    type="email"
                    v-model="form.email"
                ></form-input>
            </div>
        </div>
        <hr class="my-2" />
        <h3>Personal Information</h3>
        <div class="row">
            <div class="col-sm-12 col-md-6">
                <form-input
                    title="First Name"
                    type="text"
                    v-model="form.detail.first_name"
                ></form-input>
            </div>
            <div class="col-sm-12 col-md-6">
                <form-input
                    title="Last Name"
                    type="text"
                    v-model="form.detail.last_name"
                ></form-input>
            </div>
            <div class="col-sm-12 col-md-6">
                <form-input
                    title="Address"
                    type="text"
                    v-model="form.detail.address"
                ></form-input>
            </div>
            <div class="col-sm-12 col-md-6">
                <form-input
                    title="Birthday"
                    type="date"
                    v-model="form.detail.birthday"
                ></form-input>
            </div>
            <div class="col-sm-12 col-md-6">
                <form-select
                    title="Gender"
                    :options="['Male', 'Female']"
                    v-model="form.detail.gender"
                ></form-select>
            </div>
            <div class="col-12">
                <button 
                    type="submit" 
                    class="btn btn-emperor btn-sm btn-flat"
                    @click.prevent.stop="save()"
                    :disabled="saving"
                    :class="{
                        disabled: saving
                    }"
                >
                    {{ saving ? 'Saving...' : 'Save' }}
                    <i 
                        class="fas fa-circle-notch fa-spin"
                        v-if="saving"></i>
                </button>
            </div>
        </div>
        <hr class="my-2" />
        <h3>Recent Logins</h3>
        <div class="card" v-if="tokens.length > 0">
            <div class="card-body table-responsive p-0">
                <table class="table table-sm table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Last Login</th>
                            <th>Agent</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(token, index) in tokens" :key="index">
                            <td>
                                {{ token.created_at.format("F d, Y g:i A") }}
                            </td>
                            <td>
                                {{ token.last_used_at.format("F d, Y g:i A") }}
                            </td>
                            <td class="text-truncate">
                                {{ token.login.user_agent }}
                            </td>
                            <td>
                                <app-modal
                                    :classes="[
                                        'btn', 
                                        'btn-tradewind',
                                        'btn-sm',
                                        'btn-flat'
                                    ]"
                                    tag="a"
                                    title="Revoke Token"
                                    :id="`revoketoken${token.id}`"
                                >
                                    <template v-slot:name>
                                        <i class="fas fa-trash"></i>
                                        Revoke
                                    </template>
                                    <template v-slot:body>
                                        <div class="lato-light pre">Are you sure you want to revoke this token?</div>
                                        <div class="lato-light pre">This will log you out of the device this token is logged in.</div>
                                    </template>
                                    <template v-slot:footer>
                                        <button 
                                            class="btn btn-danger btn-sm btn-flat ml-auto mr-1"
                                            :disabled="deletes[index]"
                                            :class="{
                                                disabled: deletes[index]
                                            }"
                                            @click.prevent.stop="revoke(index)"
                                        >
                                            {{ deletes[index] ? 'Revoking...' : 'Confirm' }}
                                            <i 
                                                class="fas fa-circle-notch fa-spin" 
                                                v-if="deletes[index]"
                                            ></i>
                                        </button>
                                    </template>
                                </app-modal>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import Vue from "vue";
import Component from "vue-class-component";
import { Action, Getter } from "vuex-class";

import { Token, User, Detail, Login } from "@classes/Models";

import Input from "@components/Forms/Input.vue";
import Select from "@components/Forms/Select.vue";
import Modal from '@components/Modal.vue';

@Component({
    components: {
        formInput: Input,
        formSelect: Select,
        appModal: Modal
    }
})
export default class ProfileSettingsComponent extends Vue {
    @Action toggleContentHeader: any;
    @Action login: any;
    form = {} as any;
    tokens: Array<Token> = [];
    deletes: Array<boolean> = [];
    saving = false;
    created() {
        const user = Session.user() as User;
        (user.detail as any).birthday = (user.detail as Detail).birthday.format(
            "Y-m-d"
        );
        this.form = { ...user };
        const id = Number((Session.token() as string).split("|")[0]);
        this.$store.getters.tokens.forEach((token: Token) => {
            if (id !== token.id) {
                const temp = (token.login as Login).user_agent.split("");
                let count = 0;
                let agent = "";
                temp.forEach((letter, index) => {
                    if (count <= 10) {
                        agent += letter;
                        count++;
                    }
                });
                (token.login as Login).user_agent = agent;
                this.tokens.push(token);
                this.deletes.push(false);
            }
        });
        this.toggleContentHeader(false);
    }
    save() {
        this.saving = true;
        const form = this.form;
        Axios.put(`/user/${(Session.user() as User).id}`, {
            ...form,
            ...form.detail
        })
        .then(response => response.data)
        .then((data: User) => {
            const user = new User(data);
            Session.user(user);
            this.login(user);
            (user.detail as any).birthday = (user.detail as Detail).birthday.format(
                "Y-m-d"
            );
            this.form = { ...user };
            toastr.success('Settings saved.');
            this.saving = false;
        })
        .catch(error => {
            toastr.error('Error saving settings. Please try again later.');
            this.saving = false;
        })
    }
    revoke(index: number) {
        const token = this.tokens[index];
        this.deletes.splice(index, 1, true);
        const modal = $(`#modalrevoketoken${token.id}`);
        Axios.delete(`/auth/tokens/${token.id}`)
        .then(response => {
            if(modal.hasClass('show')) {
                modal.modal('hide');
                modal.on('hidden.bs.modal', e => {
                    this.tokens.splice(index, 1);
                    this.deletes.splice(index, 1);
                    toastr.success('Token revoked.');
                });
            }
            else {
                this.tokens.splice(index, 1);
                this.deletes.splice(index, 1);
                toastr.success('Token revoked.'); 
            }
        })
        .catch(error => {
            this.deletes.splice(index, 1, false);
            toastr.error('Error revoking token. Please try again later.');
        })
    }
}
</script>

<style lang="scss"></style>
