<template>
    <section>
        <div class="tile is-ancestor">
            <div class="tile is-parent">
                <article class="tile is-child notification is-info is-light">
                    <p class="title is-4">Waiting</p>
                    <p class="subtitle is-6">{{ waiting }}</p>
                </article>
            </div>
            <div class="tile is-parent">
                <article class="tile is-child notification is-warning is-light">
                    <p class="title is-4">Queued</p>
                    <p class="subtitle is-6">{{ queued }}</p>
                </article>
            </div>
            <div class="tile is-parent">
                <article class="tile is-child notification is-danger is-light">
                    <p class="title is-4">Running</p>
                    <p class="subtitle is-6">{{ running }}</p>
                </article>
            </div>
            <div class="tile is-parent">
                <article class="tile is-child notification is-danger is-light">
                    <p class="title is-4">Retrying</p>
                    <p class="subtitle is-6">{{ retrying }}</p>
                </article>
            </div>
            <div class="tile is-parent">
                <article class="tile is-child notification is-success is-light">
                    <p class="title is-4">Success</p>
                    <p class="subtitle is-6">{{ success }}</p>
                </article>
            </div>
            <div class="tile is-parent">
                <article class="tile is-child notification is-danger is-light">
                    <p class="title is-4">Failed</p>
                    <p class="subtitle is-6">{{ failed }}</p>
                </article>
            </div>
        </div>

        <TreatmentList :treatments_prop="treatments"></TreatmentList>

    </section>
</template>

<script>
export default {
    name: "treatment-index",
    props: {
        treatments_prop: {},
        waiting_count_prop: {type: Number, default: 0},
        queued_count_prop: {type: Number, default: 0},
        running_count_prop: {type: Number, default: 0},
        retrying_count_prop: {type: Number, default: 0},
        success_count_prop: {type: Number, default: 0},
        failed_count_prop: {type: Number, default: 0},
    },
    components: {
        TreatmentList: () => import('./list'),
    },
    data() {
        return {
            treatments: this.treatments_prop,
            waiting: this.waiting_count_prop,
            queued: this.queued_count_prop,
            running: this.running_count_prop,
            retrying: this.retrying_count_prop,
            success: this.success_count_prop,
            failed: this.failed_count_prop,
        };
    },
}
</script>

<style scoped>

</style>
