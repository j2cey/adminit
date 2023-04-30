<template>
    <div class="row">
        <div class="col">
            <dl>
                <dt class="text text-xs">Name</dt>
                <dd class="text text-xs">{{ operationresult.name }}</dd>
                <dt class="text text-xs">Start at</dt>
                <dd class="col-sm-8 offset-sm-4 text-xs">{{ operationresult.start_at | formatDate }}</dd>
                <dt class="text text-xs">End at</dt>
                <dd class="col-sm-8 offset-sm-4 text-xs">{{ operationresult.end_at | formatDate }}</dd>
                <dt class="text text-xs">Operation No</dt>
                <dd class="text text-xs">{{ operationresult.operation_no}}</dd>
                <dt class="text text-xs">Criticality Level</dt>
                <dd class="text text-xs">
                    <b-tag rounded size="is-small" v-if="operationresult.criticality_level === 'high'"  type="is-danger">{{ operationresult.criticality_level }}</b-tag>
                    <b-tag rounded size="is-small" v-else-if="operationresult.criticality_level === 'medium'"  type="is-warning">{{ operationresult.criticality_level }}</b-tag>
                    <b-tag rounded size="is-small" v-else-if="operationresult.criticality_level === 'low'"  type="is-success">{{ operationresult.criticality_level }}</b-tag>
                    <b-tag rounded size="is-small" v-else type="is-info">{{ operationresult.criticality_level }}</b-tag>
                </dd>
                <dt class="text text-xs">Création</dt>
                <dd class="text text-xs">{{ operationresult.created_at | formatDate }}</dd>
            </dl>
        </div>
        <div class="col">
            <dl>
                <dt class="text text-xs">Result</dt>
                <dd class="col-sm-8 offset-sm-4 text-xs">
                    <span v-if="operationresult.result === 'success'" class="badge badge-pill badge-success">{{ operationresult.result }}</span>
                    <span v-else-if="operationresult.result === 'failed'" class="badge badge-pill badge-danger">{{ operationresult.result }}</span>
                    <span v-else class="badge badge-pill badge-default">{{ operationresult.result }}</span>
                </dd>
                <dt class="text text-xs">State</dt>
                <dd class="text text-xs">
                    <span v-if="operationresult.state === 'completed'" class="badge badge-pill badge-success">{{ operationresult.state }}</span>
                    <span v-else-if="operationresult.state === 'running'" class="badge badge-pill badge-danger">{{ operationresult.state }}</span>
                    <span v-else-if="operationresult.state === 'queued'" class="badge badge-pill badge-warning">{{ operationresult.state }}</span>
                    <span v-else class="badge badge-pill badge-info">{{ operationresult.state }}</span>
                </dd>
                <dt class="text text-xs">Message</dt>
                <dd class="col-sm-8 offset-sm-4 text-xs">{{ operationresult.message }}</dd>
            </dl>
        </div>
    </div>
</template>

<script>
export default {
    name: "operationresult-item",
    props: {
        operationresult_prop: {}
    },
    components: {

    },
    data() {
        return {
            operationresult: this.operationresult_prop,
        };
    },
}
</script>

<style scoped>

</style>
