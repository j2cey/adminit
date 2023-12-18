<template>
    <b-tabs size="is-small" type="is-boxed">

        <b-field grouped group-multiline>
            <div class="control">
                <b-taglist attached>
                    <b-tag type="is-dark">Waiting</b-tag>
                    <b-tag type="is-info">{{ reporttreatment.stepsWaitingCount }}</b-tag>
                </b-taglist>
            </div>

            <div class="control">
                <b-taglist attached>
                    <b-tag type="is-dark">Queued</b-tag>
                    <b-tag type="is-warning">{{ reporttreatment.stepsQueuedCount }}</b-tag>
                </b-taglist>
            </div>

            <div class="control">
                <b-taglist attached>
                    <b-tag type="is-dark">Running</b-tag>
                    <b-tag type="is-danger">{{ reporttreatment.stepsRunningCount }}</b-tag>
                </b-taglist>
            </div>
            <div class="control">
                <b-taglist attached>
                    <b-tag type="is-dark">Retrying</b-tag>
                    <b-tag type="is-danger">{{ reporttreatment.stepsRetryingCount }}</b-tag>
                </b-taglist>
            </div>

            <div class="control">
                <b-taglist attached>
                    <b-tag type="is-dark">Success</b-tag>
                    <b-tag type="is-success is-light">{{ reporttreatment.stepsSuccessCount }}</b-tag>
                </b-taglist>
            </div>

            <div class="control">
                <b-taglist attached>
                    <b-tag type="is-dark">Failed</b-tag>
                    <b-tag type="is-danger is-light">{{ reporttreatment.stepsFailedCount }}</b-tag>
                </b-taglist>
            </div>
        </b-field>

        <b-tab-item>
            <template #header>
                <b-icon icon="info-circle" pack="fa"></b-icon>
                <span> Infos </span>
            </template>

            <div class="row">
                <div class="col">
                    <dl>
                        <dt class="text text-xs">Name</dt>
                        <dd class="text text-xs">{{ reporttreatment.name }}</dd>
                        <dt class="text text-xs">Start at</dt>
                        <dd class="col-sm-8 offset-sm-4 text-xs">{{ reporttreatment.start_at | formatDate }}</dd>
                        <dt class="text text-xs">End at</dt>
                        <dd class="col-sm-8 offset-sm-4 text-xs">{{ reporttreatment.end_at | formatDate }}</dd>
                        <dt class="text text-xs">Création</dt>
                        <dd class="text text-xs">{{ reporttreatment.created_at | formatDate}}</dd>

                        <dt class="text text-xs">Tentatives</dt>
                        <dd class="text text-xs">{{ reporttreatment.attempts }}</dd>
                        <dt class="text text-xs">Début Réssais</dt>
                        <dd class="text text-xs">{{ reporttreatment.retry_start_at | formatDate}}</dd>
                        <dt class="text text-xs">Nombre Réssais</dt>
                        <dd class="text text-xs">{{ reporttreatment.retries_session_count }}</dd>
                        <dt class="text text-xs">Fin Réssais</dt>
                        <dd class="text text-xs">{{ reporttreatment.retry_end_at | formatDate}}</dd>
                    </dl>
                </div>
                <div class="col">
                    <dl>
                        <dt class="text text-xs">Result</dt>
                        <dd class="col-sm-8 offset-sm-4 text-xs">
                            <span v-if="reporttreatment.result === 'success'" class="badge badge-pill badge-success">{{ reporttreatment.result }}</span>
                            <span v-else-if="reporttreatment.result === 'failed'" class="badge badge-pill badge-danger">{{ reporttreatment.result }}</span>
                            <span v-else class="badge badge-pill badge-default">{{ reporttreatment.result }}</span>
                        </dd>
                        <dt class="text text-xs">State</dt>
                        <dd class="text text-xs">
                            <span v-if="reporttreatment.state === 'completed'" class="badge badge-pill badge-success">{{ reporttreatment.state }}</span>
                            <span v-else-if="reporttreatment.state === 'running' || reporttreatment.state === 'retrying'" class="badge badge-pill badge-danger">{{ reporttreatment.state }}</span>
                            <span v-else-if="reporttreatment.state === 'queued'" class="badge badge-pill badge-warning">{{ reporttreatment.state }}</span>
                            <span v-else class="badge badge-pill badge-info">{{ reporttreatment.state }}</span>
                        </dd>
                        <dt class="text text-xs">Message</dt>
                        <dd class="col-sm-8 offset-sm-4 text-xs">{{ reporttreatment.message }}</dd>
                        <dt class="text text-xs">Current/Last Step</dt>
                        <dd class="text text-xs">{{ reporttreatment.currentstep.name ?? ''}}</dd>
                        <dt class="text text-xs">Object</dt>
                        <dd class="col-sm-8 offset-sm-4 text-xs">{{ reporttreatment.hasreporttreatments_type }}</dd>
                        <dd class="col-sm-8 offset-sm-4 text-xs">{{ reporttreatment.hasreporttreatments_id }}</dd>
                    </dl>
                </div>
            </div>
        </b-tab-item>

        <b-tab-item>
            <template #header>
                <b-icon icon="list-ol" pack="fa"></b-icon>
                <span class="help-inline pr-1 text-sm"> Steps </span>
                <b-tag rounded type="is-info is-light">{{ reporttreatment.reporttreatmentsteps.length ?? 'NULL' }}</b-tag>
            </template>

            <ReportTreatmentStepsList :reporttreatmentsteps_prop="reporttreatment.reporttreatmentsteps"></ReportTreatmentStepsList>

        </b-tab-item>
    </b-tabs>
</template>

<script>
export default {
    name: "reporttreatment-item",
    props: {
        reporttreatment_prop: {}
    },
    components: {
        ReportTreatmentStepsList: () => import('../reporttreatmentsteps/list'),
    },
    data() {
        return {
            reporttreatment: this.reporttreatment_prop,
        };
    },
}
</script>

<style scoped>

</style>
