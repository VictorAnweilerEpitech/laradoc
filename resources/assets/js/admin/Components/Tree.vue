<template>
  <div class="tree">
    <h6>Catégories</h6>
    <ul class="tree-list">
      <node-tree :node="treeData" :handle-click="handleClick"></node-tree>
    </ul>
  </div>
</template>

<script>
import NodeTree from "./NodeTree";

export default {
  props: {
    treeData: {}
  },
  components: {
    NodeTree
  },
  methods: {
    handleClick (node) {
      this.$emit('node-click', node);
    }
  }
};
</script>