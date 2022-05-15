<template>
    <div class="mb-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white py-2">
                <li class="breadcrumb-item"><a :href="$laraConfig.url_prefix">Accueil</a></li>
                <li class="breadcrumb-item">
                   <router-link :to="{name: 'home'}">Documentations</router-link>
                </li>
                <li class="breadcrumb-item" v-if="displayDocBreadcrumb">
                   Edition
                </li>
            </ol>
        </nav>
        <slot></slot>
    </div>
</template>

<script>
export default {
    name: 'admin-template',
    props: {
        config: {
            type: Object,
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
        },
        displayDocBreadcrumb() {
            let urls = ['structure.page.view']
            console.log(this.$route.name);
            return urls.find((url) => url == this.$route.name)
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
