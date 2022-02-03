import { Node, mergeAttributes } from '@tiptap/core'
import { VueNodeViewRenderer } from '@tiptap/vue-2'
import Component from './TipTapAlert.vue'

export default Node.create({
  name: 'tip-tap-alert-component',

  group: 'block',

  atom: true,

  addAttributes() {
    return {
        value: {
            default: ""
        },
        type: {
            default: "primary"
        }
    }
  },

  parseHTML() {
    return [
      {
        tag: 'tip-tap-alert',
      },
    ]
  },

  renderHTML({ HTMLAttributes, node }) {
    return ['tip-tap-alert', mergeAttributes(
        HTMLAttributes
    )]
  },

  addNodeView() {
    return VueNodeViewRenderer(Component)
  },
})
