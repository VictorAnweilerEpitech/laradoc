<template>
    <div>
        <admin-template v-if="laraConfig && user" :config="laraConfig" :user="user">
            <!-- Add category -->
            <b-modal id="modal-add-category" hide-header hide-footer>
                <h3>Ajouter une catégorie</h3>
                <input v-model="newCategoryName" class="form-control mt-3 mb-2" placeholder="Nom" />
                <button class="btn btn-sm bg-my-primary text-white" @click="createCategory">Ajouter</button>
            </b-modal>
            <!-- Update category -->
            <b-modal id="modal-update-category" hide-header hide-footer>
                <template v-if="category">
                    <h3>Modification</h3>
                    <input v-model="updateCategoryName" class="form-control mt-3 mb-2" placeholder="Nom" />
                    <button class="btn btn-sm bg-my-primary text-white" @click="updateCategory(category.id)">Modifier</button>
                </template>
            </b-modal>
            <!-- Delete category -->
            <b-modal id="modal-delete-category" hide-header hide-footer>
                <template v-if="category">
                    <h3>Confirmation</h3>
                    <p class="mb-2">Êtes-vous sûr de vouloir supprimer <b>{{category.name}}</b> ?</p>
                    <b-button variant="danger" @click="deleteCategory(category.id)">Supprimer</b-button>
                </template>
            </b-modal>
            <!-- Delete Page -->
            <b-modal id="modal-delete-page" hide-header hide-footer>
                <template v-if="pageSelected">
                    <h3>Confirmation</h3>
                    <p class="mb-2">Êtes-vous sûr de vouloir supprimer <b>{{pageSelected.name}}</b> ?</p>
                    <b-button variant="danger" @click="deletePage(pageSelected.id)">Supprimer</b-button>
                </template>
            </b-modal>
            <!-- Add page -->
            <b-modal id="modal-manage-page" size="xl" hide-header hide-footer>
                <div class="p-3">
                    <h2 class="mb-1">Edition de page</h2>
                    <small>Enregistrement automatique</small>
                    <my-editor
                    class="mt-3"
                    :id="pageSelected && pageSelected.id ? pageSelected.id : null"
                    :parent-id="category && category.id ? category.id : null"
                    @new-page="getPages(category && category.id ? category.id : null)"
                    @change-title="getPages(category && category.id ? category.id : null)"
                    />
                </div>
            </b-modal>

            <!-- Content -->
            <div class="row">
                <div class="col-4">
                    <div class="p-4 bg-light rounded border">
                        <tree :tree-data="tree" @node-click="logClick"></tree>
                    </div>
                </div>
                <div class="col-8">
                    <template v-if="category">
                        <h4>{{category.name}}</h4>
                    </template>
                    <b-button class="bg-my-primary text-white border-my-primary" v-b-modal.modal-add-category>Ajouter une catégorie</b-button>
                    <b-button class="border-my-primary text-my-primary bg-white" v-show="category && category.id" v-b-modal.modal-update-category>Modifier</b-button>
                    <b-button variant="danger" v-show="category && category.id" v-b-modal.modal-delete-category>Supprimer</b-button>

                    <div v-if="category && category.id && pages" class="mt-3">
                        <b-button class="btn btn-success" @click="pageSelected = null" v-b-modal.modal-manage-page>
                            <small>
                                Ajouter une page
                            </small>
                        </b-button>
                        <table class="table mt-3 border bg-white" v-if="pages.length > 0">
                            <thead>
                                <tr>
                                    <th scope="col">Nom</th>
                                    <th scope="col text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template v-for="(page, index) in pages">
                                    <tr :key="index">
                                        <td class="bg-white">{{page.name}}</td>
                                        <td class="text-right">
                                            <b-button size="sm" v-b-modal.modal-manage-page class="btn bg-white border text-dark" @click="pageSelected = page">
                                                <i class="fas fa-eye"></i> Voir
                                            </b-button>
                                            <b-button size="sm" v-b-modal.modal-delete-page class="btn bg-danger border text-white" @click="pageSelected = page">
                                                <i class="fas fa-trash"></i> Supprimer
                                            </b-button>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                        <div class="mt-3 bg-white rounded border p-3" v-if="pages.length <= 0">
                            Aucune page
                        </div>
                    </div>
                </div>
            </div>
        </admin-template>
    </div>
</template>

<script>
import AdminTemplate from './Template'
import BaseComponent from './BaseComponent'

import Tree from './../Components/Tree'
import MyEditor from '../Components/MyEditor.vue'

export default {
    name: 'admin-structure',
    extends: BaseComponent,

    components: {
        AdminTemplate,
        Tree,
        MyEditor,
    },

    data() {
        return {
            tree: {},
            category: null,
            newCategoryName: "",
            updateCategoryName: "",
            pages: [],
            pageSelected: null
        }
    },

    watch: {
        category: function(value) {
            this.updateCategoryName = value.name
        }
    },

    methods: {
        logClick(node) {
            if (node.id) {
                this.getCategory(node.id);
            } else {
                this.category = this.tree[0]
            }
        },

        getStructure() {
            axios.post(this.baseUrl + '/structure/browse')
            .then((response) => {
                this.tree = response.data
            })
        },

        getCategory(id) {
            this.pages = []
            axios.post(this.baseUrl + '/structure/' + id + '/voir')
            .then((response) => {
                this.category = response.data
                this.getPages(id)
            })
        },

        getPages(categoryId) {
            axios.post(this.baseUrl + '/page/browse/category/' + categoryId)
            .then((response) => {
                this.pages = response.data
            })
        },

        createCategory() {
            axios.post(this.baseUrl + '/structure/create', {
                name: this.newCategoryName,
                parent_id: this.category && this.category.id ? this.category.id : null
            })
            .then((response) => {
                this.newCategoryName = ""
                this.getStructure()
                this.$bvModal.hide('modal-add-category')
            })
        },

        updateCategory(id) {
            axios.post(this.baseUrl + '/structure/' + id + '/update', {
                name: this.updateCategoryName,
            })
            .then((response) => {
                this.updateCategoryName = ""
                this.getStructure()
                this.getCategory(id)
                this.$bvModal.hide('modal-update-category')
            })
        },

        deleteCategory(id) {
            axios.post(this.baseUrl + '/page/' + id + '/delete')
            .then((response) => {
                this.category = null
                this.getStructure()
                this.$bvModal.hide('modal-delete-category')
            })
        },

        deletePage(id) {
            axios.post(this.baseUrl + '/page/' + id + '/delete')
            .then((response) => {
                this.getPages(this.category.id)
                this.$bvModal.hide('modal-delete-page')
            })
        }
    },
    mounted() {
        this.getStructure()
    }
}
</script>
