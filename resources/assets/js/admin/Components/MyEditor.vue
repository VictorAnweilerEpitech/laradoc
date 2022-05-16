<template>
    <div>
        <input type="text" v-model="titleInput" @change="save" class="form-control mb-3" placeholder="Nom de la page">
        <div id="trumbowyg" placeholder="Contenu de la page"></div>
    </div>
</template>

<script>
export default {
    props: {
        title: {
            type: String,
        },
        content: {
            type: String
        }
    },
    watch: {
        title: function(value) {
            this.titleInput = value
        },
        content: function(value) {
            this.setData(value)
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
                titleInput: ''
            },
        }
    },
    methods: {
        setData(html) {
            console.log(html);
            $('#trumbowyg').trumbowyg('destroy')
            $('#trumbowyg').html(html);
            $('#trumbowyg').trumbowyg(this.options)
        },
        save() {
            this.$emit('value', {
                title: this.title,
                content: $('#trumbowyg').html()
            })
        },
    },
    mounted() {
        $('#trumbowyg').trumbowyg(this.options);
        this.setData(this.content)
        this.titleInput = this.title

        $("#trumbowyg").on('tbwchange', () => {
            this.save()
        })
    }
}
</script>
