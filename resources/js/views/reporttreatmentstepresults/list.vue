<template>
    <section>
        <b-field grouped group-multiline>
            <b-select v-model="perPage" :disabled="!isPaginated">
                <option value="5">5 per page</option>
                <option value="10">10 per page</option>
                <option value="15">15 per page</option>
                <option value="20">20 per page</option>
            </b-select>
        </b-field>
        <b-table
            :data="reporttreatmentstepresults"
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
                            <a @click="showReportTreatmentStepResult(props.row)">
                                {{ props.row[column.field] }}
                            </a>
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
                        <span v-else-if="column.date" class="tag is-info is-light">
                            {{ props.row[column.field] | formatDate }}
                        </span>
                        <span v-else-if="column.field === 'actions'" class="text-xs">
                            <div class="block">
                                <a @click="editReportTreatmentStepResult(props.row)" class="tw-inline-block tw-mr-3 text-warning">
                                    <b-icon
                                        pack="fas"
                                        icon="pencil-square-o"
                                        size="is-small">
                                    </b-icon>
                                </a>
                                <a @click="deleteReportTreatmentStepResult(props.row)" class="tw-inline-block tw-mr-3 text-danger">
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

                <ReportTreatmentStepResultItem :reporttreatmentstepresult_prop="props.row"></ReportTreatmentStepResultItem>

            </template>

            <template #empty>
                <div class="has-text-centered">No Data Available</div>
            </template>

        </b-table>

    </section>
</template>

<script>
import ReportTreatmentStepResultBus from "../reporttreatmentstepresults/reporttreatmentstepresultBus";

export default {
    name: "reporttreatmentstepresult-list",
    props: {
        reporttreatmentstepresults_prop: {}
    },
    components: {
        ReportTreatmentStepResultItem: () => import('../reporttreatmentstepresults/item'),
    },
    mounted() {
        ReportTreatmentStepResultBus.$on('reporttreatmentstepresult_created', (reporttreatmentstepresult) => {
            this.addReportTreatmentStepResultToList(reporttreatmentstepresult)
        })

        ReportTreatmentStepResultBus.$on('reporttreatmentstepresult_updated', (reporttreatmentstepresult) => {
            this.updateReportTreatmentStepResultFromList(reporttreatmentstepresult)
        })
    },
    data() {
        return {
            reporttreatmentstepresults: this.reporttreatmentstepresults_prop,
            isPaginated: true,
            isPaginationSimple: false,
            isPaginationRounded: true,
            paginationPosition: 'bottom',
            defaultSortDirection: 'asc',
            sortIcon: 'arrow-up',
            sortIconSize: 'is-small',
            currentPage: 1,
            perPage: 5,
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
                    field: 'name',
                    key: 'name',
                    label: 'Name',
                    searchable: true,
                    sortable: true,
                },
                {
                    field: 'start_at',
                    key: 'start_at',
                    label: 'Start at',
                    searchable: false,
                    sortable: true,
                    date: true,
                },
                {
                    field: 'end_at',
                    key: 'end_at',
                    label: 'End at',
                    searchable: false,
                    sortable: true,
                    date: true,
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
                    field: 'actions',
                    key: 'actions',
                    label: '',
                    width: '100',
                    centered: true,
                    sortable: false,
                }
            ]
        };
    },
    methods: {
        showReportTreatmentStepResult(reporttreatmentstepresult) {
            window.location = reporttreatmentstepresult.show_url
        },
        createReportTreatmentStepResult() {
            ReportTreatmentStepResultBus.$emit('create_new_reporttreatmentstepresult')
        },
        editReportTreatmentStepResult(reporttreatmentstepresult) {
            ReportTreatmentStepResultBus.$emit('edit_reporttreatmentstepresult', { reporttreatmentstepresult })
        },
        deleteReportTreatmentStepResult(reporttreatmentstepresult) {
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
                    axios.delete(`/reporttreatmentstepresults/${reporttreatmentstepresult.uuid}`)
                        // eslint-disable-next-line no-unused-vars
                        .then(resp => {
                            this.removeReportTreatmentStepResultFromList(reporttreatmentstepresult)
                        }).catch(error => {
                        window.handleErrors(error)
                    })

                }
            })
        },
        addReportTreatmentStepResultToList(reporttreatmentstepresult) {
            let reporttreatmentstepresultIndex = this.reporttreatmentstepresults.findIndex(c => {
                return reporttreatmentstepresult.id === c.id
            })

            console.log("addReportTreatmentStepResultToList: ", reporttreatmentstepresult, reporttreatmentstepresultIndex)

            // if this Account doesn't belong to the list
            if (reporttreatmentstepresultIndex === -1) {
                //J'ajoute dans la liste
                this.reporttreatmentstepresults.push(reporttreatmentstepresult)
                this.$emit('reporttreatmentstepresult_added', reporttreatmentstepresult)
                console.log("reporttreatmentstepresult_added")
            }
        },
        updateReportTreatmentStepResultFromList(reporttreatmentstepresult) {
            let stepIndex = this.reporttreatmentstepresults.findIndex(s => {
                return reporttreatmentstepresult.id === s.id
            })

            // if this Account belongs to the list
            if (stepIndex > -1) {
                this.reporttreatmentstepresults.splice(stepIndex, 1, reporttreatmentstepresult)
            }
        },
        removeReportTreatmentStepResultFromList(reporttreatmentstepresult) {
            let reporttreatmentstepresultIndex = this.reporttreatmentstepresults.findIndex(s => {
                return reporttreatmentstepresult.id === s.id
            })

            // if this attribute belongs to the list
            if (reporttreatmentstepresultIndex > -1) {
                this.reporttreatmentstepresults.splice(reporttreatmentstepresultIndex, 1)

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
