<template>
    <b-tabs size="is-small" type="is-boxed">
        <b-tab-item>
            <template #header>
                <b-icon icon="info-circle" pack="fa"></b-icon>
                <span> Infos </span>
            </template>

            <div class="row">
                <div class="col">
                    <dl>
                        <dt class="text text-xs">Name</dt>
                        <dd class="text text-xs">{{ reporttreatmentstepresult.name }}</dd>
                        <dt class="text text-xs">Start at</dt>
                        <dd class="col-sm-8 offset-sm-4 text-xs">{{ reporttreatmentstepresult.start_at | formatDate }}</dd>
                        <dt class="text text-xs">End at</dt>
                        <dd class="col-sm-8 offset-sm-4 text-xs">{{ reporttreatmentstepresult.end_at | formatDate }}</dd>
                        <dt class="text text-xs">Création</dt>
                        <dd class="text text-xs">{{ reporttreatmentstepresult.created_at | formatDate}}</dd>
                    </dl>
                </div>
                <div class="col">
                    <dl>
                        <dt class="text text-xs">Result</dt>
                        <dd class="col-sm-8 offset-sm-4 text-xs">
                            <span v-if="reporttreatmentstepresult.result === 'success'" class="badge badge-pill badge-success">{{ reporttreatmentstepresult.result }}</span>
                            <span v-else-if="reporttreatmentstepresult.result === 'failed'" class="badge badge-pill badge-danger">{{ reporttreatmentstepresult.result }}</span>
                            <span v-else class="badge badge-pill badge-default">{{ reporttreatmentstepresult.result }}</span>
                        </dd>
                        <dt class="text text-xs">State</dt>
                        <dd class="text text-xs">
                            <span v-if="reporttreatmentstepresult.state === 'completed'" class="badge badge-pill badge-success">{{ reporttreatmentstepresult.state }}</span>
                            <span v-else-if="reporttreatmentstepresult.state === 'running'" class="badge badge-pill badge-danger">{{ reporttreatmentstepresult.state }}</span>
                            <span v-else-if="reporttreatmentstepresult.state === 'queued'" class="badge badge-pill badge-warning">{{ reporttreatmentstepresult.state }}</span>
                            <span v-else class="badge badge-pill badge-info">{{ reporttreatmentstepresult.state }}</span>
                        </dd>
                        <dt class="text text-xs">Message</dt>
                        <dd class="col-sm-8 offset-sm-4 text-xs">{{ reporttreatmentstepresult.message }}</dd>
                        <dt class="text text-xs">Last Operation</dt>
                        <dd v-if="reporttreatmentstepresult.latestOperationresult" class="col-sm-8 offset-sm-4 text-xs">{{ reporttreatmentstepresult.latestOperationresult.name ?? '' }}</dd>
                        <dd v-if="reporttreatmentstepresult.latestOperationresult" class="col-sm-8 offset-sm-4 text-xs">
                            <span v-if="reporttreatmentstepresult.latestOperationresult.result === 'success'" class="badge badge-pill badge-success">{{ reporttreatmentstepresult.latestOperationresult.result }}</span>
                            <span v-else-if="reporttreatmentstepresult.latestOperationresult.result === 'failed'" class="badge badge-pill badge-danger">{{ reporttreatmentstepresult.latestOperationresult.result }}</span>
                            <span v-else class="badge badge-pill badge-default">{{ reporttreatmentstepresult.latestOperationresult.result }}</span>
                        </dd>
                        <dd v-if="reporttreatmentstepresult.latestOperationresult" class="col-sm-8 offset-sm-4 text-xs">
                            <span v-if="reporttreatmentstepresult.latestOperationresult.state === 'completed'" class="badge badge-pill badge-success">{{ reporttreatmentstepresult.latestOperationresult.state }}</span>
                            <span v-else-if="reporttreatmentstepresult.latestOperationresult.state === 'running'" class="badge badge-pill badge-danger">{{ reporttreatmentstepresult.latestOperationresult.state }}</span>
                            <span v-else-if="reporttreatmentstepresult.latestOperationresult.state === 'queued'" class="badge badge-pill badge-warning">{{ reporttreatmentstepresult.latestOperationresult.state }}</span>
                            <span v-else class="badge badge-pill badge-info">{{ reporttreatmentstepresult.latestOperationresult.state }}</span>
                        </dd>

                        <dt class="text text-xs">Object</dt>
                        <dd class="col-sm-8 offset-sm-4 text-xs">{{ reporttreatmentstepresult.hasreporttreatmentstepresults_type }}</dd>
                        <dd class="col-sm-8 offset-sm-4 text-xs">{{ reporttreatmentstepresult.hasreporttreatmentstepresults_id }}</dd>
                    </dl>
                </div>
            </div>
        </b-tab-item>

        <b-tab-item>
            <template #header>
                <b-icon icon="list-ol" pack="fa"></b-icon>
                <span class="help-inline pr-1 text-sm"> Operations </span>
                <b-tag rounded type="is-info is-light">{{ reporttreatmentstepresult.operationresults.length ?? 'NULL' }}</b-tag>
            </template>

            <OperationsList :operationresults_prop="reporttreatmentstepresult.operationresults"></OperationsList>

        </b-tab-item>
    </b-tabs>
</template>

<script>
export default {
    name: "reporttreatmentstepresult-item",
    props: {
        reporttreatmentstepresult_prop: {}
    },
    components: {
        OperationsList: () => import('../operationresults/list'),
    },
    data() {
        return {
            reporttreatmentstepresult: this.reporttreatmentstepresult_prop,
        };
    },
}
</script>

<style scoped>

</style>
