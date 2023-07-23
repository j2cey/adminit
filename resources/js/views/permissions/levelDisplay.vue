<template>
    <small>
        <span v-if="permission.level === 1" class="badge badge-danger">{{ permission.level }}</span>
        <span v-else-if="permission.level === 2" class="badge badge-warning">{{ permission.level }}</span>
        <span v-else-if="permission.level === 3" class="badge badge-primary">{{ permission.level }}</span>
        <span v-else class="badge badge-success">{{ permission.level }}</span>
    </small>
</template>

<script>
export default {
    name: "permission-level-display",
    props: {
        permission_prop: {}
    },
    data() {
        return {
            permission: this.permission_prop,
        };
    },
}
</script>

<style scoped>

</style>
