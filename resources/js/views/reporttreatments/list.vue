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

        <!--        <b-field grouped group-multiline>
                    <div class="control">
                        <b-taglist attached>
                            <b-tag type="is-dark">Waiting</b-tag>
                            <b-tag type="is-info">0.5.1</b-tag>
                        </b-taglist>
                    </div>

                    <div class="control">
                        <b-taglist attached>
                            <b-tag type="is-dark">Queued</b-tag>
                            <b-tag type="is-warning">0.5.1</b-tag>
                        </b-taglist>
                    </div>

                    <div class="control">
                        <b-taglist attached>
                            <b-tag type="is-dark">Running</b-tag>
                            <b-tag type="is-danger">0.5.1</b-tag>
                        </b-taglist>
                    </div>

                    <div class="control">
                        <b-taglist attached>
                            <b-tag type="is-dark">Success</b-tag>
                            <b-tag type="is-success is-light">0.5.1</b-tag>
                        </b-taglist>
                    </div>

                    <div class="control">
                        <b-taglist attached>
                            <b-tag type="is-dark">Failed</b-tag>
                            <b-tag type="is-danger is-light">0.5.1</b-tag>
                        </b-taglist>
                    </div>
                </b-field>-->

        <b-field grouped group-multiline>
            <b-select v-model="perPage" :disabled="!isPaginated">
                <option value="5">5 per page</option>
                <option value="10">10 per page</option>
                <option value="15">15 per page</option>
                <option value="20">20 per page</option>
            </b-select>
        </b-field>
        <b-table
            :data="reporttreatments"
            ref="table"
            :debounce-search="1000"
            :paginated="isPaginated"
            :per-page="perPage"
            :opened-detailed="defaultOpenedDetails"
            detailed
            detail-key="id"
            :detail-transition="transitionName"
            :show-detail-icon="showDetailIcon"
            :current-page.sync="currentPage"
            :pagination-simple="isPaginationSimple"
            :pagination-position="paginationPosition"
            :default-sort-direction="defaultSortDirection"
            :pagination-rounded="isPaginationRounded"
            :sort-icon="sortIcon"
            :sort-icon-size="sortIconSize"
            :sticky-header="stickyHeaders"
            default-sort="row.name"
            aria-next-label="Next"
            aria-previous-label="Previous"
            aria-page-label="Page"
            aria-current-label="Current page" :before-destroy="false">

            <template v-for="column in columns">
                <b-table-column :key="column.id" v-bind="column" :sortable="column.sortable">
                    <template
                        v-if="column.searchable && !column.numeric"
                        #searchable="props">
                        <b-input
                            v-model="props.filters[props.column.field]"
                            placeholder="Search..."
                            icon="magnify"
                            size="is-small"
                            icon-right="close-circle"
                            icon-right-clickable
                            @icon-right-click="props.filters[props.column.field] = ''"
                        />
                    </template>

                    <template v-slot="props">
                        <span v-if="column.field === 'id'" class="text-xs">
                            {{ props.row[column.field] }}
                        </span>
                        <span v-else-if="column.field === 'name'" class="has-text-primary is-italic text-xs">
                            <a @click="showReportTreatment(props.row)">
                                {{ props.row[column.field] }}
                            </a>
                        </span>
                        <span v-else-if="column.field === 'report'" class="has-text-info is-italic text-xs">
                            <span v-if="props.row[column.field]">
                                <b-tag type="is-default is-light">{{ props.row[column.field].title }}</b-tag>
                            </span>
                            <span v-else></span>
                        </span>
                        <span v-else-if="column.field === 'currentstep'" class="has-text-warning is-italic text-xs">
                            <span v-if="props.row[column.field]">
                                <b-tag type="is-default is-light">{{ props.row[column.field].name }}</b-tag>
                            </span>
                            <span v-else></span>
                        </span>
                        <span v-else-if="column.field === 'result'" class="has-text-info is-italic text-xs">
                            <span v-if="props.row[column.field]">
                                <b-tag rounded v-if="props.row[column.field] === 'success'" type="is-success">{{ props.row[column.field] }}</b-tag>
                                <b-tag rounded v-else-if="props.row[column.field] === 'failed'" type="is-danger">{{ props.row[column.field] }}</b-tag>
                                <b-tag rounded v-else type="is-default">{{ props.row[column.field] }}</b-tag>
                            </span>
                            <span v-else></span>
                        </span>
                        <span v-else-if="column.field === 'state'" class="has-text-info is-italic text-xs">
                            <span v-if="props.row[column.field]">
                                <b-tag rounded v-if="props.row[column.field] === 'completed'" type="is-success">{{ props.row[column.field] }}</b-tag>
                                <b-tag rounded v-else-if="props.row[column.field] === 'running'" type="is-danger">{{ props.row[column.field] }}</b-tag>
                                <b-tag rounded v-else-if="props.row[column.field] === 'queued'" type="is-warning">{{ props.row[column.field] }}</b-tag>
                                <b-tag rounded v-else type="is-default">{{ props.row[column.field] }}</b-tag>
                            </span>
                            <span v-else></span>
                        </span>
                        <span v-else-if="column.field === 'start_at'" class="tag is-info is-light">
                            {{ props.row['start_at'] | formatDate }} / {{ props.row['end_at'] | formatDate }}
                        </span>
                        <span v-else-if="column.date" class="tag is-info is-light">
                            {{ props.row[column.field] | formatDate }}
                        </span>
                        <span v-else-if="column.field === 'actions'" class="text-xs">
                            <div class="block">
                                <a @click="editReportTreatment(props.row)" class="tw-inline-block tw-mr-3 text-warning">
                                    <b-icon
                                        pack="fas"
                                        icon="pencil-square-o"
                                        size="is-small">
                                    </b-icon>
                                </a>
                                <a @click="deleteReportTreatment(props.row)" class="tw-inline-block tw-mr-3 text-danger">
                                    <b-icon
                                        pack="fas"
                                        icon="trash"
                                        size="is-small">
                                    </b-icon>
                                </a>
                            </div>
                        </span>
                        <span v-else class="text-xs">
                            {{ props.row[column.field] }}
                        </span>
                    </template>
                </b-table-column>
            </template>

            <template #detail="props">

                <ReportTreatmentItem :reporttreatment_prop="props.row"></ReportTreatmentItem>

            </template>

            <template #empty>
                <div class="has-text-centered">No Data Available</div>
            </template>

        </b-table>

    </section>
</template>

<script>

import ReportTreatmentBus from "../reporttreatments/reporttreatmentBus";

export default {
    name: "reporttreatment-list",
    props: {
        reporttreatments_prop: {},
        waiting_prop: {type: Number, default: 0},
        queued_prop: {type: Number, default: 0},
        running_prop: {type: Number, default: 0},
        retrying_prop: {type: Number, default: 0},
        success_prop: {type: Number, default: 0},
        failed_prop: {type: Number, default: 0},
    },
    components: {
        ReportTreatmentItem: () => import('../reporttreatments/item'),
    },
    mounted() {
        ReportTreatmentBus.$on('reporttreatment_created', (reporttreatment) => {
            this.addReportTreatmentToList(reporttreatment)
        })

        ReportTreatmentBus.$on('reporttreatment_updated', (reporttreatment) => {
            this.updateReportTreatmentFromList(reporttreatment)
        })
    },
    data() {
        return {
            reporttreatments: this.reporttreatments_prop,
            waiting: this.waiting_prop,
            queued: this.queued_prop,
            running: this.running_prop,
            retrying: this.retrying_prop,
            success: this.success_prop,
            failed: this.failed_prop,
            isPaginated: true,
            isPaginationSimple: false,
            isPaginationRounded: true,
            paginationPosition: 'bottom',
            defaultSortDirection: 'asc',
            sortIcon: 'arrow-up',
            sortIconSize: 'is-small',
            currentPage: 1,
            perPage: 10,
            defaultOpenedDetails: [-1],
            showDetailIcon: true,
            useTransition: false,
            stickyHeaders: false,
            columns: [
                {
                    field: 'id',
                    key: 'id',
                    label: 'ID',
                    numeric: true,
                    searchable: false,
                    sortable: true,
                },
                {
                    field: 'report',
                    key: 'report',
                    label: 'Report',
                    numeric: false,
                    searchable: false,
                    sortable: true,
                },
                {
                    field: 'name',
                    key: 'name',
                    label: 'Name',
                    searchable: true,
                    sortable: true,
                },
                {
                    field: 'start_at',
                    key: 'start_at',
                    label: 'Start/End',
                    searchable: false,
                    sortable: true,
                    date: false,
                },
                {
                    field: 'result',
                    key: 'result',
                    label: 'Result',
                    searchable: true,
                    sortable: true,
                },
                {
                    field: 'state',
                    key: 'state',
                    label: 'State',
                    searchable: true,
                    sortable: true,
                },
                {
                    field: 'currentstep',
                    key: 'currentstep',
                    label: 'Current/Last Step',
                    searchable: false,
                    sortable: true,
                }
            ]
        };
    },
    methods: {
        showReportTreatment(reporttreatment) {
            window.location = reporttreatment.show_url
        },
        createReportTreatment() {
            ReportTreatmentBus.$emit('create_new_reporttreatment')
        },
        editReportTreatment(reporttreatment) {
            ReportTreatmentBus.$emit('edit_reporttreatment', { reporttreatment })
        },
        deleteReportTreatment(reporttreatment) {
            this.$swal({
                title: 'Êtes vous sûr ?',
                text: "Vous ne pourrez pas revenir en arrière!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Oui, supprimez le!'
            }).then((result) => {
                if(result.value) {

                    // eslint-disable-next-line no-undef
                    axios.delete(`/reporttreatments/${reporttreatment.uuid}`)
                        // eslint-disable-next-line no-unused-vars
                        .then(resp => {
                            this.removeReportTreatmentFromList(reporttreatment)
                        }).catch(error => {
                        window.handleErrors(error)
                    })

                }
            })
        },
        addReportTreatmentToList(reporttreatment) {
            let reporttreatmentIndex = this.reporttreatments.findIndex(c => {
                return reporttreatment.id === c.id
            })

            console.log("addReportTreatmentToList: ", reporttreatment, reporttreatmentIndex)

            // if this Account doesn't belong to the list
            if (reporttreatmentIndex === -1) {
                //J'ajoute dans la liste
                this.reporttreatments.push(reporttreatment)
                this.$emit('reporttreatment_added', reporttreatment)
                console.log("reporttreatment_added")
            }
        },
        updateReportTreatmentFromList(reporttreatment) {
            let stepIndex = this.reporttreatments.findIndex(s => {
                return reporttreatment.id === s.id
            })

            // if this Account belongs to the list
            if (stepIndex > -1) {
                this.reporttreatments.splice(stepIndex, 1, reporttreatment)
            }
        },
        removeReportTreatmentFromList(reporttreatment) {
            let reporttreatmentIndex = this.reporttreatments.findIndex(s => {
                return reporttreatment.id === s.id
            })

            // if this attribute belongs to the list
            if (reporttreatmentIndex > -1) {
                this.reporttreatments.splice(reporttreatmentIndex, 1)

                this.$swal({
                    html: '<small>Compte supprimé avec succès !</small>',
                    icon: 'success',
                    timer: 3000
                }).then(() => {

                })
            }
        },
    },
    computed: {
        // eslint-disable-next-line vue/return-in-computed-property
        transitionName() {
            if (this.useTransition) {
                return 'fade'
            }
        }
    }
}
</script>

<style scoped>

</style>
