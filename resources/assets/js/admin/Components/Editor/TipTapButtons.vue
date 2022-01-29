<template>
    <div @mouseover="onOver" @mouseleave="onLeave">
        <b-dropdown variant="white" class="dropdown-button-tipta" text="Dropdown Button" ref="dropdown">
            <template #button-content>
                <span
                class="tiptap-btn rounded p-2 text-dark border"
                >
                    <template v-if="buttons.icon.split(' ')[0] == 'fas'">
                        <i :class="buttons.icon"></i>
                    </template>
                    <template v-else-if="buttons.icon.split(' ')[0] == 'bi'">
                        <b-icon :icon="buttons.icon.split(' ')[1]" />
                    </template>
                    <template v-else>
                        <span v-html="buttons.icon"></span>
                    </template>
                </span>
            </template>
            <b-dropdown-text>
                <tip-tap-button
                v-for="(btn, index) in buttons.items"
                :key="'index-' + buttons.icon + '-' + index"
                :class="btn.class"
                :icon="btn.icon"
                :action="btn.action"
                :is-active="btn.isActive"
                />
            </b-dropdown-text>
        </b-dropdown>
    </div>
</template>

<script>
import TipTapButton from './TipTapButton.vue'
export default {
    props: {
        buttons: {
            required: true
        }
    },
    components: {
        TipTapButton
    },
    methods: {
        onOver() {
            this.$refs.dropdown.visible = true;
        },
        onLeave() {
            this.$refs.dropdown.visible = false;
        }
    }
}
</script>

<style>
.dropdown-button-tipta .dropdown-toggle {
    padding: 0px !important;
    margin-top: -5px;
}

.dropdown-toggle::after{
    display:none;
}
</style>
