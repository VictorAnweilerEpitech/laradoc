<template>
    <div>
        <admin-template v-if="laraConfig && user" :config="laraConfig" :user="user">
            {{$route.params.id}}
        </admin-template>
    </div>
</template>

<script>
import BaseComponent from './../../default/Components/BaseComponent'
import AdminTemplate from './Template'

import axios from 'axios'

export default {
    name: 'admin-members',
    extends: BaseComponent,

    components: {
        AdminTemplate,
    },

    data() {
        return {
        }
    },

    methods: {
    },

    mounted() {
    }
}
</script>
