<template>
    <small>
        <span class="badge badge-danger" v-if="permission.level == 1">{{ permission.name }}</span>
        <span class="badge badge-warning" v-else-if="permission.level == 2">{{ permission.name }}</span>
        <span class="badge badge-primary" v-else-if="permission.level == 3">{{ permission.name }}</span>
        <span class="badge badge-success" v-else>{{ permission.name }}</span>
    </small>
</template>

<script>
export default {
    name: "display",
    props: {
        permission: {}
    }
}
</script>

<style scoped>

</style>
