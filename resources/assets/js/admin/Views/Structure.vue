<template>
    <div>
        <admin-template v-if="laraConfig && user" :config="laraConfig" :user="user">
            <!-- Add category -->
            <b-modal id="modal-add-category" hide-header hide-footer>
                <h3>Ajouter un chapitre</h3>
                <input v-model="newCategoryName" class="form-control mt-3 mb-2" placeholder="Nom" />
                <button class="btn btn-sm bg-dark text-white" @click="createCategory">Ajouter</button>
            </b-modal>
            <!-- Add sub category -->
            <b-modal id="modal-add-subcategory" hide-header hide-footer>
                <h3>Ajouter une catégorie</h3>
                <input v-model="newSubCategoryName" class="form-control mt-3 mb-2" placeholder="Nom" />
                <button class="btn btn-sm bg-dark text-white" @click="createSubCategory">Ajouter</button>
            </b-modal>
            <!-- Update category -->
            <b-modal id="modal-update-category" hide-header hide-footer>
                <template v-if="subCategorySelectedModal">
                    <h3>Modification</h3>
                    <input v-model="subCategorySelectedModal.name" class="form-control mt-3 mb-2" placeholder="Nom" />
                    <button class="btn btn-sm bg-dark text-white" @click="updateCategory(subCategorySelectedModal.id)">Modifier</button>
                </template>
            </b-modal>
            <!-- Delete category -->
            <b-modal id="modal-delete-category" hide-header hide-footer>
                <template v-if="subCategorySelectedModal">
                    <h3>Confirmation</h3>
                    <p class="mb-2">Êtes-vous sûr de vouloir supprimer <b>{{subCategorySelectedModal.name}}</b> ?</p>
                    <b-button variant="danger" @click="deleteCategory(subCategorySelectedModal.id)">Supprimer</b-button>
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
                <div class="p-3 pb-5">
                    <h2 class="mb-1">Edition de page</h2>
                    <small>Enregistrement automatique</small>
                    <!-- <my-editor
                    class="mt-3"
                    :id="pageSelected && pageSelected.id ? pageSelected.id : null"
                    :parent-id="subCategory && subCategory.id ? subCategory.id : null"
                    @new-page="getPages(subCategory && subCategory.id ? subCategory.id : null)"
                    @change-title="getPages(subCategory && subCategory.id ? subCategory.id : null)"
                    /> -->

                    <my-quill-editor
                    class="mt-3 mb-5"
                    :id="pageSelected && pageSelected.id ? pageSelected.id : null"
                    :parent-id="subCategory && subCategory.id ? subCategory.id : null"
                    @new-page="getPages(subCategory && subCategory.id ? subCategory.id : null)"
                    @change-title="getPages(subCategory && subCategory.id ? subCategory.id : null)"
                    />
                </div>
            </b-modal>

            <!-- Content -->
            <h3 class="mt-2">Gestion du contenu</h3>
            <p class="font-weight-light text-secondary">Contenu de la documentation</p>
            <hr>
            <!-- List categories -->
            <div class="mb-3">
                <div
                v-for="(categ, index) in startData.children"
                :key="'categ-' + index"
                class="d-inline-block text-center">
                    <span
                    @click="getCategory(categ.id); categorySelected = categ"
                    style="cursor: pointer; padding-bottom: 6px;"
                    class="px-3 pt-1 mr-1 font-weight-light rounded-pill"
                    :class="categorySelected && categorySelected.id == categ.id ? 'bg-secondary text-white' : 'bg-light text-secondary'"
                    >
                        <small class="w-100 mb-0">{{categ.name}}</small>
                    </span>
                </div>
                <span
                @click="$bvModal.show('modal-add-category')"
                style="cursor: pointer"
                class="px-3 py-1 mr-1 font-weight-light my-rounded"
                >
                    <small class="w-100 mb-0">
                        <i class="fas fa-plus"></i>
                    </small>
                </span>
            </div>

            <div class="row" v-if="subCategory">
                <div class="mb-3 d-flex align-items-center" v-if="subCategory">
                    <div class="mr-2">
                        <!-- <button class="btn btn-sm text-dark" @click="subCategorySelectedModal = {...categorySelected}; $bvModal.show('modal-update-category')">
                            <i class="fas fa-ellipsis-v"></i>
                        </button> -->
                        <!-- <button class="btn btn-sm bg-light border-light text-danger" @click="subCategorySelectedModal = {...categorySelected}; $bvModal.show('modal-delete-category')">
                            <i class="fas fa-trash"></i>
                        </button> -->

                        <b-dropdown variant="light" size="sm">
                            <template #button-content>
                                <!-- <i class="fas fa-ellipsis-v"></i> -->
                            </template>
                            <b-dropdown-item>
                                <button class="btn btn-sm text-dark" @click="subCategorySelectedModal = {...categorySelected}; $bvModal.show('modal-update-category')">
                                    Editer
                                </button>
                            </b-dropdown-item>
                            <b-dropdown-item>
                                <button class="btn btn-sm text-danger" @click="subCategorySelectedModal = {...categorySelected}; $bvModal.show('modal-delete-category')">
                                    Supprimer
                                </button>
                            </b-dropdown-item>
                        </b-dropdown>
                    </div>
                    <div class="d-flex align-items-center">
                        <button class="btn btn-sm" v-if="subCategory.parent_id" @click="getCategory(subCategory.parent_id)">
                            <i class="fas fa-arrow-left"></i>
                        </button>
                        <h4 class="mb-0">{{subCategory.name}}</h4>
                    </div>
                </div>
                <div class="col-4">
                    <div
                    style="cursor: pointer"
                    class="p-2 border-bottom"
                    v-for="(child, index) in subCategory.children"
                    :key="'child-menu-' + index"
                    >
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="flex-fill" @click="getCategory(child.id)">
                                {{child.name}}
                            </div>
                            <div>
                                <button class="btn btn-sm bg-light border-light text-dark" @click="subCategorySelectedModal = {...child}; $bvModal.show('modal-update-category')">
                                    <i class="fas fa-pen"></i>
                                </button>
                                <button class="btn btn-sm bg-light border-light text-danger" @click="subCategorySelectedModal = {...child}; $bvModal.show('modal-delete-category')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div v-if="subCategory.children.length <= 0" class="p-2 text-secondary font-weight-light">
                        <small class="text-secondary font-weight-light">Aucune catégorie</small>
                    </div>
                    <b-button size="sm" class="bg-dark mt-2" v-b-modal.modal-add-subcategory>
                        <small>
                            Ajouter <i class="fas fa-plus ml-1"></i>
                        </small>
                    </b-button>
                </div>
                <div class="col-8">
                    <div v-if="subCategory && subCategory.id" class="mt-3">
                        <table class="table mt-3 border bg-white">
                            <thead>
                                <tr>
                                    <th scope="col">Nom</th>
                                    <th scope="col text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template v-for="(page, index) in pages">
                                    <tr :key="index">
                                        <td class="bg-white" v-b-modal.modal-manage-page @click="pageSelected = page">{{page.name}}</td>
                                        <td class="text-right">
                                            <b-button size="sm" v-b-modal.modal-delete-page class="btn bg-light border-light text-danger" @click="pageSelected = page">
                                                <i class="fas fa-trash"></i>
                                            </b-button>
                                        </td>
                                    </tr>
                                </template>
                                <tr v-if="pages.length <= 0">
                                    <td>
                                        <small class="text-secondary font-weight-light">Aucune page</small>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td class="text-right">
                                        <b-button class="btn btn-dark btn-sm" @click="pageSelected = null" v-b-modal.modal-manage-page>
                                            <small>
                                                Ajouter <i class="fas fa-plus ml-1"></i>
                                            </small>
                                        </b-button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </admin-template>
    </div>
</template>

<script>
import AdminTemplate from './Template'
import BaseComponent from './../../default/Components/BaseComponent'

import Tree from './../Components/Tree'
import MyEditor from '../Components/MyEditor.vue'

import MyQuillEditor from './../Components/MyQuillEditor.vue'

export default {
    name: 'admin-structure',
    extends: BaseComponent,

    components: {
        AdminTemplate,
        Tree,
        MyEditor,
        MyQuillEditor
    },

    data() {
        return {
            startData: {},
            category: null,
            subCategory: null,
            newCategoryName: "",
            newSubCategoryName: "",
            pages: [],
            categorySelected: null,
            subCategorySelectedModal: null,
            pageSelected: null,
        }
    },

    // watch: {
    //     category: function(value) {
    //         this.getPages(value.id)
    //     }
    // },

    methods: {
        // logClick(node) {
        //     if (node.id) {
        //         this.getCategory(node.id);
        //     } else {
        //         this.category = this.tree[0]
        //     }
        // },

        getStartStructure() {
            axios.post(this.baseUrl + '/structure/browse')
            .then((response) => {
                this.startData = response.data
            })
        },

        getCategory(id) {
            this.pages = []
            if (id) {
                axios.post(this.baseUrl + '/structure/' + id + '/voir')
                .then((response) => {
                    this.subCategory = response.data
                    this.getPages(id)
                })
            } else {
                // this.listCateg = this.startData.children
            }
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
                parent_id: null
            })
            .then((response) => {
                this.getStartStructure()
                this.newCategoryName = null
                this.$bvModal.hide('modal-add-category')
            })
        },

        createSubCategory() {
            let copySubCategory = this.subCategory
            axios.post(this.baseUrl + '/structure/create', {
                name: this.newSubCategoryName,
                parent_id: this.subCategory && this.subCategory.id ? this.subCategory.id : null
            })
            .then((response) => {
                this.getCategory(copySubCategory.id)
                this.newSubCategoryName = null
                this.$bvModal.hide('modal-add-subcategory')
            })
        },

        updateCategory(id) {
            axios.post(this.baseUrl + '/structure/' + id + '/update', {
                name: this.subCategorySelectedModal.name,
            })
            .then((response) => {
                this.subCategorySelectedModal = null
                this.getStartStructure()
                this.getCategory(id)
                this.$bvModal.hide('modal-update-category')
            })
        },

        deleteCategory(id) {
            console.log(id);
            axios.post(this.baseUrl + '/structure/' + id + '/delete')
            .then((response) => {
                this.subCategory = null
                this.getStartStructure()
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
        this.getStartStructure()
    }
}
</script>
