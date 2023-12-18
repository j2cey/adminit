<template>
    <div class="row">
        <div class="col">
            <dl>
                <dt class="text text-xs">Name</dt>
                <dd class="text text-xs">{{ treatmentoperation.name }}</dd>
                <dt class="text text-xs">Start at</dt>
                <dd class="col-sm-8 offset-sm-4 text-xs">{{ treatmentoperation.start_at | formatDate }}</dd>
                <dt class="text text-xs">End at</dt>
                <dd class="col-sm-8 offset-sm-4 text-xs">{{ treatmentoperation.end_at | formatDate }}</dd>
                <dt class="text text-xs">Operation No</dt>
                <dd class="text text-xs">{{ treatmentoperation.operation_no}}</dd>
                <dt class="text text-xs">Criticality Level</dt>
                <dd class="text text-xs">
                    <b-tag rounded size="is-small" v-if="treatmentoperation.criticality_level === 'high'"  type="is-danger">{{ treatmentoperation.criticality_level }}</b-tag>
                    <b-tag rounded size="is-small" v-else-if="treatmentoperation.criticality_level === 'medium'"  type="is-warning">{{ treatmentoperation.criticality_level }}</b-tag>
                    <b-tag rounded size="is-small" v-else-if="treatmentoperation.criticality_level === 'low'"  type="is-success">{{ treatmentoperation.criticality_level }}</b-tag>
                    <b-tag rounded size="is-small" v-else type="is-info">{{ treatmentoperation.criticality_level }}</b-tag>
                </dd>
                <dt class="text text-xs">Création</dt>
                <dd class="text text-xs">{{ treatmentoperation.created_at | formatDate }}</dd>

                <dt class="text text-xs">Tentatives</dt>
                <dd class="text text-xs">{{ treatmentoperation.attempts }}</dd>
                <dt class="text text-xs">Début Réssais</dt>
            </dl>
        </div>
        <div class="col">
            <dl>
                <dt class="text text-xs">Result</dt>
                <dd class="col-sm-8 offset-sm-4 text-xs">
                    <span v-if="treatmentoperation.result === 'success'" class="badge badge-pill badge-success">{{ treatmentoperation.result }}</span>
                    <span v-else-if="treatmentoperation.result === 'failed'" class="badge badge-pill badge-danger">{{ treatmentoperation.result }}</span>
                    <span v-else class="badge badge-pill badge-default">{{ treatmentoperation.result }}</span>
                </dd>
                <dt class="text text-xs">State</dt>
                <dd class="text text-xs">
                    <span v-if="treatmentoperation.state === 'completed'" class="badge badge-pill badge-success">{{ treatmentoperation.state }}</span>
                    <span v-else-if="treatmentoperation.state === 'running'" class="badge badge-pill badge-danger">{{ treatmentoperation.state }}</span>
                    <span v-else-if="treatmentoperation.state === 'queued'" class="badge badge-pill badge-warning">{{ treatmentoperation.state }}</span>
                    <span v-else class="badge badge-pill badge-info">{{ treatmentoperation.state }}</span>
                </dd>
                <dt class="text text-xs">Message</dt>
                <dd class="col-sm-8 offset-sm-4 text-xs">{{ treatmentoperation.message }}</dd>
                <dd class="text text-xs">{{ treatmentoperation.retry_start_at | formatDate}}</dd>
                <dt class="text text-xs">Nombre Réssais</dt>
                <dd class="text text-xs">{{ treatmentoperation.retries_session_count }}</dd>
                <dt class="text text-xs">Fin Réssais</dt>
                <dd class="text text-xs">{{ treatmentoperation.retry_end_at | formatDate}}</dd>
                <dt class="text text-xs">Nombre de Sous-operations</dt>
                <dd class="text text-xs">{{ treatmentoperation.childrenoperations.length | formatDate}}</dd>
                <dt class="text text-xs">Payload</dt>
                <dd class="col-sm-8 offset-sm-4 text-xs">{{ treatmentoperation.payload }}</dd>
            </dl>
        </div>
    </div>
</template>

<script>
export default {
    name: "treatmentoperation-item",
    props: {
        treatmentoperation_prop: {}
    },
    components: {

    },
    data() {
        return {
            treatmentoperation: this.treatmentoperation_prop,
        };
    },
}
</script>

<style scoped>

</style>
