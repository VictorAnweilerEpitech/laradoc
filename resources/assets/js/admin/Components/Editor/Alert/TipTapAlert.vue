<template>
    <node-view-wrapper class="vue-component">
        <div class="alert" :class="'alert-' + node.attrs.type" role="alert">
            <input placeholder="Votre texte.." class="form-control border-0" style="background: rgba(0, 0, 0, 0)" type="text" v-model="node.attrs.value">
        </div>
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
