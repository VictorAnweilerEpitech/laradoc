<template>
    <div class="mb-5">
        <!-- <div class="bg-white border my-rounded bg-light p-4">
            <h5 class="mb-1">Administrateur</h5>
            <h6 class="font-weight-light text-secondary mb-3">Documentation</h6>
            <router-link :to="{ name: 'structure'}" class="d-block my-1 p-3 px-4 text-dark my-rounded" :class="btnIsSelected('structure')">
                <i class="fas fa-sitemap" style="margin-right: 8px;"></i>Structure
            </router-link>
            <router-link :to="{ name: 'members'}" class="d-block my-1 p-3 px-4 text-dark my-rounded" :class="btnIsSelected('members')">
                <i class="fas fa-users" style="margin-right: 8px;"></i>Membres
            </router-link>
        </div> -->
        <div class="p-3  border my-rounded" style="min-height: 500px;">
            <slot></slot>
        </div>
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
