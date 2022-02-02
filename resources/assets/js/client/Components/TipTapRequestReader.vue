<template>
    <div class="border rounded p-3 bg-light">
        <div class="d-flex align-items-center justify-content-between" @click="tryRequest = !tryRequest">
            <h6 class="font-weight-light mb-0">
                <span class="mr-2">🚀</span>
                {{ label || 'Essayer la requête'}}
            </h6>
            <div v-show="tryRequest">
                <i class="fas fa-chevron-up"></i>
            </div>
            <div v-show="!tryRequest">
                <i class="fas fa-chevron-down"></i>
            </div>
        </div>
        <div v-show="tryRequest">
            <hr class="my-3">
            <small class="font-weight-light text-secondary d-block mb-1">Url</small>
            <div class="alert alert-secondary mb-2" role="alert">
                <div class="d-flex align-items-center justify-content-between">
                    <span class="font-weight-light">{{url}}</span>
                    <span class="badge bg-secondary text-white">{{type}}</span>
                </div>
            </div>
            <template v-if="headerRequest && headerRequest.length > 0">
                <small class="font-weight-light text-secondary d-block mb-1">Header</small>
                <table class="table table-bordered bg-white mb-0">
                    <thead>
                        <tr>
                            <th scope="col">Nom</th>
                            <th scope="col">Type</th>
                            <th scope="col">Exemple</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item, index) in headerRequest" :key="'request-' + item.label + '-' + index">
                            <td>{{item.label}}</td>
                            <td>
                                <span class="badge text-white bg-my-primary">{{item.value.type}}</span>
                            </td>
                            <td class="font-weight-light text-secondary">
                                <small>{{item.value.value}}</small>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </template>
            <template v-if="bodyRequest && bodyRequest.length > 0">
                <small class="font-weight-light text-secondary d-block mb-1">Paramètres</small>
                <table class="table table-bordered bg-white mb-0">
                    <thead>
                        <tr>
                            <th scope="col">Nom</th>
                            <th scope="col">Type</th>
                            <th scope="col">Exemple</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item, index) in bodyRequest" :key="'request-' + item.label + '-' + index">
                            <td>{{item.label}}</td>
                            <td>
                                <span class="badge text-white bg-my-primary">{{item.value.type}}</span>
                            </td>
                            <td class="font-weight-light text-secondary">
                                <small>{{item.value.value}}</small>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </template>
            <div class="mt-1">
                <small class="font-weight-light text-secondary d-block mb-1">Tester</small>
                <request-button-sender
                :url="url"
                :type="type"
                :body="bodyRequest"
                :header="headerRequest"
                btn-class="btn-dark btn-sm"
                btn-label="Envoyer"
                />
            </div>
        </div>
    </div>
</template>

<script>
import RequestButtonSender from './../../admin/Components/Editor/SendRequest/RequestButtonSender.vue'
export default {
    props: {
        url: {
            type: String,
        },
        type: {
            type: String,
        },
        body: {
            type: String,
        },
        header: {
            type: String,
        },
        label: {
            type: String,
        }
    },

    components: {
        RequestButtonSender
    },

    data() {
        return {
            bodyRequest: null,
            headerRequest: null,
            tryRequest: false
        }
    },

    mounted() {
        if (this.body) {
            this.bodyRequest = JSON.parse(this.body)
        }
        if (this.header) {
            this.headerRequest = JSON.parse(this.header)
        }
    }
}
</script>

<style>
.alert-url {
    border-bottom: 0px !important;
    border-bottom-left-radius: 0px !important;
    border-bottom-right-radius: 0px !important;
}
</style>
