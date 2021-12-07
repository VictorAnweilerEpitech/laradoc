<template>
    <div class="d-flex mb-5">
        <div class="col-3">
            <div class="bg-white border rounded bg-light p-4">
                <h5 class="mb-1">Administrateur</h5>
                <h6 class="font-weight-light text-secondary mb-3">Documentation</h6>
                <router-link :to="{ name: 'structure'}" class="d-block my-1 p-3 px-4 text-dark" :class="btnIsSelected('structure')">
                    <i class="fas fa-sitemap" style="margin-right: 8px;"></i>Structure
                </router-link>
                <router-link :to="{ name: 'members'}" class="d-block my-1 p-3 px-4 text-dark" :class="btnIsSelected('members')">
                    <i class="fas fa-users" style="margin-right: 8px;"></i>Membres
                </router-link>
                <!-- <router-link to="#" class="d-block my-1 p-3">
                    <i class="fas fa-list-ol" style="margin-right: 8px;"></i>Versions
                </router-link> -->
            </div>
        </div>
        <div class="col-9">
            <div class="p-3 bg-light border rounded" style="min-height: 500px;">
                <slot></slot>
            </div>
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
            return routeName === this.$route.name ? 'bg-light border rounded-pill' : ''
        },
    }
}
</script>
