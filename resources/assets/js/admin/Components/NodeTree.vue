<template>
    <li class="node-tree cursor-pointer">
        <span @click="manageClick">
            <span v-if="open"><i class="fas fa-folder-open"></i></span>
            <span v-if="!open"><i class="fas fa-folder"></i></span>
            <span v-show="!node.children">
                <i class="far fa-file"></i>
            </span>

            <span class="label"><b>{{ node.name }}</b></span>
        </span>
        
        <ul v-show="node.children && node.children.length && open">
            <node :key="child.label" v-for="child in node.children" :node="child" :handle-click="handleClick"></node>
        </ul>
    </li>
</template>

<script>
export default {
    name: "node",
    props: {
        node: Object,
        handleClick: Function
    },
    data() {
        return {
            open: false,
        }
    },
    methods: {
        manageClick() {
            this.handleClick(this.node)
            this.open = !this.open
        }
    },
};
</script>

<style scoped>
    .node-tree {
        list-style-type: none;
    }
</style>