import { Node, mergeAttributes } from '@tiptap/core'
import { VueNodeViewRenderer } from '@tiptap/vue-2'
import Component from './TipTapRequestEditor.vue'

export default Node.create({
  name: 'tip-tap-request-component',

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
      },
      label: {
        default: ""
      }
    }
  },

  parseHTML() {
    return [
      {
        tag: 'tip-tap-request',
      },
    ]
  },

  renderHTML({ HTMLAttributes, node }) {
    return ['tip-tap-request', mergeAttributes(
        HTMLAttributes
    )]
  },

  addNodeView() {
    return VueNodeViewRenderer(Component)
  },
})
