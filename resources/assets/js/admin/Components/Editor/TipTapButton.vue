<template>
    <div>
        <span
        @click="getClick"
        class="tiptap-btn rounded p-2"
        :class="isSelected ? 'bg-dark text-white' : 'text-dark border'">
            <template v-if="icon.split(' ')[0] == 'fas'">
                <i :class="icon"></i>
            </template>
            <template v-else-if="icon.split(' ')[0] == 'bi'">
                <b-icon :icon="icon.split(' ')[1]" />
            </template>
            <template v-else>
                <span v-html="icon"></span>
            </template>
        </span>
    </div>
</template>

<script>
    export default {
        watch: {
            isActive: function(value) {
                this.isSelected = value
            }
        },
        props: {
            icon: {
                type: String,
                required: true,
            },
            action: {
                required: true
            },
            isActive: {
                default: false
            }
        },
        data() {
            return {
                isSelected: false,
            }
        },
        methods: {
            getClick() {
                this.action()
            }
        }
    }
</script>

<style>
.tiptap-btn {
    cursor: pointer !important;
}
</style>
