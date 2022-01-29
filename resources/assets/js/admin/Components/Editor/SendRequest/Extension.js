import { Node, mergeAttributes } from '@tiptap/core'
import { VueNodeViewRenderer } from '@tiptap/vue-2'
import Component from './TipTapRequestEditor.vue'

export default Node.create({
  name: 'vueComponent',

  group: 'block',

  atom: true,

  addAttributes() {
    return {
      url: {
        default: "",
      },
      type: {
        default: "get"
      },
      body: {
        default: ""
      },
      header: {
        default: ""
      }
    }
  },

  parseHTML() {
    return [
      {
        tag: 'tip-tap-request-editor',
      },
    ]
  },

  renderHTML({ HTMLAttributes, node }) {
    console.log(HTMLAttributes);
    return ['tip-tap-request-editor', mergeAttributes(
        HTMLAttributes
    )]
  },

  addNodeView() {
    return VueNodeViewRenderer(Component)
  },
})
