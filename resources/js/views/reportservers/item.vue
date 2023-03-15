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
                        <dt class="text text-xs">Nom</dt>
                        <dd class="text text-xs">{{ reportserver.name }}</dd>
                        <dt class="text text-xs">Adresse IP</dt>
                        <dd class="text text-xs">{{ reportserver.ip_address }}</dd>
                        <dt class="text text-xs">Nom du domaine</dt>
                        <dd class="text text-xs">{{ reportserver.domain_name }}</dd>
                        <dt class="text text-xs">Statut</dt>
                        <dd class="text text-xs">{{ reportserver.status.name }}</dd>
                        <dt class="text text-xs">Système d'exploitation</dt>
                        <dd class="text text-xs">{{ reportserver.osserver}}</dd>
                        <dt class="text text-xs">Created at</dt>
                        <dd class="text text-xs">{{ reportserver.created_at | formatDate}}</dd>
                    </dl>
                </div>
            </div>
        </b-tab-item>

        <b-tab-item>
            <template #header>
                <b-icon icon="source-pull"></b-icon>
                <span class="help-inline pr-1 text-sm">Server</span>
                <b-button size="is-small" type="is-ghost" @click="createReportFileAccess(reportserver)"><i class="fas fa-plus"></i></b-button>
            </template>

            <ReportFileAccessList></ReportFileAccessList>

        </b-tab-item>
    </b-tabs>
</template>

<script>
export default {
    props: {
        reportserver_prop: {}
    },
    name: "report-server-item",
    components: {
        ReportFileAccessList: () => import('../reportfileaccesses/list'),
    },
    data() {
        return {
            reportserver: this.reportserver_prop,
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
