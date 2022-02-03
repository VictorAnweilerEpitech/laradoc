<template>
    <div>
        <div class="alert" :class="'alert-' + type" role="alert">
            {{value}}
        </div>
    </div>
</template>

<script>
export default {
    props: {
        type: {
            type: String,
            default: "primary"
        },
        value: {
            type: String,
            default: ""
        }
    }
}
</script>
