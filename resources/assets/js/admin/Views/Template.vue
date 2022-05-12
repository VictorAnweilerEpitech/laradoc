<template>
    <div class="mb-5">
        <slot></slot>
    </div>
</template>

<script>
export default {
    name: 'admin-template',
    props: {
        config: {
            type: Object,
            required: true,
        },
        user: {
            type: Object,
            required: true,
        }
    },
    computed: {
        username() {
            return this.user[this.config.auth.loginColumn].replace(' ', '+')
        },
        avatar() {
            return 'https://eu.ui-avatars.com/api/?name=' + this.username
        }
    },
    methods: {
        btnIsSelected(routeName) {
            return routeName === this.$route.name ? 'nav-selected my-rounded border' : 'nav-not-selected'
        },
    }
}
</script>

<style>
.nav-not-selected {
    border: 1px solid #fff !important;
}

.nav-selected {
    background: #F4F4F4 !important;
}
</style>
