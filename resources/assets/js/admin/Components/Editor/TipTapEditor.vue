<template>
    <div class="pb-4">
        <input v-model="title" type="text" class="form-control w-100" placeholder="Nom de la page">
        {{content}}
        <div v-if="editor" class="mb-2">
            <editor-content class="border p-4 rounded mt-3 mb-4" :editor="editor" />
            <div class="d-flex align-items-center justify-content-between editor-navbar-buttons bg-light rounded shadow p-3">
                <div class="d-flex align-items-center">
                    <tip-tap-buttons
                    class="mr-1"
                    :buttons='{
                        icon: "fas fa-heading",
                        items: [
                            {
                                class: " mr-2 mt-3 col-12",
                                icon: "Paragraph",
                                action: () => {editor.chain().focus().setParagraph({ level: 1 }).run()},
                                isActive: editor.isActive("paragraph")
                            },
                            {
                                class: " mr-2 mt-3 col-3",
                                icon: "H1",
                                action: () => {editor.chain().focus().toggleHeading({ level: 1 }).run()},
                                isActive: editor.isActive("heading", { level: 1 })
                            },
                            {
                                class: " mr-2 mt-3 col-3",
                                icon: "H2",
                                action: () => {editor.chain().focus().toggleHeading({ level: 2 }).run()},
                                isActive: editor.isActive("heading", { level: 2 })
                            },
                            {
                                class: " mr-2 mt-3 col-3",
                                icon: "H3",
                                action: () => {editor.chain().focus().toggleHeading({ level: 3 }).run()},
                                isActive: editor.isActive("heading", { level: 3 })
                            },
                            {
                                class: " mr-2 mt-3 col-3",
                                icon: "H4",
                                action: () => {editor.chain().focus().toggleHeading({ level: 4 }).run()},
                                isActive: editor.isActive("heading", { level: 4 })
                            },
                            {
                                class: " mr-2 mt-3 col-3",
                                icon: "H5",
                                action: () => {editor.chain().focus().toggleHeading({ level: 5 }).run()},
                                isActive: editor.isActive("heading", { level: 5 })
                            },
                            {
                                class: " mr-2 mt-3 col-3",
                                icon: "H6",
                                action: () => {editor.chain().focus().toggleHeading({ level: 6}).run()},
                                isActive: editor.isActive("heading", { level: 6 })
                            }
                        ]
                    }'
                    />
                    <tip-tap-button
                    icon="fas fa-remove-format"
                    :action="() => {
                        editor.chain().focus().clearNodes().run();
                        editor.chain().focus().unsetAllMarks().run()
                    }"
                    />
                </div>
                <div class="d-flex align-items-center">
                    <tip-tap-button
                    class="mr-1"
                    icon="fas fa-bold"
                    :action="() => {editor.chain().focus().toggleBold().run()}"
                    :is-active="editor.isActive('bold')"
                    />
                    <tip-tap-button
                    class="mr-1"
                    icon="fas fa-italic"
                    :action="() => {editor.chain().focus().toggleItalic().run()}"
                    :is-active="editor.isActive('italic')"
                    />
                    <tip-tap-button
                    class="mr-1"
                    icon="fas fa-strikethrough"
                    :action="() => {editor.chain().focus().toggleStrike().run()}"
                    :is-active="editor.isActive('strike')"
                    />
                </div>
                <div class="d-flex align-items-center">
                    <tip-tap-buttons
                    class="mr-1"
                    :buttons='{
                        icon: "fas fa-list",
                        items: [
                            {
                                class: " mr-2 mt-3 col-3",
                                icon: "fas fa-list-ul",
                                action: () => {editor.chain().focus().toggleBulletList().run()},
                                isActive: editor.isActive("bulletList")
                            },
                            {
                                class: " mr-2 mt-3 col-3",
                                icon: "fas fa-list-ol",
                                action: () => {editor.chain().focus().toggleOrderedList().run()},
                                isActive: editor.isActive("orderedList")
                            }
                        ]
                    }'
                    />
                    <tip-tap-button
                    class="mr-1"
                    icon="fas fa-code"
                    :action="() => {editor.chain().focus().toggleCodeBlock().run()}"
                    :is-active="editor.isActive('codeBlock')"
                    />
                    <tip-tap-button
                    class="mr-1"
                    icon="bi hr"
                    :action="() => {editor.chain().focus().setHorizontalRule().run()}"
                    />
                    <tip-tap-button
                    class="mr-1"
                    icon="fas fa-quote-left"
                    :action="() => {editor.chain().focus().toggleBlockquote().run()}"
                    :is-active="editor.isActive('blockquote')"
                    />
                    <tip-tap-button
                    class="mr-1"
                    icon="fas fa-rocket"
                    :action="() => {this.addTipTapRequest()}"
                    />
                    <tip-tap-button
                    class="mr-1"
                    icon="fas fa-exclamation-circle"
                    :action="() => {this.addAlertComponent()}"
                    />
                </div>
                <div class="d-flex align-items-center">
                    <tip-tap-button
                    class="mr-1"
                    icon="fas fa-undo"
                    :action="() => {editor.chain().focus().undo().run()}"
                    />
                    <tip-tap-button
                    class="mr-1"
                    icon="fas fa-redo"
                    :action="() => {editor.chain().focus().redo().run()}"
                    />
                </div>
            </div>
        </div>
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
import TipTapAlert from './Alert/Extension'

export default {
    props: {
        id: {},
        parentId: {}
    },
    components: {
        EditorContent,
        TipTapButton,
        TipTapButtons,
        TipTapAlert
    },

    data() {
        return {
            pageId: null,
            title: "",
            editor: null,
            content: null,
            timerUpdate: null,
        }
    },

    watch: {
        content: function(value) {
            this.save()
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

        addTipTapRequest() {
            this.editor.commands.setContent((this.content || '') + '<tip-tap-request url="" type="get" header="" body=""></tip-tap-request><p></p>')
        },

        addAlertComponent() {
            this.editor.commands.setContent((this.content || '') + '<tip-tap-alert type="success" class="alert alert-warning" value=""></tip-tap-alert><p></p>')
        },

        renderEditor() {
            this.editor = new Editor({
                content: this.content,
                extensions: [
                    StarterKit,
                    Highlight,
                    Typography,
                    TipTapRequest,
                    TipTapAlert
                ],
                onUpdate: () => {
                    // HTML
                    this.content = this.editor.getHTML()

                    // JSON
                    // this.$emit('input', this.editor.getJSON())
                },
            })
        },
        save() {
            window.clearTimeout(this.timerUpdate)

            this.timerUpdate = setTimeout(async () => {
                if (this.pageId) {
                    await axios.post('/doc/page/' + this.pageId + '/update', {
                        name: this.title,
                        content: this.content
                    })
                } else {
                    let response = await axios.post('/doc/page/create', {
                        name: this.title,
                        content: this.content,
                        parent_id: this.parentId
                    })
                    this.pageId = response.data.id
                    this.$emit('new-page', response.data.id)
                }
            }, 700)
        },
    },

    mounted() {
        if (this.id) {
            this.pageId = this.id
            this.getPage(this.id)
        } else {
            this.renderEditor()
        }
        console.log(TipTapRequest);
    },

    beforeUnmount() {
        this.editor.destroy()
    },
}
</script>

<style lang="scss">
.editor-navbar-buttons {
    position: fixed;
    bottom: 10px;
    z-index: 999;
    left: 50%;
    width: 715px !important;
    transform: translate(-50%, 0);
    
    tip-tap-button, tip-tap-buttons {
        background: white !important;
    }
}

.editor-navbar-buttons {
    .tiptap-btn {
        background: white !important;
    }
}

.modal-dialog {
    margin-bottom: 0;
    display: flex;
}

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
