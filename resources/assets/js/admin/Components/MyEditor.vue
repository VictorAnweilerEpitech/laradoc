<template>
    <div>
        <input type="text" v-model="title" @change="save" class="form-control mb-3" placeholder="Nom de la page">
        <div id="trumbowyg" placeholder="Contenu de la page"></div>
    </div>
</template>

<script>
import axios from 'axios'

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
    watch: {
        id: function(value) {
            this.pageId = value
            this.getPage(value)
        },
        title: function(value) {
            this.$emit('change-title', value)
        }
    },
    data() {
        return {
            options: {
                btns: [
                    ['viewHTML'],
                    ['undo', 'redo'], // Only supported in Blink browsers
                    ['formatting'],
                    ['strong', 'em', 'del'],
                    ['superscript', 'subscript'],
                    ['link'],
                    ['insertImage', 'table'],
                    ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
                    ['unorderedList', 'orderedList'],
                    ['horizontalRule'],
                    ['removeformat'],
                    ['fullscreen']
                ],
                autogrow: true,
                lang: 'fr',
                defaultLinkTarget: '_blank',
            },
            timerUpdate: null,
            loadingPage: false,
            title: null,
            pageId: null
        }
    },
    methods: {
        setData(html) {
            $('#trumbowyg').trumbowyg('destroy')
            $('#trumbowyg').html(html);
            $('#trumbowyg').trumbowyg(this.options)
        },
        save() {
            window.clearTimeout(this.timerUpdate)

            this.timerUpdate = setTimeout(async () => {
                this.loadingSave = true
                if (this.pageId) {
                    await axios.post('/doc/page/' + this.pageId + '/update', {
                        name: this.title,
                        content: $('#trumbowyg').html()
                    })
                } else {
                    let response = await axios.post('/doc/page/create', {
                        name: this.title,
                        content: $('#trumbowyg').html(),
                        parent_id: this.parentId
                    })
                    this.pageId = response.data.id
                    this.$emit('new-page', response.data.id)
                }
                this.loadingSave = false
            }, 700)
        },
        async getPage(pageId) {
            let response = await axios.post('/doc/page/' + pageId + '/view')
            this.setData(response.data.content)
            this.title = response.data.name
        }
    },
    mounted() {
        $('#trumbowyg').trumbowyg(this.options);

        $("#trumbowyg").on('tbwchange', () => {
            this.save()
        })

        if (this.id) {
            this.pageId = this.id
            this.getPage(this.id)
        }
    }
}
</script>
