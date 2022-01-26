<template>
    <div>
        <admin-template v-if="laraConfig && user" :config="laraConfig" :user="user">
            <h3 class="mt-2">Gestion des membres</h3>
            <p class="font-weight-light text-secondary">Liste des utilisateurs aillant accès à la documentation</p>
            <hr>
            <template v-if="memberAllows.length > 0">
                <h6 class="mt-3 text-dark">
                    <i class="fas fa-check text-success mr-2"></i>Autorisés
                </h6>
                <table class="table mt-3 border bg-light">
                    <thead>
                        <tr>
                            <th scope="col">Identifiant</th>
                            <th scope="col">Administrateur</th>
                            <th scope="col text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template v-for="(member, index) in memberAllows">
                            <tr :key="index">
                                <td>{{member.user[laraConfig.auth.loginColumn]}}</td>
                                <td>
                                    <input type="checkbox" @change="setPermission(member)" v-model="member.admin">
                                </td>
                                <td class="text-right">
                                    <b-button size="sm" class="btn bg-danger border text-white" @click="removeMember(member.user)">
                                        <i class="fas fa-trash"></i> Supprimer
                                    </b-button>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </template>

            <template v-if="membersNotAllows.length > 0">
                <h6 class="mt-5 text-dark">
                    <i class="fas fa-times text-danger mr-2"></i>Non autorisés
                </h6>
                <table class="table mt-3 border bg-light">
                    <thead>
                        <tr>
                            <th scope="col">Identifiant</th>
                            <th scope="col text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template v-for="(member, index) in membersNotAllows">
                            <tr :key="index">
                                <td>{{member[laraConfig.auth.loginColumn]}}</td>
                                <td class="text-right">
                                    <b-button size="sm" class="btn bg-success border text-white" @click="authorizeMember(member)">
                                        <i class="fas fa-check"></i> Autoriser
                                    </b-button>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </template>
        </admin-template>
    </div>
</template>

<script>
import BaseComponent from './../../default/Components/BaseComponent'
import AdminTemplate from './Template'

import axios from 'axios'

export default {
    name: 'admin-members',
    extends: BaseComponent,

    components: {
        AdminTemplate,
    },

    data() {
        return {
            membersNotAllows: [],
            memberAllows: [],
        }
    },

    methods: {
        async getUsersNotAllow() {
            let response = await axios.post(this.baseUrl + '/member/browse/not-allow')
            this.membersNotAllows = response.data
        },

        async getUsersAllow() {
            let response = await axios.post(this.baseUrl + '/member/browse/allow')
            this.memberAllows = response.data
        },

        initData() {
            this.getUsersAllow()
            this.getUsersNotAllow()
        },

        async authorizeMember(member) {
            await axios.post(this.baseUrl + '/member/allow/' + member.id)
            this.initData()
        },

        async removeMember(member) {
            await axios.post(this.baseUrl + '/member/remove-allow/' + member.id)
            this.initData()
        },

        async setPermission(member) {
            await axios.post(this.baseUrl + '/member/change-permission/' + member.user.id, {
                admin: member.admin
            })
            this.initData()
        }
    },

    mounted() {
        this.initData()
    }
}
</script>
