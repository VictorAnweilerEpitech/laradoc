<template>
    <div>
        <admin-template v-if="laraConfig && user" :user="user">
            <!-- Add category -->
            <modal name="modal-add-category">
                <div class="p-4">
                    <h3>Ajouter une documentation</h3>
                    <input v-model="newCategoryName" class="form-control mt-3 mb-2" placeholder="Nom" />
                    <button class="btn btn-sm bg-dark text-white" @click="createCategory">Ajouter</button>
                </div>
            </modal>

            <!-- Update category -->
            <modal name="modal-update-category">
                <div class="p-4">
                    <template v-if="docSelectedModal">
                        <h3>Modification</h3>
                        <input v-model="docSelectedModal.name" class="form-control mt-3 mb-2" placeholder="Nom" />
                        <button class="btn btn-sm bg-dark text-white" @click="updateCategory(docSelectedModal.id)">Modifier</button>
                    </template>
                </div>
            </modal>

            <!-- Delete category -->
            <modal name="modal-delete-category">
                <div class="p-4">
                    <template v-if="docSelectedModal">
                        <h3>Confirmation</h3>
                        <p class="mb-2">Êtes-vous sûr de vouloir supprimer <b>{{docSelectedModal.name}}</b> ?</p>
                        <b-button variant="danger" @click="deleteCategory(docSelectedModal.id)">Supprimer</b-button>
                    </template>
                </div>
            </modal>

            <!-- List categories -->
            <draggable
            :list="documentations.children"
            class="list-group"
            handle=".handle"
            @change="newOrderCategory(documentations.children)"
            >
                <div
                class="list-group-item"
                v-for="(categ, index) in documentations.children"
                :key="'categ-' + index"
                >
                <div>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <i class="handle fas fa-arrows-alt mr-2" style="cursor: grab;"></i>
                            <h4 class="font-weight-light mb-0">
                                <small class="mb-0">{{categ.name}}</small>
                            </h4>
                        </div>
                        <div>
                            <button @click="$router.push({name: 'structure.page.view', params: {id: categ.id}})" class="btn btn-sm btn-primary font-weight-light my-rounded">
                                <i class="fas fa-pen mr-2"></i>Ecrire
                            </button>
                            <button @click="docSelectedModal = categ; $modal.show('modal-update-category')" class="btn btn-sm btn-light font-weight-light my-rounded text-secondary">
                                <i class="fas fa-cog mr-2"></i>Paramètres
                            </button>
                            <button @click="docSelectedModal = categ; $modal.show('modal-delete-category')" class="btn btn-sm btn-danger font-weight-light my-rounded">
                                <i class="fas fa-trash mr-2"></i>Supprimer
                            </button>
                        </div>
                    </div>
                </div>
                </div>
            </draggable>
            <button
            @click="$modal.show('modal-add-category')"
            style="cursor: pointer"
            class="btn btn-success mt-2 px-3 py-1 mr-1 font-weight-light my-rounded"
            >
                <div class="w-100 mb-0">
                    <i class="fas fa-plus mr-2"></i> Créer une documentation
                </div>
            </button>
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
            documentations: {},
            newCategoryName: "",
            docSelectedModal: null
        }
    },

    methods: {
        getStartStructure() {
            axios.post(this.baseUrl + '/structure/browse')
            .then((response) => {
                this.documentations = response.data
            })
        },
        createCategory() {
            axios.post(this.baseUrl + '/structure/create', {
                name: this.newCategoryName,
                parent_id: null
            })
            .then((response) => {
                this.getStartStructure()
                this.newCategoryName = null
                this.$modal.hide('modal-add-category')
            })
        },
        updateCategory(id) {
            axios.post(this.baseUrl + '/structure/' + id + '/update', {
                name: this.docSelectedModal.name,
            })
            .then((response) => {
                this.docSelectedModal = null
                this.getStartStructure()
                this.$modal.hide('modal-update-category')
                this.$toast.success("Modifié");
            })
        },

        deleteCategory(id) {
            axios.post(this.baseUrl + '/structure/' + id + '/delete')
            .then((response) => {
                this.subCategory = null
                this.getStartStructure()
                this.$modal.hide('modal-delete-category')
                this.$toast.success("Supprimé");
            })
        },
        newOrderCategory(list) {
            axios.post(this.baseUrl + '/structure/change-order', {
                list: list
            })
            .then((response) => {
                this.$toast.success("Modifié");
            })
        },
    },

    mounted() {
        this.getStartStructure()
    }
}
</script>
