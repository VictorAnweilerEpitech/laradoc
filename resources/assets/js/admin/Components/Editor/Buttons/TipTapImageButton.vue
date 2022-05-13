<template>
    <div>
        <dropdown-menu
        :dropup="true"
        mode="hover"
        direction="right"
        >
            <button slot="trigger" class="bg-white p-0 border-0">
                <span
                class="tiptap-btn rounded p-2 tip-tap-btn-not-selected border">
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
            </button>
            <div slot="body" class="p-3">
                <input v-model="url" class="form-control" placeholder="Url de l'image" type="text">
                <button @click="addImage" class="btn btn-success btn-sm mt-2">Ajouter</button>
            </div>
            <div slot="footer"></div>
        </dropdown-menu>
    </div>
</template>

<script>
export default {
    props: {
        icon: {
            type: String,
            required: true,
        },
    },
    data() {
        return {
            url: ""
        }
    },
    methods: {
        addImage() {
            if (this.url) {
                this.$parent.editor.commands.setImage({src: this.url})
                this.url = ""
            }
        }
    }
}
</script>
