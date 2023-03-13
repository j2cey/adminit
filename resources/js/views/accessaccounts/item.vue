<template>
    <b-tabs size="is-small" type="is-boxed">
        <b-tab-item>
            <template #header>
                <b-icon icon="information-outline"></b-icon>
                <span> Infos </span>
            </template>

            <div class="card card-default">
                <div class="card-body">
                    <dl>
                        <dt class="text text-xs">Login</dt>
                        <dd class="text text-xs">{{ accessaccount.login }}</dd>
                        <dt class="text text-xs">Password</dt>
                        <dd class="text text-xs">{{ accessaccount.pwd }}</dd>
                        <dt class="text text-xs">Email</dt>
                        <dd class="text text-xs">{{ accessaccount.email }}</dd>
                        <dt class="text text-xs">Username</dt>
                        <dd class="text text-xs">{{ accessaccount.username }}</dd>
                        <dt class="text text-xs">Statut</dt>
                        <dd class="text text-xs">{{ accessaccount.status.name }}</dd>
                        <dt class="text text-xs">Created at</dt>
                        <dd class="text text-xs">{{ accessaccount.created_at | formatDate}}</dd>
                    </dl>
                </div>
            </div>
        </b-tab-item>

        <b-tab-item>
            <template #header>
                <b-icon icon="source-pull"></b-icon>
                <span class="help-inline pr-1 text-sm"> Accès </span>
                <b-button size="is-small" type="is-ghost" @click="createReportFileAccess(accessaccount)"><i class="fas fa-plus"></i></b-button>
            </template>

            <ReportFileAccessList></ReportFileAccessList>

        </b-tab-item>
    </b-tabs>
</template>

<script>
export default {
    props: {
        accessaccount_prop: {}
    },
    name: "access-account-item",
    components: {
        ReportFileAccessList: () => import('../reportfileaccesses/list'),
    },
    data() {
        return {
            accessaccount: this.accessaccount_prop,
        };
    },
    methods: {
        createReportFileAccess(val) {
            console.log("TODO: createReportFileAccess", val)
        },
    }
}
</script>

<style scoped>

</style>
