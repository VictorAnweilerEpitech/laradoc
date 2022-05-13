<template>
    <div>
        <admin-template v-if="laraConfig && user" :config="laraConfig" :user="user">
            <!-- Delete Page -->
            <modal name="modal-delete-page">
                <div class="p-4">
                    <template v-if="pageSelected">
                        <h3>Confirmation</h3>
                        <p class="mb-2">Êtes-vous sûr de vouloir supprimer <b>{{pageSelected.name}}</b> ?</p>
                        <b-button variant="danger" @click="deletePage(pageSelected.id)">Supprimer</b-button>
                    </template>
                </div>
            </modal>

            <div class="container">
                <div class="row">
                    <div class="col-4">
                        <div class="pt-3" v-if="category">
                            <h1>{{category.name}}</h1>
                            <hr v-if="category.parent_id" />
                            <ul class="pl-0 mb-0" style="list-style-type: none;">
                                <li style="cursor: pointer" class="js-btn" @click="navigateOtherPage({name: 'structure.page.view', params: {id: category.parent_id}})" v-if="category.parent_id">
                                    <i class="fas fa-arrow-left mr-2"></i>Retour
                                </li>
                                <li style="cursor: pointer" @click="navigateOtherPage({name: 'structure.page.view', params: {id: child.id}})" v-for="(child, childIndex) in category.children" :key="'child-' + childIndex" class="js-btn">
                                    <i class="fas fa-external-link-square-alt mr-2"></i>{{child.name}}
                                </li>
                            </ul>
                        </div>
                        <hr>
                        <div class="doc_nav">
                            <draggable
                            :list="pages"
                            class="list-group"
                            handle=".handle"
                            @change="newOrderPages"
                            >
                                <div
                                class="mb-2 border-0 p-0 list-group-item"
                                style="cursor: pointer"
                                @click="pageSelected = page"
                                v-for="(page, pageIndex) in pages"
                                :key="'page-' + pageIndex"
                                :style="pageSelected && pageSelected.id == page.id ? 'color:' + $laraConfig.color : ''"
                                >
                                    <small><i class="handle fas fa-arrows-alt mr-2 text-secondary" style="cursor: grab; opacity: 0.5"></i></small>
                                    {{page.name}}
                                </div>
                            </draggable>
                            <div
                            style="cursor: pointer"
                            :style="pageSelected && !pageSelected.id ? 'color:' + $laraConfig.color : ''"
                            @click="initNewPage"
                            >
                                <small><i class="handle fas fa-plus mr-2 text-secondary" style="opacity: 0.5"></i></small>
                                Nouvelle page
                            </div>
                                <!-- @if (isset($category))
                                    @foreach ($pages as $indexCateg => $categoryPage)
                                    <div class="mb-5">
                                        @if (!$indexCateg && count($pages) > 1)
                                            <div class="font-weight-bold mb-3">Autre</div>
                                        @else
                                            <div class="font-weight-bold mb-3">{{$indexCateg}}</div>
                                        @endif
                                        @foreach ($categoryPage as $indexPage => $page)
                                            <li class="d-flex align-items-center js-btn mb-3 {{$indexPage == 0 ? 'selected' : ''}} pr-5" style="cursor: pointer">
                                                <div class="square-selected"></div>
                                                {{$page->name}}
                                            </li>
                                        @endforeach
                                    </div>
                                    @endforeach
                                @endif
                                @if (count($pages) <= 0)
                                    <small class="font-weight-light text-secondary">
                                        Aucune page
                                    </small>
                                @endif -->
                            <!-- </ul> -->
                        </div>
                    </div>
                    <div class="col-8">
                        <div class="mt-3" v-if="pageSelected">
                            <div class="mb-3 d-flex align-items-center justify-content-between border-bottom pb-3">
                                <multiselect
                                class="w-50"
                                v-model="pageSelected.group"
                                tag-placeholder="Catégorie menu"
                                placeholder="Catégorie menu"
                                :options="tagsList"
                                :taggable="true"
                                @tag="createTag"
                                @input="linkTag"
                                />
                                <div class="ml-2">
                                    <button @click="pageEdition = true" type="button" :class="pageEdition ? 'btn-dark' : 'btn-light'" class="btn btn-sm">
                                        Edition
                                    </button>
                                    <button @click="pageEdition = false" type="button" :class="!pageEdition ? 'btn-dark' : 'btn-light'" class="btn btn-sm">
                                        Voir
                                    </button>
                                    <span class="ml-2">
                                        <button @click="$modal.show('modal-delete-page')" type="button" class="btn btn-danger btn-sm">
                                            Supprimer
                                        </button>
                                    </span>
                                </div>
                            </div>

                            <div v-if="!pageEdition" class="doc-reader">
                                <div v-html="pageSelected.content"></div>
                            </div>
                            <my-editor
                            :title="pageSelected.name"
                            :content="pageSelected.content"
                            v-if="pageEdition"
                            @input="savePage"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </admin-template>
    </div>
</template>

<script>
import BaseComponent from './../../default/Components/BaseComponent'
import AdminTemplate from './Template'
import MyEditor from '../Components/Editor/TipTapEditor.vue'

import axios from 'axios'

export default {
    name: 'admin-members',
    extends: BaseComponent,

    components: {
        AdminTemplate,
        MyEditor,
    },

    data() {
        return {
            category: null,
            pages: null,
            pageSelected: null,
            pageEdition: true,
            timerUpdatePage: null,
        }
    },

    computed: {
        tagsList() {
            let result = this.pages.map(function(item) { return item["group"]; });
            result = [...new Set(result)];
            result = result.filter(n => n)

            return result
        }
    },

    methods: {
        getCategory(id) {
            this.pages = []
            if (id) {
                axios.post(this.baseUrl + '/structure/' + id + '/voir')
                .then((response) => {
                    this.category = response.data
                    this.getPages(id)
                })
            }
        },
        getPages(categoryId) {
            axios.post(this.baseUrl + '/page/browse/category/' + categoryId)
            .then((response) => {
                this.pages = response.data
            })
        },
        navigateOtherPage(obj) {
            this.$router.replace(obj)
            location.reload();
        },
        savePage(data) {
            if (data.title) {
                window.clearTimeout(this.timerUpdatePage)
                this.timerUpdatePage = setTimeout(async () => {
                    if (this.pageSelected.id) {
                        await axios.post(this.$laraConfig.url_prefix + '/page/' + this.pageSelected.id + '/update', {
                            name: data.title,
                            content: data.content
                        })
                    } else {
                        let response = await axios.post(this.$laraConfig.url_prefix + '/page/create', {
                            name: data.title,
                            content: data.content,
                            parent_id: this.$route.params.id
                        })
                        this.pageSelected.id = response.data.id
                    }
                    this.pageSelected.content = data.content
                    if (data.title != this.pageSelected.name) {
                        this.pageSelected.name = data.title
                        this.getCategory(this.$route.params.id)
                    }
                }, 700)
            }
        },
        newOrderPages(result) {
            axios.post(this.baseUrl + '/page/change-order', {
                list: this.pages
            })
            .then((response) => {
                this.$toast.success('Modifié')
            })
        },
        initNewPage() {
            this.pageSelected = {
                title: null,
                content: null
            }
        },
        deletePage(id) {
            axios.post(this.baseUrl + '/page/' + id + '/delete')
            .then((response) => {
                this.getPages(this.$route.params.id)
                this.$modal.hide('modal-delete-page')
                this.pageSelected = null
            })
        },
        createTag(newTag) {
            axios.post(this.baseUrl + '/page/' + this.pageSelected.id + '/group', {
                group: newTag
            })
            .then((response) => {
                this.pageSelected.group = newTag
            })
        },
        linkTag() {
            axios.post(this.baseUrl + '/page/' + this.pageSelected.id + '/group', {
                group: this.pageSelected.group
            })
            .then((response) => {
            })
        }
    },

    mounted() {
        this.getCategory(this.$route.params.id)
    }
}
</script>
