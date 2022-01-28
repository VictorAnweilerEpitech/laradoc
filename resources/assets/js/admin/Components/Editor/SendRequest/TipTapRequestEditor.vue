<template>
    <node-view-wrapper class="vue-component">
        <span class="label">Tester</span>

        <div class="content">
            <select class="form-control mb-2 rounded col-2" v-model="node.attrs.type">
                <option value="get">GET</option>
                <option value="post">POST</option>
            </select>
            <div class="alert alert-secondary" role="alert">
                {{node.attrs.url}}
            </div>
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
                <div class="text-right mb-2 d-flex justify-content-between align-items-center" style="cursor: pointer">
                    <b>Erreur</b>
                    <small @click="resultError = null">
                        <i class="fas fa-times"></i>
                    </small>
                </div>
                {{resultError}}
            </div>
            <button class="btn btn-primary my-rounded" @click="sendRequest">
                Tester la requête
            </button>
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
        resultSuccess: function(value) {
            if (value) {
                this.resultError = null
            }
        },
        resultError: function(value) {
            if (value) {
                this.resultSuccess = null
            }
        }
    },

    data() {
        return {
            resultSuccess: null,
            resultError: null,
        }
    },

    methods: {
        getRequest() {
            axios.get(this.node.attrs.url)
            .then((response) => {
                this.resultSuccess = response.data
            })
            .catch((error) => {
                this.resultError = error
            })
        },
        postRequest() {
            axios.post(this.node.attrs.url, {
                email: "victor.anweiler@epitech.eu",
                password: "password"
            })
            .then((response) => {
                this.resultSuccess = response.data
            })
            .catch((error) => {
                this.resultError = error
            })
        },

        sendRequest() {
            if (this.node.attrs.type == 'get') {
                this.getRequest()
            }
            if (this.node.attrs.type == 'post') {
                this.postRequest()
            }
        },
    },
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
