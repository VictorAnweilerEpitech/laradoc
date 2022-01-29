<template>
    <div>
        <button class="btn rounded mb-2" :class="btnClass || 'btn-primary'" @click="sendRequest">
            <span v-if="!requestLoading">
                {{btnLabel || 'Tester la requête'}}
            </span>
            <div v-if="requestLoading" class="spinner-border spinner-border-sm" role="status"></div>
        </button>
        <div v-if="resultSuccess" class="alert alert-success" role="alert">
            <div class="text-right mb-2 d-flex justify-content-between align-items-center" style="cursor: pointer">
                <b>Succès</b>
                <small @click="resultSuccess = null">
                    <i class="fas fa-times"></i>
                </small>
            </div>
            {{resultSuccess}}
        </div>
        <div v-if="resultError" class="alert alert-danger" role="alert">
            <div class="text-right mb-1 d-flex justify-content-between align-items-center" style="cursor: pointer">
                <b>Erreur</b>
                <small @click="resultError = null">
                    <i class="fas fa-times"></i>
                </small>
            </div>
            <div class="font-weight-light">
                <ul>
                    <li v-for="(error, indexError) in resultError" :key="'error-' + indexError">
                        {{error}}
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios'
export default {
    props: {
        type: {
            type: String,
            required: true
        },
        url: {
            type: String,
            required: true
        },
        body: {
            type: Array,
            default: []
        },
        header: {
            type: Array,
            default: []
        },
        btnClass: {
            type: String
        },
        btnLabel: {
            type: String
        }
    },

    watch: {
        resultSuccess: function(value) {
            if (value) {
                this.resultError = null
            }
        },
        resultError: function(value) {
            if (value) {
                this.resultSuccess = null
            }
        },
    },

    data() {
        return {
            requestLoading: false,
            resultError: null,
            resultSuccess: null,
        }
    },

    methods: {
        getRequest() {
            this.requestLoading = true
            axios.get(this.url, this.getOnlyHeaderRequest())
            .then((response) => {
                this.resultSuccess = response.data
                this.requestLoading = false
            })
            .catch((error) => {
                this.resultError = [error, error.response.data.message]
                this.requestLoading = false
            })
        },

        postRequest() {
            this.requestLoading = true
            axios.post(this.url, this.getOnlyBodyRequest(), this.getOnlyHeaderRequest())
            .then((response) => {
                this.resultSuccess = response.data
                this.requestLoading = false
            })
            .catch((error) => {
                this.resultError = [error, error.response.data.message]
                this.requestLoading = false
            })
        },

        sendRequest() {
            if (this.url) {
                if (this.type == 'get') {
                    this.getRequest()
                }
                if (this.type == 'post') {
                    this.postRequest()
                }
            } else {
                this.resultError = ["Url introuvable"]
            }
        },

        getOnlyBodyRequest() {
            let endObj = {}
            this.body.forEach((inp) => {
                if (inp.label && inp.value.value) {
                    endObj[inp.label] = inp.value.value
                }
            })
            return endObj
        },

        getOnlyHeaderRequest() {
            let endObj = {}
            this.header.forEach((inp) => {
                if (inp.label && inp.value.value) {
                    endObj[inp.label] = inp.value.value
                }
            })
            return endObj
        },
    }
}
</script>
