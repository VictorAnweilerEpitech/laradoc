<template>
    <node-view-wrapper class="vue-component">
        <span class="label">Requête</span>

        <div class="content">
            <div class="bg-light border rounded p-3 mb-3">
                <div class="text-secondary font-weight-light mb-2">1 - Information de l'url</div>
                <div class="row">
                    <div class="col-3">
                        <select class="form-control rounded" v-model="node.attrs.type">
                            <option value="get">GET</option>
                            <option value="post">POST</option>
                        </select>
                    </div>
                    <div class="col-9">
                        <input class="form-control" type="text" placeholder="Url" v-model="node.attrs.url">
                    </div>
                </div>
            </div>
            <div class="bg-light border rounded p-3 mb-3">
                <div class="text-secondary font-weight-light mb-2">2 - Contenu du header de la requête</div>
                <div class="row mb-2" v-for="(inp, index) in header" :key="'input-header-' + index">
                    <div class="col-4">
                        <input class="form-control" v-model="inp.label" placeholder="Clé" type="text">
                    </div>
                    <div class="col-6">
                        <input class="form-control" v-model="inp.value.value" placeholder="Valeur" :type="inp.value.type">
                    </div>
                    <div class="col-1">
                        <button class="btn btn-danger" @click="removeInputHeader(index)">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-3">
                        <button class="btn btn-success" @click="addInputHeader()">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="bg-light border rounded p-3 mb-3">
                <div class="text-secondary font-weight-light mb-2">3 - Contenu de la requête</div>
                <div class="row mb-2" v-for="(inp, index) in body" :key="'input-body-' + index">
                    <div class="col-4">
                        <input class="form-control" v-model="inp.label" placeholder="Clé" type="text">
                    </div>
                    <div class="col-6">
                        <input class="form-control" v-model="inp.value.value" placeholder="Valeur" :type="inp.value.type">
                    </div>
                    <div class="col-1">
                        <button class="btn btn-danger" @click="removeInputBody(index)">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-3">
                        <button class="btn btn-success" @click="addInputBody()">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="bg-light border rounded p-3 mb-3">
                <div class="text-secondary font-weight-light mb-2">4 - Tester la requête</div>
                <div class="row mt-3">
                    <div class="col-12">
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
                        <button class="btn btn-primary rounded" @click="sendRequest">
                            <span v-if="!requestLoading">
                                Tester la requête
                            </span>
                            <div v-if="requestLoading" class="spinner-border spinner-border-sm" role="status"></div>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </node-view-wrapper>
</template>

<script>
import { NodeViewWrapper, nodeViewProps } from '@tiptap/vue-2'
import axios from 'axios'

export default {
    props: nodeViewProps,

    components: {
        NodeViewWrapper,
    },

    watch: {
        editMode: function() {
            this.resultError = null
            this.resultSuccess = null
        },

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
        body: {
            deep: true,
            handler(value) {
                this.node.attrs.body = JSON.stringify(value)
            }
        },
        header: {
            deep: true,
            handler(value) {
                this.node.attrs.header = JSON.stringify(value)
            }
        }
    },

    data() {
        return {
            resultSuccess: null,
            resultError: null,
            editMode: true,
            body: [],
            header: [],
            requestLoading: false
        }
    },

    methods: {
        getRequest() {
            this.requestLoading = true
            axios.get(this.node.attrs.url, this.getOnlyHeaderRequest())
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
            axios.post(this.node.attrs.url, this.getOnlyBodyRequest(), this.getOnlyHeaderRequest())
            .then((response) => {
                this.resultSuccess = response.data
                this.requestLoading = false
            })
            .catch((error) => {
                this.resultError = [error, error.response.data.message]
                this.requestLoading = false
            })
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

        sendRequest() {
            if (this.node.attrs.url) {
                if (this.node.attrs.type == 'get') {
                    this.getRequest()
                }
                if (this.node.attrs.type == 'post') {
                    this.postRequest()
                }
            } else {
                this.resultError = ["Url introuvable"]
            }
        },

        removeInputHeader(index) {
            this.header.splice(index, 1);
        },

        addInputHeader() {
            this.header.push({
                label: "",
                value: {
                    type: 'text',
                    value: null
                }
            })
        },

        removeInputBody(index) {
            this.body.splice(index, 1);
        },

        addInputBody() {
            this.body.push({
                label: "",
                value: {
                    type: 'text',
                    value: null
                }
            })
        }
    },

    mounted() {
        this.body = JSON.parse(this.node.attrs.body)
        this.header = JSON.parse(this.node.attrs.header)
    }
}
</script>

<style lang="scss">
.vue-component {
  border: 2px solid #0D0D0D;
  border-radius: 0.5rem;
  margin: 1rem 0;
  position: relative;
}

.label {
  margin-left: 1rem;
  background-color: #0D0D0D;
  font-size: 0.6rem;
  letter-spacing: 1px;
  font-weight: bold;
  text-transform: uppercase;
  color: #fff;
  position: absolute;
  top: 0;
  padding: 0.25rem 0.75rem;
  border-radius: 0 0 0.5rem 0.5rem;
}

.content {
  margin-top: 1.5rem;
  padding: 1rem;
}
</style>
