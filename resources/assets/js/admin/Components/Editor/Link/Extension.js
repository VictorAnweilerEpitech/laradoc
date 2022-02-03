import { Node, mergeAttributes } from '@tiptap/core'
import { VueNodeViewRenderer } from '@tiptap/vue-2'
import Component from './TipTapLink.vue'

export default Node.create({
  name: 'tip-tap-link-component',

  group: 'block',

  atom: true,

  addAttributes() {
    return {
        label: {
            default: ""
        },
        url: {
            default: ""
        },
        target: {
            default: ""
        }
    }
  },

  parseHTML() {
    return [
      {
        tag: 'tip-tap-link',
      },
    ]
  },

  renderHTML({ HTMLAttributes, node }) {
    return ['tip-tap-link', mergeAttributes(
        HTMLAttributes
    )]
  },

  addNodeView() {
    return VueNodeViewRenderer(Component)
  },
})
