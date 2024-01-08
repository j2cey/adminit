<template>
    <section>
        <b-field grouped group-multiline>
            <div class="control">
                <b-taglist attached>
                    <b-tag type="is-dark">Waiting</b-tag>
                    <b-tag type="is-info">{{ subsWaitingCount }}</b-tag>
                </b-taglist>
            </div>

            <div class="control">
                <b-taglist attached>
                    <b-tag type="is-dark">Queued</b-tag>
                    <b-tag type="is-warning">{{ subsQueuedCount }}</b-tag>
                </b-taglist>
            </div>

            <div class="control">
                <b-taglist attached>
                    <b-tag type="is-dark">Running</b-tag>
                    <b-tag type="is-danger">{{ subsRunningCount }}</b-tag>
                </b-taglist>
            </div>
            <div class="control">
                <b-taglist attached>
                    <b-tag type="is-dark">Retrying</b-tag>
                    <b-tag type="is-danger">{{ subsRetryingCount }}</b-tag>
                </b-taglist>
            </div>

            <div class="control">
                <b-taglist attached>
                    <b-tag type="is-dark">Success</b-tag>
                    <b-tag type="is-success is-light">{{ subsSuccessCount }}</b-tag>
                </b-taglist>
            </div>

            <div class="control">
                <b-taglist attached>
                    <b-tag type="is-dark">Failed</b-tag>
                    <b-tag type="is-danger is-light">{{ subsFailedCount }}</b-tag>
                </b-taglist>
            </div>
        </b-field>

        <div :id="'treatmentinfos_' + treatment.uuid">
            <div class="card">
                <header>
                    <div class="card-header-title row">
                        <div class="col-md-6 col-sm-8 col-12">
                            <span class="text-purple text-xs" @click="collapseClicked('collapse_treatmentinfos_icon', collapse_treatmentinfos_icon)" data-toggle="collapse" :data-parent="'#treatmentinfos_' + treatment.uuid" :href="'#collapse-treatmentinfos-access-'+index">
                                Infos / State
                            </span>
                        </div>
                        <div class="col-md-6 col-sm-4 col-12 text-right">
                            <span class="text text-sm">

                                <span v-if="treatment.state === 'completed'" class="badge badge-pill badge-success">{{ treatment.state }}</span>
                                <span v-else-if="treatment.state === 'running' || treatment.state === 'retrying'" class="badge badge-pill badge-danger">{{ treatment.state }}</span>
                                <span v-else-if="treatment.state === 'queued'" class="badge badge-pill badge-warning">{{ treatment.state }}</span>
                                <span v-else class="badge badge-pill badge-info">{{ treatment.state }}</span>

                                <a type="button" class="btn btn-tool" @click="collapseClicked('collapse_treatmentinfos_icon', collapse_treatmentinfos_icon)" data-toggle="collapse" :data-parent="'#treatmentinfos_' + treatment.uuid" :href="'#collapse-treatmentinfos-access-'+index">
                                    <i :class="currentTreatmentInfosCollapseIcon"></i>
                                </a>
                            </span>
                        </div>
                    </div>
                    <!-- /.user-block -->
                </header>
                <!-- /.card-header -->
                <div :id="'collapse-treatmentinfos-access-'+index" class="card-content panel-collapse collapse in">

                    <div class="row">

                        <div class="col-md-6 col-sm-6 col-6">
                            <dl>
                                <dt class="text text-xs">Name</dt>
                                <dd class="text text-xs">{{ treatment.name }}</dd>
                                <dt class="text text-xs">Création</dt>
                                <dd class="text text-xs">{{ treatment.created_at | formatDate}}</dd>
                            </dl>
                        </div>
                        <div class="col-md-6 col-sm-6 col-6">
                            <dl>
                                <dt class="text text-xs">Start at</dt>
                                <dd class="col-sm-8 offset-sm-4 text-xs">{{ treatment.start_at | formatDate }}</dd>
                                <dt class="text text-xs">End at</dt>
                                <dd class="col-sm-8 offset-sm-4 text-xs">{{ treatment.end_at | formatDate }}</dd>
                            </dl>
                        </div>
                        <!-- /.col -->
                    </div>

                </div>
                <!-- /.card-body -->
            </div>
        </div>

        <div :id="'treatmentresult_' + treatment.uuid">
            <div class="card">
                <header>
                    <div class="card-header-title row">
                        <div class="col-md-6 col-sm-8 col-12">
                            <span class="text-purple text-xs" @click="collapseClicked('collapse_treatmentresult_icon', collapse_treatmentresult_icon)" data-toggle="collapse" :data-parent="'#treatmentresult_' + treatment.uuid" :href="'#collapse-treatmentresult-access-'+index">
                                Result
                            </span>
                        </div>
                        <div class="col-md-6 col-sm-4 col-12 text-right">
                            <span class="text text-sm">

                                <span v-if="treatment.treatmentresult.result === 'success'" class="badge badge-pill badge-success">{{ treatment.treatmentresult.result }}</span>
                                <span v-else-if="treatment.treatmentresult.result === 'failed'" class="badge badge-pill badge-danger">{{ treatment.treatmentresult.result }}</span>
                                <span v-else class="badge badge-pill badge-default">{{ treatment.treatmentresult.result }}</span>

                                <a type="button" class="btn btn-tool" @click="collapseClicked('collapse_treatmentresult_icon', collapse_treatmentresult_icon)" data-toggle="collapse" :data-parent="'#treatmentresult_' + treatment.uuid" :href="'#collapse-treatmentresult-access-'+index">
                                    <i :class="currentTreatmentInfosCollapseIcon"></i>
                                </a>
                            </span>
                        </div>
                    </div>
                    <!-- /.user-block -->
                </header>
                <!-- /.card-header -->
                <div :id="'collapse-treatmentresult-access-'+index" class="card-content panel-collapse collapse in">

                    <div class="row">

                        <div class="col-md-6 col-sm-6 col-6">
                            <dl>
                                <dt class="text text-xs">Tentatives</dt>
                                <dd class="text text-xs">{{ treatment.attempts }}</dd>
                                <dt class="text text-xs">Début Réssais</dt>
                                <dd class="text text-xs">{{ treatment.retry_start_at | formatDate}}</dd>
                                <dt class="text text-xs">Nombre Réssais</dt>
                                <dd class="text text-xs">{{ treatment.retry_session_count }}</dd>
                            </dl>
                        </div>
                        <div class="col-md-6 col-sm-6 col-6">
                            <dl>
                                <dt class="text text-xs">Fin Réssais</dt>
                                <dd class="text text-xs">{{ treatment.retry_end_at | formatDate}}</dd>
                                <dt class="text text-xs">Message</dt>
                                <dd class="col-sm-8 offset-sm-4 text-xs">{{ treatment.treatmentresult.message ?? '' }}</dd>
                            </dl>
                        </div>
                        <!-- /.col -->
                    </div>

                </div>
                <!-- /.card-body -->
            </div>
        </div>

        <div class="card">
            <div class="card-header">

                <h6>
                    Current / Last
                    <small class="text text-xs">
                        {{ treatmentCurrLast.length === 0 ? "" : " (" + treatmentCurrLast.length + ")" }}
                    </small>
                </h6>

                <div class="card-tools">

                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <table class="table table-head-fixed text-nowrap">
                    <thead>
                    <tr>
                        <th>
                            <div class="row">
                                <div class="col-sm-2 col-6">
                                    <span class="text text-xs">ID</span>
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-2 col-6">
                                    <span class="text text-xs">Name</span>
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-2 col-6">
                                    <span class="text text-xs">State</span>
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-2 col-6">
                                    <span class="text text-xs">Result</span>
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-2 col-6">
                                    <span class="text text-xs">Start/End</span>
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-2 col-6">
                                    <span class="text text-xs"></span>
                                </div>
                            </div>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(treatmentcurr, index) in treatmentCurrLast" v-if="treatmentCurrLast.length > 0" :key="treatmentcurr.id" class="text text-xs">
                        <td v-if="index < 10">

                            <div class="row">
                                <div class="col-sm-2 col-6 border-right">
                                    <span class="text text-xs d-inline-block text-truncate text-xs-left">{{ treatmentcurr ? treatmentcurr.id : '' }}</span>
                                </div>
                                <div class="col-sm-2 col-6 border-right">
                                    <span class="text text-xs d-inline-block text-truncate text-xs-left">{{ treatmentcurr ? treatmentcurr.name : '' }}</span>
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-2 col-6 border-right">
                                    <span class="text text-xs text-green" v-if="treatmentcurr && treatmentcurr.state === 'completed'">{{ treatmentcurr ? treatmentcurr.state : '' }}</span>
                                    <span class="text text-xs text-danger" v-else-if="treatmentcurr && (treatmentcurr.state === 'running' || treatmentcurr.state === 'retrying')">{{ treatmentcurr ? treatmentcurr.state : '' }}</span>
                                    <span class="text text-xs text-warning" v-else-if="treatmentcurr && (treatmentcurr.state === 'queued')">{{ treatmentcurr ? treatmentcurr.state : '' }}</span>
                                    <span class="text text-xs text-info" v-else>{{ treatmentcurr ? treatmentcurr.state : '' }}</span>
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-2 col-6 border-right">
                                    <span class="text text-xs text-green" v-if="treatmentcurr.treatmentresult && treatmentcurr.treatmentresult.result === 'success'">{{ treatmentcurr.treatmentresult ? treatmentcurr.treatmentresult.result : '' }}</span>
                                    <span class="text text-xs text-warning" v-else-if="treatmentcurr && treatmentcurr.treatmentresult.result === 'failed'">{{ treatmentcurr.treatmentresult ? treatmentcurr.treatmentresult.result : '' }}</span>
                                    <span class="text text-xs text-info" v-else>{{ treatmentcurr.treatmentresult ? treatmentcurr.treatmentresult.result : '' }}</span>
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-2 col-6 border-right">
                                    <span class="text text-xs" v-if="treatmentcurr.start_at">
                                        {{ treatmentcurr ? treatmentcurr.start_at : '' | formatDate }}
                                    </span> /
                                    <span class="text text-xs" v-if="treatmentcurr.end_at">
                                        {{ treatmentcurr ? treatmentcurr.end_at : '' | formatDate }}
                                    </span>
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-2 col-6">
                                    <span class="text text-xs text-center">
                                        <div class="block">
                                            <a @click="editReportFileAccess(reportfileaccess)" class="tw-inline-block tw-mr-3 text-success">
                                                <b-icon
                                                    pack="fas"
                                                    icon="eye"
                                                    size="is-small">
                                                </b-icon>
                                            </a>
                                            <a @click="editReportFileAccess(reportfileaccess)" class="tw-inline-block tw-mr-3 text-warning">
                                                <b-icon
                                                    pack="fas"
                                                    icon="pencil-square-o"
                                                    size="is-small">
                                                </b-icon>
                                            </a>
                                            <a @click="deleteReportFileAccess(reportfileaccess)" class="tw-inline-block tw-mr-3 text-danger">
                                                <b-icon
                                                    pack="fas"
                                                    icon="trash"
                                                    size="is-small">
                                                </b-icon>
                                            </a>
                                        </div>
                                    </span>
                                </div>

                            </div>


                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <!-- ./card-body -->
            <div class="card-footer">

            </div>
            <!-- /.card-footer -->
        </div>

    </section>
</template>

<script>
export default {
    name: "treatment-item",
    props: {
        treatment_prop: {}
    },
    components: {
        //SubTreatmentsList: () => import('./list'),
    },
    created() {
        // eslint-disable-next-line no-undef
        axios.get(`/treatments.subs/${this.treatment_prop.id}`)
            .then(({data}) => this.subs = data);
    },
    data() {
        return {
            treatment: this.treatment_prop,
            subs: null,
            index: this.treatment_prop.id,
            collapse_treatmentinfos_icon: 'fas fa-chevron-down',
            collapse_treatmentresult_icon: 'fas fa-chevron-down',
            collapse_treatmentcurrlast_icon: 'fas fa-chevron-down',
        };
    },
    methods: {
        collapseClicked(collapsevar, collapseicon) {
            if (collapseicon === 'fas fa-chevron-down') {
                this[collapsevar] = 'fas fa-chevron-up';
            } else {
                this[collapsevar] = 'fas fa-chevron-down';
            }
        }
    },
    computed: {
        // eslint-disable-next-line vue/return-in-computed-property
        subsSuccessCount() {
            console.log("subs: ", this.subs)
            if (this.subs == null) {
                return 0;
            }
            return this.subs.success_count
        },
        subsFailedCount() {
            if (this.subs == null) {
                return 0;
            }
            return this.subs.failed_count
        },
        subsRetryingCount() {
            if (this.subs == null) {
                return 0;
            }
            return this.subs.retrying_count
        },
        subsRunningCount() {
            if (this.subs == null) {
                return 0;
            }
            return this.subs.running_count
        },
        subsQueuedCount() {
            if (this.subs == null) {
                return 0;
            }
            return this.subs.queued_count
        },
        subsWaitingCount() {
            if (this.subs == null) {
                return 0;
            }
            return this.subs.waiting_count
        },
        treatmentCurrLast() {
            if (this.subs == null) {
                return [];
            }
            return this.subs.lastsusbs
        },

        currentTreatmentInfosCollapseIcon() {
            return this.collapse_treatmentinfos_icon;
        }
    }
}
</script>

<style scoped>

</style>
