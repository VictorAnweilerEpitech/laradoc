<template>
    <div></div>
</template>

<script>
import myAxios from './services/axios.service'

export default {
    props: {
        laraConfig: {
            type: Object,
            required: true,
        },
        user: {
            type: Object,
        }
    },
    computed: {
        baseUrl: function() {
            if (this.laraConfig && this.laraConfig.url_prefix) {
                return this.laraConfig.url_prefix 
            }
            return '/'
        }
    }
}
</script>
