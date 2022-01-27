<template>
    <div>
        <span
        @click="getClick"
        class="tiptap-btn rounded p-2"
        :class="isSelected ? 'bg-dark text-white' : 'text-dark border'">
            <i :class="icon"></i>
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
                required: true,
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
                if (!this.isActive) {
                    this.isSelected = !this.isSelected
                }
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
