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
                        <dd class="text text-xs">{{ reporttreatmentresult.name }}</dd>
                        <dt class="text text-xs">Start at</dt>
                        <dd class="col-sm-8 offset-sm-4 text-xs">{{ reporttreatmentresult.start_at | formatDate }}</dd>
                        <dt class="text text-xs">End at</dt>
                        <dd class="col-sm-8 offset-sm-4 text-xs">{{ reporttreatmentresult.end_at | formatDate }}</dd>
                        <dt class="text text-xs">Création</dt>
                        <dd class="text text-xs">{{ reporttreatmentresult.created_at | formatDate}}</dd>
                    </dl>
                </div>
                <div class="col">
                    <dl>
                        <dt class="text text-xs">Result</dt>
                        <dd class="col-sm-8 offset-sm-4 text-xs">
                            <span v-if="reporttreatmentresult.result === 'success'" class="badge badge-pill badge-success">{{ reporttreatmentresult.result }}</span>
                            <span v-else-if="reporttreatmentresult.result === 'failed'" class="badge badge-pill badge-danger">{{ reporttreatmentresult.result }}</span>
                            <span v-else class="badge badge-pill badge-default">{{ reporttreatmentresult.result }}</span>
                        </dd>
                        <dt class="text text-xs">State</dt>
                        <dd class="text text-xs">
                            <span v-if="reporttreatmentresult.state === 'completed'" class="badge badge-pill badge-success">{{ reporttreatmentresult.state }}</span>
                            <span v-else-if="reporttreatmentresult.state === 'running'" class="badge badge-pill badge-danger">{{ reporttreatmentresult.state }}</span>
                            <span v-else-if="reporttreatmentresult.state === 'queued'" class="badge badge-pill badge-warning">{{ reporttreatmentresult.state }}</span>
                            <span v-else class="badge badge-pill badge-info">{{ reporttreatmentresult.state }}</span>
                        </dd>
                        <dt class="text text-xs">Message</dt>
                        <dd class="col-sm-8 offset-sm-4 text-xs">{{ reporttreatmentresult.message }}</dd>
                        <dt class="text text-xs">Current/Last Step</dt>
                        <dd class="text text-xs">{{ reporttreatmentresult.currentstep.name ?? ''}}</dd>
                        <dt class="text text-xs">Object</dt>
                        <dd class="col-sm-8 offset-sm-4 text-xs">{{ reporttreatmentresult.hasreporttreatmentresults_type }}</dd>
                        <dd class="col-sm-8 offset-sm-4 text-xs">{{ reporttreatmentresult.hasreporttreatmentresults_id }}</dd>
                    </dl>
                </div>
            </div>
        </b-tab-item>

        <b-tab-item>
            <template #header>
                <b-icon icon="list-ol" pack="fa"></b-icon>
                <span class="help-inline pr-1 text-sm"> Steps </span>
                <b-tag rounded type="is-info is-light">{{ reporttreatmentresult.reporttreatmentsteps.length ?? 'NULL' }}</b-tag>
            </template>

            <ReportTreatmentStepResultsList :reporttreatmentstepresults_prop="reporttreatmentresult.reporttreatmentsteps"></ReportTreatmentStepResultsList>

        </b-tab-item>
    </b-tabs>
</template>

<script>
export default {
    name: "reporttreatmentresult-item",
    props: {
        reporttreatmentresult_prop: {}
    },
    components: {
        ReportTreatmentStepResultsList: () => import('../reporttreatmentstepresults/list'),
    },
    data() {
        return {
            reporttreatmentresult: this.reporttreatmentresult_prop,
        };
    },
}
</script>

<style scoped>

</style>
