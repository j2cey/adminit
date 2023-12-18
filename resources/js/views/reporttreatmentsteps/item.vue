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
                        <dd class="text text-xs">{{ reporttreatmentstep.name }}</dd>
                        <dt class="text text-xs">Start at</dt>
                        <dd class="col-sm-8 offset-sm-4 text-xs">{{ reporttreatmentstep.start_at | formatDate }}</dd>
                        <dt class="text text-xs">End at</dt>
                        <dd class="col-sm-8 offset-sm-4 text-xs">{{ reporttreatmentstep.end_at | formatDate }}</dd>
                        <dt class="text text-xs">Création</dt>
                        <dd class="text text-xs">{{ reporttreatmentstep.created_at | formatDate}}</dd>

                        <dt class="text text-xs">Tentatives</dt>
                        <dd class="text text-xs">{{ reporttreatmentstep.attempts }}</dd>
                        <dt class="text text-xs">Début Réssais</dt>
                        <dd class="text text-xs">{{ reporttreatmentstep.retry_start_at | formatDate}}</dd>
                        <dt class="text text-xs">Nombre Réssais</dt>
                        <dd class="text text-xs">{{ reporttreatmentstep.retries_session_count }}</dd>
                        <dt class="text text-xs">Fin Réssais</dt>
                        <dd class="text text-xs">{{ reporttreatmentstep.retry_end_at | formatDate}}</dd>
                    </dl>
                </div>
                <div class="col">
                    <dl>
                        <dt class="text text-xs">Result</dt>
                        <dd class="col-sm-8 offset-sm-4 text-xs">
                            <span v-if="reporttreatmentstep.result === 'success'" class="badge badge-pill badge-success">{{ reporttreatmentstep.result }}</span>
                            <span v-else-if="reporttreatmentstep.result === 'failed'" class="badge badge-pill badge-danger">{{ reporttreatmentstep.result }}</span>
                            <span v-else class="badge badge-pill badge-default">{{ reporttreatmentstep.result }}</span>
                        </dd>
                        <dt class="text text-xs">State</dt>
                        <dd class="text text-xs">
                            <span v-if="reporttreatmentstep.state === 'completed'" class="badge badge-pill badge-success">{{ reporttreatmentstep.state }}</span>
                            <span v-else-if="reporttreatmentstep.state === 'running'" class="badge badge-pill badge-danger">{{ reporttreatmentstep.state }}</span>
                            <span v-else-if="reporttreatmentstep.state === 'queued'" class="badge badge-pill badge-warning">{{ reporttreatmentstep.state }}</span>
                            <span v-else class="badge badge-pill badge-info">{{ reporttreatmentstep.state }}</span>
                        </dd>
                        <dt class="text text-xs">Message</dt>
                        <dd class="col-sm-8 offset-sm-4 text-xs">{{ reporttreatmentstep.message }}</dd>
                        <dt class="text text-xs">Last Operation</dt>
                        <dd v-if="reporttreatmentstep.latestOperation" class="col-sm-8 offset-sm-4 text-xs">{{ reporttreatmentstep.latestOperation.name ?? '' }}</dd>
                        <dd v-if="reporttreatmentstep.latestOperation" class="col-sm-8 offset-sm-4 text-xs">
                            <span v-if="reporttreatmentstep.latestOperation.result === 'success'" class="badge badge-pill badge-success">{{ reporttreatmentstep.latestOperation.result }}</span>
                            <span v-else-if="reporttreatmentstep.latestOperation.result === 'failed'" class="badge badge-pill badge-danger">{{ reporttreatmentstep.latestOperation.result }}</span>
                            <span v-else class="badge badge-pill badge-default">{{ reporttreatmentstep.latestOperation.result }}</span>
                        </dd>
                        <dd v-if="reporttreatmentstep.latestOperation" class="col-sm-8 offset-sm-4 text-xs">
                            <span v-if="reporttreatmentstep.latestOperation.state === 'completed'" class="badge badge-pill badge-success">{{ reporttreatmentstep.latestOperation.state }}</span>
                            <span v-else-if="reporttreatmentstep.latestOperation.state === 'running'" class="badge badge-pill badge-danger">{{ reporttreatmentstep.latestOperation.state }}</span>
                            <span v-else-if="reporttreatmentstep.latestOperation.state === 'queued'" class="badge badge-pill badge-warning">{{ reporttreatmentstep.latestOperation.state }}</span>
                            <span v-else class="badge badge-pill badge-info">{{ reporttreatmentstep.latestOperation.state }}</span>
                        </dd>

                        <dt class="text text-xs">Object</dt>
                        <dd class="col-sm-8 offset-sm-4 text-xs">{{ reporttreatmentstep.hasreporttreatmentsteps_type }}</dd>
                        <dd class="col-sm-8 offset-sm-4 text-xs">{{ reporttreatmentstep.hasreporttreatmentsteps_id }}</dd>
                        <dt class="text text-xs">Payload</dt>
                        <dd class="col-sm-8 offset-sm-4 text-xs">{{ reporttreatmentstep.payload }}</dd>
                        <dt class="text text-xs">Classe Service</dt>
                        <dd class="col-sm-8 offset-sm-4 text-xs">{{ reporttreatmentstep.treatmentstepservice_class }}</dd>
                    </dl>
                </div>
            </div>
        </b-tab-item>

        <b-tab-item>
            <template #header>
                <b-icon icon="list-ol" pack="fa"></b-icon>
                <span class="help-inline pr-1 text-sm"> Operations </span>
                <b-tag rounded type="is-info is-light">{{ reporttreatmentstep.treatmentoperations.length ?? 'NULL' }}</b-tag>
            </template>

            <OperationsList :treatmentoperations_prop="reporttreatmentstep.treatmentoperations"></OperationsList>

        </b-tab-item>
    </b-tabs>
</template>

<script>
export default {
    name: "reporttreatmentstep-item",
    props: {
        reporttreatmentstep_prop: {}
    },
    components: {
        OperationsList: () => import('../treatmentoperations/list'),
    },
    data() {
        return {
            reporttreatmentstep: this.reporttreatmentstep_prop,
        };
    },
}
</script>

<style scoped>

</style>
