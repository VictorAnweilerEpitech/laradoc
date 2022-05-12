<template>
    <div class="pb-4">
        <input v-model="title" type="text" class="form-control w-100" placeholder="Nom de la page">
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
                                class: "d-inline-block mr-2 mt-3 mb-3 col-12",
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
                    icon="fas fa-remove-format"
                    :action="() => {
                        editor.chain().focus().clearNodes().run();
                        editor.chain().focus().unsetAllMarks().run()
                    }"
                    />
                    <tip-tap-buttons
                    class="mr-1"
                    :buttons='{
                        icon: "fas fa-palette",
                        items: [
                            {
                                class: "d-inline-block mr-2 mt-3 col-3",
                                icon: "<button style=\"background: #a29bfe; border-width: 0px; width: 10px; height: 11px; border-radius: 50%\"></button>",
                                action: () => {editor.chain().focus().setColor("#a29bfe").run()},
                                isActive: editor.isActive("textStyle", { color: "#a29bfe" })
                            },
                            {
                                class: "d-inline-block mr-2 mt-3 col-3",
                                icon: "<button style=\"background: #55efc4; border-width: 0px; width: 10px; height: 11px; border-radius: 50%\"></button>",
                                action: () => {editor.chain().focus().setColor("#55efc4").run()},
                                isActive: editor.isActive("textStyle", { color: "#55efc4" })
                            },
                            {
                                class: "d-inline-block mr-2 mt-3 col-3",
                                icon: "<button style=\"background: #81ecec; border-width: 0px; width: 10px; height: 11px; border-radius: 50%\"></button>",
                                action: () => {editor.chain().focus().setColor("#81ecec").run()},
                                isActive: editor.isActive("textStyle", { color: "#81ecec" })
                            },
                            {
                                class: "d-inline-block mr-2 mt-3 col-3",
                                icon: "<button style=\"background: #74b9ff; border-width: 0px; width: 10px; height: 11px; border-radius: 50%\"></button>",
                                action: () => {editor.chain().focus().setColor("#74b9ff").run()},
                                isActive: editor.isActive("textStyle", { color: "#74b9ff" })
                            },
                            {
                                class: "d-inline-block mr-2 mt-3 col-3",
                                icon: "<button style=\"background: #ffeaa7; border-width: 0px; width: 10px; height: 11px; border-radius: 50%\"></button>",
                                action: () => {editor.chain().focus().setColor("#ffeaa7").run()},
                                isActive: editor.isActive("textStyle", { color: "#ffeaa7" })
                            },
                            {
                                class: "d-inline-block mr-2 mt-3 col-3",
                                icon: "<button style=\"background: #fab1a0; border-width: 0px; width: 10px; height: 11px; border-radius: 50%\"></button>",
                                action: () => {editor.chain().focus().setColor("#fab1a0").run()},
                                isActive: editor.isActive("textStyle", { color: "#fab1a0" })
                            },
                            {
                                class: "d-inline-block mr-2 mt-3 col-3",
                                icon: "<button style=\"background: #b2bec3; border-width: 0px; width: 10px; height: 11px; border-radius: 50%\"></button>",
                                action: () => {editor.chain().focus().setColor("#b2bec3").run()},
                                isActive: editor.isActive("textStyle", { color: "#b2bec3" })
                            },
                            {
                                class: "d-inline-block mr-2 mt-3 col-3",
                                icon: "<button style=\"background: #636e72; border-width: 0px; width: 10px; height: 11px; border-radius: 50%\"></button>",
                                action: () => {editor.chain().focus().setColor("#636e72").run()},
                                isActive: editor.isActive("textStyle", { color: "#636e72" })
                            },
                            {
                                class: "d-inline-block mr-2 mt-3 col-3",
                                icon: "<button style=\"background: #000; border-width: 0px; width: 10px; height: 11px; border-radius: 50%\"></button>",
                                action: () => {editor.chain().focus().setColor("#000").run()},
                                isActive: editor.isActive("textStyle", { color: "#000" })
                            }
                        ]
                    }'
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
                    icon="fas fa-underline"
                    :action="() => {editor.chain().focus().toggleUnderline().run()}"
                    :is-active="editor.isActive('underline')"
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
                    <tip-tap-buttons
                    class="mr-1"
                    :buttons='{
                        icon: "fas fa-exclamation-circle",
                        items: [
                            {
                                class: "d-inline-block mr-2 mt-3 col-3",
                                icon: "<button style=\"background: #CFE2FF; border-width: 0px; width: 10px; height: 11px; border-radius: 50%\"></button>",
                                action: () => {this.addAlertComponent("primary")}
                            },
                            {
                                class: "d-inline-block mr-2 mt-3 col-3",
                                icon: "<button style=\"background: #E2E3E5; border-width: 0px; width: 10px; height: 11px; border-radius: 50%\"></button>",
                                action: () => {this.addAlertComponent("secondary")}
                            },
                            {
                                class: "d-inline-block mr-2 mt-3 col-3",
                                icon: "<button style=\"background: #D1E7DD; border-width: 0px; width: 10px; height: 11px; border-radius: 50%\"></button>",
                                action: () => {this.addAlertComponent("success")}
                            },
                            {
                                class: "d-inline-block mr-2 mt-3 col-3",
                                icon: "<button style=\"background: #F8D7DA; border-width: 0px; width: 10px; height: 11px; border-radius: 50%\"></button>",
                                action: () => {this.addAlertComponent("danger")}
                            },
                            {
                                class: "d-inline-block mr-2 mt-3 col-3",
                                icon: "<button style=\"background: #FFF3CD; border-width: 0px; width: 10px; height: 11px; border-radius: 50%\"></button>",
                                action: () => {this.addAlertComponent("warning")}
                            },
                            {
                                class: "d-inline-block mr-2 mt-3 col-3",
                                icon: "<button style=\"background: #CFF4FC; border-width: 0px; width: 10px; height: 11px; border-radius: 50%\"></button>",
                                action: () => {this.addAlertComponent("info")}
                            },
                            {
                                class: "d-inline-block mr-2 mt-3 col-3",
                                icon: "<button style=\"background: #FEFEFE; border-width: 0px; width: 10px; height: 11px; border-radius: 50%\"></button>",
                                action: () => {this.addAlertComponent("light")}
                            },
                            {
                                class: "d-inline-block mr-2 mt-3 col-3",
                                icon: "<button style=\"background: #141619; border-width: 0px; width: 10px; height: 11px; border-radius: 50%\"></button>",
                                action: () => {this.addAlertComponent("dark")}
                            },
                        ]
                    }'
                    />
                    <tip-tap-buttons
                    class="mr-1"
                    :buttons='{
                        icon: "fas fa-table",
                        items: [
                            {
                                class: "border-bottom w-100",
                                icon: "<small>Créer</small>",
                                action: () => {editor.commands.insertTable()},
                            },
                            {
                                class: "border-bottom w-100",
                                icon: "<small class=\"mt-3 d-inline-block\">Ajouter colonne avant</small>",
                                action: () => {editor.commands.addColumnBefore()},
                            },
                            {
                                class: "border-bottom w-100",
                                icon: "<small class=\"mt-3 d-inline-block\">Ajouter colonne après</small>",
                                action: () => {editor.commands.addColumnAfter()},
                            },
                            {
                                class: "border-bottom w-100",
                                icon: "<small class=\"mt-3 d-inline-block\">Ajouter ligne dessus</small>",
                                action: () => {editor.commands.addRowBefore()},
                            },
                            {
                                class: "border-bottom w-100",
                                icon: "<small class=\"mt-3 d-inline-block\">Ajouter ligne dessous</small>",
                                action: () => {editor.commands.addRowAfter()},
                            },
                            {
                                class: "border-bottom w-100",
                                icon: "<small class=\"mt-3 d-inline-block\">Supprimer colonne</small>",
                                action: () => {editor.commands.deleteColumn()},
                            },
                            {
                                class: "border-bottom w-100",
                                icon: "<small class=\"mt-3 d-inline-block\">Supprimer ligne</small>",
                                action: () => {editor.commands.deleteRow()},
                            },
                            {
                                class: "border-bottom w-100",
                                icon: "<small class=\"mt-3 d-inline-block\">Merge</small>",
                                action: () => {editor.commands.mergeCells()},
                            },
                            {
                                class: "border-bottom w-100",
                                icon: "<small class=\"mt-3 d-inline-block\">Split</small>",
                                action: () => {editor.commands.splitCell()},
                            },
                            {
                                class: "border-bottom w-100",
                                icon: "<small class=\"mt-3 d-inline-block\">Supprimer le tableau</small>",
                                action: () => {editor.commands.deleteTable()},
                            },
                        ]
                    }'
                    />
                    <tip-tap-button
                    class="mr-1"
                    icon="fas fa-link"
                    :action="() => {editor.isActive('link') ?  editor.chain().focus().unsetLink().run() : this.setLink()}"
                    :is-active="editor.isActive('link')"
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
import Document from '@tiptap/extension-document'
import Paragraph from '@tiptap/extension-paragraph'
import Text from '@tiptap/extension-text'
import TextStyle from '@tiptap/extension-text-style'
import Underline from '@tiptap/extension-underline'
import { Color } from '@tiptap/extension-color'
import Table from '@tiptap/extension-table'
import TableRow from '@tiptap/extension-table-row'
import TableCell from '@tiptap/extension-table-cell'
import TableHeader from '@tiptap/extension-table-header'
import Gapcursor from '@tiptap/extension-gapcursor'
import Link from '@tiptap/extension-link'

import TipTapButton from './TipTapButton.vue'
import TipTapButtons from './TipTapButtons.vue'
import TipTapRequest from './SendRequest/Extension'
import TipTapAlert from './Alert/Extension'
import TipTapLink from './Link/Extension'

export default {
    props: {
        id: {},
        parentId: {}
    },
    components: {
        EditorContent,
        TipTapButton,
        TipTapButtons
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
            let response = await axios.post(this.$laraConfig.url_prefix + '/page/' + pageId + '/view')
            this.title = response.data.name
            this.content = response.data.content
            this.renderEditor()
        },

        addTipTapRequest() {
            this.editor.commands.setContent((this.content || '') + '<tip-tap-request url="" type="get" header="" body=""></tip-tap-request><p></p>')
        },

        addAlertComponent(type) {
            this.editor.commands.setContent((this.content || '') + '<tip-tap-alert type="' + type + '" value=""></tip-tap-alert><p></p>')
        },

        setLink() {
            const previousUrl = this.editor.getAttributes('link').href
            const url = window.prompt('URL', previousUrl)

            // cancelled
            if (url === null) {
                return
            }

            // empty
            if (url === '') {
                this.editor
                .chain()
                .focus()
                .extendMarkRange('link')
                .unsetLink()
                .run()

                return
            }

            // update link
            this.editor
                .chain()
                .focus()
                .extendMarkRange('link')
                .setLink({ href: url })
                .run()
        },

        renderEditor() {
            this.editor = new Editor({
                content: this.content,
                extensions: [
                    StarterKit,
                    Highlight,
                    Document,
                    Paragraph,
                    Text,
                    Underline,
                    TextStyle,
                    Color,
                    Gapcursor,
                    Link,
                    Table.configure({
                        resizable: true,
                    }),
                    TableRow,
                    TableHeader,
                    TableCell,
                    Typography,
                    TipTapRequest,
                    TipTapAlert,
                    TipTapLink
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
                    await axios.post(this.$laraConfig.url_prefix + '/page/' + this.pageId + '/update', {
                        name: this.title,
                        content: this.content
                    })
                } else {
                    let response = await axios.post(this.$laraConfig.url_prefix + '/page/create', {
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
        console.log('ta grosse mere la pute');
        if (this.id) {
            this.pageId = this.id
            this.getPage(this.id)
        } else {
            this.renderEditor()
        }
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
}

.editor-navbar-buttons {
    .tip-tap-btn-not-selected, tip-tap-buttons {
        background: white !important;
        color: black !important;
    }
    .tip-tap-btn-selected {
        background: #2d3436 !important;
        color: white !important;
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

    table {
        border-collapse: collapse;
        table-layout: fixed;
        width: 100%;
        margin: 0;
        overflow: hidden;

        td,
        th {
        min-width: 1em;
        border: 2px solid #ced4da;
        padding: 3px 5px;
        vertical-align: top;
        box-sizing: border-box;
        position: relative;

        > * {
            margin-bottom: 0;
        }
        }

        th {
        font-weight: bold;
        text-align: left;
        background-color: #f1f3f5;
        }

        .selectedCell:after {
        z-index: 2;
        position: absolute;
        content: "";
        left: 0; right: 0; top: 0; bottom: 0;
        background: rgba(200, 200, 255, 0.4);
        pointer-events: none;
        }

        .column-resize-handle {
        position: absolute;
        right: -2px;
        top: 0;
        bottom: -2px;
        width: 4px;
        background-color: #adf;
        pointer-events: none;
        }

        p {
        margin: 0;
        }
    }

    .tableWrapper {
        padding: 1rem 0;
        overflow-x: auto;
    }

    .resize-cursor {
        cursor: ew-resize;
        cursor: col-resize;
    }
}
</style>
