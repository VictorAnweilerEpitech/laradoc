<template>
    <div>
        <input v-model="title" type="text" class="form-control mb-3" placeholder="Nom de la page">
        <div v-if="editor">
            <div class="mb-3">
                <tip-tap-buttons
                class="d-inline-block"
                :buttons='{
                    icon: "fas fa-heading",
                    items: [
                        {
                            class: "d-inline-block mr-2 mt-3 col-12",
                            icon: "Paragraph",
                            action: () => {editor.chain().focus().setParagraph({ level: 1 }).run()},
                            isActive: editor.isActive("paragraph")
                        },
                        {
                            class: "d-inline-block mr-2 mt-3 col-3",
                            icon: "H1",
                            action: () => {editor.chain().focus().toggleHeading({ level: 1 }).run()},
                            isActive: editor.isActive("heading", { level: 1 })
                        },
                        {
                            class: "d-inline-block mr-2 mt-3 col-3",
                            icon: "H2",
                            action: () => {editor.chain().focus().toggleHeading({ level: 2 }).run()},
                            isActive: editor.isActive("heading", { level: 2 })
                        },
                        {
                            class: "d-inline-block mr-2 mt-3 col-3",
                            icon: "H3",
                            action: () => {editor.chain().focus().toggleHeading({ level: 3 }).run()},
                            isActive: editor.isActive("heading", { level: 3 })
                        },
                        {
                            class: "d-inline-block mr-2 mt-3 col-3",
                            icon: "H4",
                            action: () => {editor.chain().focus().toggleHeading({ level: 4 }).run()},
                            isActive: editor.isActive("heading", { level: 4 })
                        },
                        {
                            class: "d-inline-block mr-2 mt-3 col-3",
                            icon: "H5",
                            action: () => {editor.chain().focus().toggleHeading({ level: 5 }).run()},
                            isActive: editor.isActive("heading", { level: 5 })
                        },
                        {
                            class: "d-inline-block mr-2 mt-3 col-3",
                            icon: "H6",
                            action: () => {editor.chain().focus().toggleHeading({ level: 6}).run()},
                            isActive: editor.isActive("heading", { level: 6 })
                        }
                    ]
                }'
                />
                <tip-tap-button
                class="d-inline-block"
                icon="fas fa-remove-format"
                :action="() => {
                    editor.chain().focus().clearNodes().run();
                    editor.chain().focus().unsetAllMarks().run()
                }"
                />
                <span class="separator d-inline-block mx-2" style="height: 24px;"></span>
                <tip-tap-button
                class="d-inline-block"
                icon="fas fa-bold"
                :action="() => {editor.chain().focus().toggleBold().run()}"
                :is-active="editor.isActive('bold')"
                />
                <tip-tap-button
                class="d-inline-block"
                icon="fas fa-italic"
                :action="() => {editor.chain().focus().toggleItalic().run()}"
                :is-active="editor.isActive('italic')"
                />
                <tip-tap-button
                class="d-inline-block"
                icon="fas fa-strikethrough"
                :action="() => {editor.chain().focus().toggleStrike().run()}"
                :is-active="editor.isActive('strike')"
                />
                <span class="separator d-inline-block mx-2" style="height: 24px;"></span>
                <tip-tap-buttons
                class="d-inline-block"
                :buttons='{
                    icon: "fas fa-list",
                    items: [
                        {
                            class: "d-inline-block mr-2 mt-3 col-3",
                            icon: "fas fa-list-ul",
                            action: () => {editor.chain().focus().toggleBulletList().run()},
                            isActive: editor.isActive("bulletList")
                        },
                        {
                            class: "d-inline-block mr-2 mt-3 col-3",
                            icon: "fas fa-list-ol",
                            action: () => {editor.chain().focus().toggleOrderedList().run()},
                            isActive: editor.isActive("orderedList")
                        }
                    ]
                }'
                />
                <tip-tap-button
                class="d-inline-block"
                icon="fas fa-code"
                :action="() => {editor.chain().focus().toggleCodeBlock().run()}"
                :is-active="editor.isActive('codeBlock')"
                />
                <tip-tap-button
                class="d-inline-block"
                icon="bi hr"
                :action="() => {editor.chain().focus().setHorizontalRule().run()}"
                />
                <tip-tap-button
                class="d-inline-block"
                icon="fas fa-quote-left"
                :action="() => {editor.chain().focus().toggleBlockquote().run()}"
                :is-active="editor.isActive('blockquote')"
                />
                <span class="separator d-inline-block mx-2" style="height: 24px;"></span>
                <tip-tap-button
                class="d-inline-block"
                icon="fas fa-undo"
                :action="() => {editor.chain().focus().undo().run()}"
                />
                <tip-tap-button
                class="d-inline-block"
                icon="fas fa-redo"
                :action="() => {editor.chain().focus().redo().run()}"
                />
            </div>
        </div>
        <editor-content class="border p-4 my-rounded mt-3" :editor="editor" />
    </div>
</template>

<script>
import { Editor, EditorContent } from '@tiptap/vue-2'
import StarterKit from '@tiptap/starter-kit'

import Highlight from '@tiptap/extension-highlight'
import Typography from '@tiptap/extension-typography'

import TipTapButton from './TipTapButton.vue'
import TipTapButtons from './TipTapButtons.vue'
import TipTapRequest from './SendRequest/Extension'

export default {
    props: {
        id: {
            type: Number,
            required: true,
        }
    },
    components: {
        EditorContent,
        TipTapButton,
        TipTapButtons
    },

    data() {
        return {
            title: "",
            editor: null,
            content: null,
        }
    },
    // <tip-tap-request-editor url="https://be-angel.com/api/aidant/login" type="post" requestbody="[{&quot;label&quot;:&quot;email&quot;,&quot;value&quot;:{&quot;type&quot;:&quot;text&quot;,&quot;value&quot;:&quot;victor.anweiler@epitech.eu&quot;}},{&quot;label&quot;:&quot;password&quot;,&quot;value&quot;:{&quot;type&quot;:&quot;text&quot;,&quot;value&quot;:&quot;password&quot;}}]" requestheader="[{&quot;label&quot;:&quot;Authorization&quot;,&quot;value&quot;:{&quot;type&quot;:&quot;text&quot;,&quot;value&quot;:&quot;Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiI3IiwianRpIjoiMTk3ZGE3MDQ0Njg3MGYzZmM5ZDU1ZmE4YWFhOGFhZTQ2ZTJlZWNmZGQwNzkzMWY3ODk3OWRjNGRmZmFjYjhjZjA2MzJiYTk2YWQzN2M4Y2EiLCJpYXQiOjE2NDM0MDE3NTMuNjU5NjU3LCJuYmYiOjE2NDM0MDE3NTMuNjU5NjU4LCJleHAiOjE2NzQ5Mzc3NTMuNjU0ODQ5LCJzdWIiOiIyNCIsInNjb3BlcyI6W119.kQmrtSuFQjQ9eAKliRxV__tQRS6umclLbqzYoWxN5LZ4YlxiScDVuVGZWzaN49QxwSkIMRnkHRjqC2Ts0hpC41scB1dRpQR8aezVX4Ub1fWmm10LCVc-DufKQ9X-m9XgvUqx-_axxT8muWeWHZqrO3GHwEdifJIZQgarnPP4QWLNRxqlBvF_x_wjivS6sU5zFMK-G7KzXUNJzziph_tyCcszVEcWYNFG5aFtzIBr_0DSc_24psccvVgNwzoueNc3brcAjQiNHrqaKSyadTzPBwSQViAcQkD3IRDIKzEiBZSc9C4CoVJSf8CofzJ8efWqpQyxNsncTXsw2516zQ6X5OjV_sU70DcoLNfkAxMpFDPmjtaqWqNFiBh6Ab6-bo16RjiMFDhZKPzOE8nwgxbzRJxCHbcRvgPk__880FCmbZVEhL2nnagNmK1gyyMBrQtvYvbmXNSgXw6LjBf6_YMU2JMAYexMXLctrzPKXFHrY-PpPi5w_fSV_WvG9KwcnmLsgi9Gcjr4ZIBBBl78daE_lMcRc25z-pC6pT4sCTBDUSX6x3Bh0M-Ga34RUXTSO2m-jkO2W7oZOEaaNK0wzaNn7ScrxRSSYOtPJW4bLjTeJB1tc_sNbsBeWNDGBFs9LaLt_SzXzzxg2Pp0WqPXYJIGabkVMPEqExxMwFs5Q2xd9qI&quot;}}]"></tip-tap-request-editor>

    watch: {
        content: function(value) {
            // console.log(value);
        }
    },

    methods: {
        async getPage(pageId) {
            let response = await axios.post('/doc/page/' + pageId + '/view')
            this.title = response.data.name
            this.content = response.data.content
            this.renderEditor()
        },

        renderEditor() {
            this.editor = new Editor({
                content: this.content,
                extensions: [
                    StarterKit,
                    Highlight,
                    Typography,
                    TipTapRequest
                ],
                onUpdate: () => {
                    // HTML
                    this.content = this.editor.getHTML()

                    // JSON
                    // this.$emit('input', this.editor.getJSON())
                },
            })
        }
    },

    mounted() {
        if (this.id) {
            this.getPage(this.id)
        }
    },

    beforeUnmount() {
        this.editor.destroy()
    },
}
</script>

<style lang="scss">
.ProseMirror:focus {
    outline: none;
}
/* Basic editor styles */
.ProseMirror {
    min-height: 60vh !important;

    > * + * {
        margin-top: 0.75em;
    }

    ul,
    ol {
        padding: 0 1rem;
    }

    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
        line-height: 1.1;
    }

    code {
        background-color: rgba(#616161, 0.1);
        color: #616161;
    }

    pre {
        background: #0D0D0D;
        color: #FFF;
        font-family: 'JetBrainsMono', monospace;
        padding: 0.75rem 1rem;
        border-radius: 0.5rem;

        code {
            color: inherit;
            padding: 0;
            background: none;
            font-size: 0.8rem;
        }
    }

    img {
        max-width: 100%;
        height: auto;
    }

    blockquote {
        padding-left: 1rem;
        border-left: 2px solid rgba(#0D0D0D, 0.1);
    }

    hr {
        border: none;
        border-top: 2px solid rgba(#0D0D0D, 0.1);
        margin: 2rem 0;
    }
}
</style>
