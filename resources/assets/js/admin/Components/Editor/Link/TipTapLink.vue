<template>
    <node-view-wrapper class="vue-component">
        <a :href="node.attrs.url" :target="node.attrs.target">
            {{node.attrs.label}}
        </a>
    </node-view-wrapper>
</template>

<script>
import { NodeViewWrapper, nodeViewProps } from '@tiptap/vue-2'

export default {
    props: nodeViewProps,

    components: {
        NodeViewWrapper
    },

    data() {
        return {
        }
    },

    mounted() {
    }
}
</script>

<style lang="scss">

</style>
