<template>
    <small>
        <span class="badge badge-default">{{ role.name }}</span>
    </small>
</template>

<script>
    export default {
        name: "role-display",
        props: {
            role_prop: {}
        },
        data() {
            return {
                role: this.role_prop,
            };
        },
    }
</script>

<style scoped>

</style>
