<template>
    <div>
        <admin-template v-if="laraConfig && user" :config="laraConfig" :user="user">
            <!-- Manage group -->
            <b-modal id="modal-manage-group" hide-header hide-footer>
                <template v-if="pageSelected">
                    <h3>Gérer le groupe</h3>
                    <small class="text-secondary">
                        Le groupe est optionnel et permet de grouper plusieurs pages dans une même catégorie.
                        <input class="form-control mt-3" v-model="pageSelected.group" placeholder="Groupe" />
                        <button @click="updateGroup()" class="btn btn-dark mt-3">{{pageSelected.group ? 'Modifier' : 'Ajouter'}}</button>
                    </small>
                </template>
            </b-modal>
            <!-- Add sub category -->
            <b-modal id="modal-add-subcategory" hide-header hide-footer>
                <h3>Ajouter une catégorie</h3>
                <input v-model="newSubCategoryName" class="form-control mt-3 mb-2" placeholder="Nom" />
                <button class="btn btn-sm bg-dark text-white" @click="createSubCategory">Ajouter</button>
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
                    :parent-id="subCategory && subCategory.id ? subCategory.id : null"
                    @new-page="getPages(subCategory && subCategory.id ? subCategory.id : null)"
                    @change-title="getPages(subCategory && subCategory.id ? subCategory.id : null)"
                    />
                </div>
            </b-modal>

            <!-- List categories -->
            <div v-if="!categorySelected">
                <draggable
                :list="startData.children"
                class="list-group"
                :class="pages.length > 0 ? 'mb-2' : ''"
                ghost-class="ghost"
                @change="newOrderCategory(startData.children)"
                >
                    <div
                    class="list-group-item"
                    v-for="(categ, index) in startData.children"
                    :key="'categ-' + index"
                    style="cursor: pointer;"
                    @click="getCategory(categ.id); categorySelected = categ"
                    >
                        <div class="d-inline-block text-center">
                            <span
                            style="padding-bottom: 6px;"
                            class="px-3 pt-1 mr-1 font-weight-light rounded-pill"
                            :class="categorySelected && categorySelected.id == categ.id ? 'bg-secondary text-white' : 'bg-light text-secondary'"
                            >
                                <small class="w-100 mb-0">{{categ.name}}</small>
                            </span>
                        </div>
                    </div>
                </draggable>
                <button
                @click="$bvModal.show('modal-add-category')"
                style="cursor: pointer"
                class="btn btn-dark mt-2 px-3 py-1 mr-1 font-weight-light my-rounded"
                >
                    <small class="w-100 mb-0">
                        Ajouter une catégorie <i class="fas fa-plus ml-2"></i>
                    </small>
                </button>
            </div>

            <template v-if="subCategory">
                <div class="bg-light p-3 rounded border mb-3">
                    <div class="d-flex align-items-center mb-3">
                        <button @click="categorySelected = null; subCategory = null" type="button" class="btn btn-link text-dark">
                            <i class="fas fa-home"></i>
                        </button>
                        <div class="d-flex align-items-center">
                            <button class="btn btn-sm" v-if="subCategory.parent_id" @click="getCategory(subCategory.parent_id)">
                                <i class="fas fa-arrow-left"></i>
                            </button>
                            <h4 class="mb-0">{{subCategory.name}}</h4>
                        </div>
                        <div class="mr-2">
                            <b-dropdown variant="white" size="sm">
                                <template #button-content>
                                    <button type="button" class="btn btn-light">Modifier</button>
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
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <draggable
                            :list="subCategory.children"
                            class="list-group"
                            :class="pages.length > 0 ? 'mb-2' : ''"
                            ghost-class="ghost"
                            @change="newOrderCategory(subCategory.children)"
                            >
                                <div
                                class="list-group-item"
                                v-for="(child, index) in subCategory.children"
                                :key="'child-menu-' + index"
                                >
                                    <div
                                    style="cursor: pointer"
                                    class="p-2"
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
                                </div>
                            </draggable>
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
                            <div v-if="subCategory && subCategory.id">
                                <draggable
                                :list="pages"
                                class="list-group"
                                :class="pages.length > 0 ? 'mb-2' : ''"
                                ghost-class="ghost"
                                @change="newOrderPages"
                                >
                                    <div
                                    class="list-group-item"
                                    v-for="page in pages"
                                    :key="page.id"
                                    >
                                        <div class="d-flex align-items-center">
                                            <div class="flex-fill">
                                                <div>
                                                    {{page.name}}
                                                </div>
                                                <div v-if="page.group" class="badge badge-dark">{{page.group}}</div>
                                                <div v-else class="badge badge-secondary">Autre</div>
                                            </div>
                                            <div>
                                                <b-button size="sm" v-b-modal.modal-manage-page class="btn bg-light border-light text-dark" @click="pageSelected = page">
                                                    <i class="fas fa-eye"></i>
                                                </b-button>
                                                <b-button size="sm" v-b-modal.modal-manage-group class="btn bg-light border-light text-dark" @click="pageSelected = page">
                                                    <i class="fa-solid fa-layer-group"></i>
                                                </b-button>
                                                <b-button size="sm" v-b-modal.modal-delete-page class="btn bg-light border-light text-danger" @click="pageSelected = page">
                                                    <i class="fas fa-trash"></i>
                                                </b-button>
                                            </div>
                                        </div>
                                    </div>
                                </draggable>
                                <div class="bg-white d-flex align-items-center justify-content-between bg-light border rounded p-3 text-right">
                                    <div class="font-weight-bold">
                                        Ajouter une nouvelle page
                                    </div>
                                    <b-button class="btn btn-success btn-sm" @click="pageSelected = null" v-b-modal.modal-manage-page>
                                        <i class="fas fa-plus"></i>
                                    </b-button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </admin-template>
    </div>
</template>

<script>
import AdminTemplate from './Template'
import BaseComponent from './../../default/Components/BaseComponent'

import Tree from './../Components/Tree'
import MyEditor from '../Components/Editor/TipTapEditor.vue'

import draggable from 'vuedraggable'

export default {
    name: 'admin-structure',
    extends: BaseComponent,

    components: {
        AdminTemplate,
        Tree,
        MyEditor,
        draggable,
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

        deletePage(id) {
            axios.post(this.baseUrl + '/page/' + id + '/delete')
            .then((response) => {
                this.getPages(this.category.id)
                this.$bvModal.hide('modal-delete-page')
            })
        },

        updateGroup() {
            axios.post(this.baseUrl + '/page/' + this.pageSelected.id + '/group', {
                group: this.pageSelected.group
            })
            .then((response) => {
                this.getPages(this.category.id)
                this.$bvModal.hide('modal-manage-group')
                this.pageSelected = null
            })
        },

        newOrderPages(result) {
            axios.post(this.baseUrl + '/page/change-order', {
                list: this.pages
            })
            .then((response) => {
            })
        },
    },
    mounted() {
        this.getStartStructure()
    }
}
</script>
