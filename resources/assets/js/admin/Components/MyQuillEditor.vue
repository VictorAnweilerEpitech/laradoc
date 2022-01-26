<template>
    <div>
        <template v-if="loadingPage">
            <b-spinner small />
        </template>
        <template v-else>
            <input type="text" v-model="title" @change="save" class="form-control mb-3" placeholder="Nom de la page">

            <quill-editor
            ref="myQuillEditor"
            v-model="contentValue"
            class="bg-white"
            :option="{
                placeholder: 'Compose an epic...',
            }"
            style="min-height: 20vh;"
            />
        </template>
    </div>
</template>

<script>
import axios from 'axios'

import 'quill/dist/quill.core.css'
import 'quill/dist/quill.snow.css'
import 'quill/dist/quill.bubble.css'
 
import { quillEditor } from 'vuejs-quill'

var QuillDeltaToHtmlConverter = require('quill-delta-to-html').QuillDeltaToHtmlConverter;

export default {
    props: {
        id: {
            type: Number,
        },
        parentId: {
            type: Number,
            required: true
        }
    },
    components: {
        quillEditor
    },
    watch: {
        id: function(value) {
            this.pageId = value
            this.getPage(value)
        },
        title: function(value) {
            this.$emit('change-title', value)
        },
        contentValue(value) {
            this.contentConvert = this.$refs.myQuillEditor.quill.root.innerHTML
            this.save()
        }
    },
    data() {
        return {
            timerUpdate: null,
            loadingPage: false,
            title: null,
            pageId: null,
            contentValue: null,
            contentConvert: null
        }
    },
    methods: {
        save() {
            window.clearTimeout(this.timerUpdate)

            this.timerUpdate = setTimeout(async () => {
                this.loadingSave = true
                if (this.pageId) {
                    await axios.post('/doc/page/' + this.pageId + '/update', {
                        name: this.title,
                        content: this.contentConvert
                    })
                } else {
                    let response = await axios.post('/doc/page/create', {
                        name: this.title,
                        content: this.contentConvert,
                        parent_id: this.parentId
                    })
                    this.pageId = response.data.id
                    this.$emit('new-page', response.data.id)
                }
                this.loadingSave = false
            }, 700)
        },
        async getPage(pageId) {
            console.log('ok1');
            let response = await axios.post('/doc/page/' + pageId + '/view')
            this.title = response.data.name
            this.$refs.myQuillEditor.quill.root.innerHTML = response.data.content
        }
    },
    mounted() {
        let el = document.querySelector('.ql-toolbar')
        el.classList.add('sticky-top')
        el.classList.add('bg-white')
        el.classList.add('index-top')
        
        if (this.id) {
            this.pageId = this.id
            this.getPage(this.id)
        }
    }
}
</script>
