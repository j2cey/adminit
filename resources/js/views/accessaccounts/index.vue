<template>
    <AccountAccessList :accessaccounts_prop="accessaccounts"></AccountAccessList>
</template>

<script>

export default {
    props: {
        accessaccounts_prop: {}
    },
    name: "access-account-index",
    components: {
        AccountAccessList: () => import('../accessaccounts/list'),
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
