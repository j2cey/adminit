<template>
    <AccessAccountList :accessaccounts_prop="accessaccounts"></AccessAccountList>
</template>

<script>

export default {
    props: {
        accessaccounts_prop: {}
    },
    name: "access-account-index",
    components: {
        AccessAccountList: () => import('../accessaccounts/list'),
    },
    data() {
        return {
            accessaccounts: this.accessaccounts_prop,
        };
    },
}
</script>

<style scoped>

</style>
