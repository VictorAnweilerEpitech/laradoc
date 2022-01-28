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
    return ['tip-tap-request-viewer', mergeAttributes(
        HTMLAttributes,
        {type: node.attrs.type}
    )]
  },

  addNodeView() {
    return VueNodeViewRenderer(Component)
  },
})
