<template>
    <node-view-wrapper class="tip-tap-request-editor">
        <div class="vue-component">
            <span class="label">Requête</span>

            <div class="content">
                <div class="bg-light border rounded p-3 mb-3">
                    <div class="text-secondary font-weight-light mb-2">1 - Nom du bouton</div>
                    <div class="row">
                        <div class="col-12">
                            <input class="form-control" type="text" placeholder="Essayer la requête" v-model="node.attrs.label">
                        </div>
                    </div>
                </div>
                <div class="bg-light border rounded p-3 mb-3">
                    <div class="text-secondary font-weight-light mb-2">2 - Information de l'url</div>
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
                    <div class="text-secondary font-weight-light mb-2">3 - Contenu du header de la requête</div>
                    <div class="row mb-2" v-for="(inp, index) in header" :key="'input-header-' + index">
                        <div class="col-3">
                            <small>Editable par le lecteur</small><br />
                            <input style="width: auto; transform: scale(1.5);" class="form-control float-left" v-model="inp.edit" type="checkbox">
                        </div>
                        <div class="col-3">
                            <small>Nom dans la requête</small>
                            <input class="form-control" v-model="inp.label" placeholder="Clé" type="text">
                        </div>
                        <div class="col-4">
                            <small>Valeur par défaut</small>
                            <input class="form-control" v-model="inp.value.value" placeholder="Valeur" :type="inp.value.type">
                        </div>
                        <div class="col-1">
                            <small>Retirer</small>
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
                    <div class="text-secondary font-weight-light mb-2">4 - Contenu de la requête</div>
                    <div class="row mb-2" v-for="(inp, index) in body" :key="'input-body-' + index">
                        <div class="col-3">
                            <small>Editable par le lecteur</small><br />
                            <input style="width: auto; transform: scale(1.5);" class="form-control float-left" v-model="inp.edit" type="checkbox">
                        </div>
                        <div class="col-3">
                            <small>Nom dans la requête</small>
                            <input class="form-control" v-model="inp.label" placeholder="Clé" type="text">
                        </div>
                        <div class="col-4">
                            <small>Valeur par défaut</small>
                            <input class="form-control" v-model="inp.value.value" placeholder="Valeur" :type="inp.value.type">
                        </div>
                        <div class="col-1">
                            <small>Retirer</small>
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
                    <div class="text-secondary font-weight-light mb-2">5 - Tester la requête</div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <request-button-sender
                            :url="node.attrs.url"
                            :type="node.attrs.type"
                            :body="body"
                            :header="header"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </node-view-wrapper>
</template>

<script>
import { NodeViewWrapper, nodeViewProps } from '@tiptap/vue-2'
import RequestButtonSender from './RequestButtonSender.vue'

export default {
    props: nodeViewProps,

    components: {
        NodeViewWrapper,
        RequestButtonSender
    },

    watch: {
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
            body: [],
            header: []
        }
    },

    methods: {
        removeInputHeader(index) {
            this.header.splice(index, 1);
        },

        addInputHeader() {
            this.header.push({
                label: "",
                value: {
                    type: 'text',
                    value: null,
                    edit: true,
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
                    value: null,
                    edit: true,
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
.tip-tap-request-editor {

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
}
</style>
