<template>
    <div>
        <div>
            <div class="input-group search-input">
                <div
                class="input-group-prepend bg-white"
                :style="result ? 'border-bottom-left-radius: 0px;' : ''"
                >
                    <span class="input-group-text bg-white" id="basic-addon1" style="border-right: 0px !important;">
                        <div v-show="!requestLoading">
                            <i class="fas fa-search"></i>
                        </div>
                        <div v-show="requestLoading">
                            <b-spinner small></b-spinner>
                        </div>
                    </span>
                </div>
                <input
                type="text"
                class="form-control rounded font-weight-light"
                placeholder="Rechercher.."
                style="border-top-left-radius: 0px !important; border-bottom-left-radius: 0px !important; border-left: 0px;"
                v-model="query"
                >
            </div>
            <div v-show="result" class="show-result bg-white border shadow p-2 py-3">
                <template v-if="result && result.categories && result.categories.length > 0">
                    <h6>Catégories</h6>
                    <div
                    v-for="(categorie, indexCategorie) in result.categories"
                    :key="'result-categorie-' + indexCategorie"
                    class="py-1 px-2 result-item"
                    @click="goToNextPage(laraConfig.url_prefix + '/page/' + categorie.id)"
                    >
                        <small class="font-weight-light">
                            {{categorie.name}}
                        </small>
                    </div>
                </template>
                <template v-if="result && result.pages && result.pages.length > 0">
                    <hr v-if="result.categories && result.categories.length > 0">
                    <h6>Pages</h6>
                    <div
                    v-for="(page, indexPage) in result.pages"
                    :key="'result-page-' + indexPage"
                    class="py-1 px-2 result-item"
                    @click="goToNextPage(laraConfig.url_prefix + '/page/' + page.parent_id + '#section-' + page.id)"
                    >
                        <small class="font-weight-light">
                            {{page.name}}
                        </small>
                    </div>
                </template>
            </div>
        </div>
    </div>
</template>

<script type="application/javascript">
import axios from 'axios'
import BaseComponent from '../../BaseComponent.vue'
export default {
    extends: BaseComponent,
    watch: {
        query: function(value) {
            if (value) {
                this.requestLoading = true
                window.clearTimeout(this.timerRequest);
                this.timerRequest = setTimeout(() => {
                    axios.post(this.baseUrl + '/structure/search', {
                        query: value
                    })
                    .then((response) => {
                        this.result = response.data
                        this.requestLoading = false
                    })
                }, 500)
            } else {
                this.result = null
            }
        }
    },
    data() {
        return {
            query: "",
            result: null,
            requestLoading: false,
            timerRequest: null,
        }
    },
    methods: {
        goToNextPage(url) {
            window.location.href = url
            this.query = ""
        },
        placeResultDiv() {
            let elResultDiv = document.querySelector('.show-result');
            let elSearchInput = document.querySelector('.search-input');
            let SearchInputRect = elSearchInput.getBoundingClientRect();

            elResultDiv.style.top = (SearchInputRect.height - 1) + 'px'
            elResultDiv.style.width = (SearchInputRect.width) + 'px'
        }
    },
    mounted() {
        this.placeResultDiv()
        window.addEventListener('resize', (event) => {
            this.placeResultDiv()
        }, true);
    }
}
</script>
