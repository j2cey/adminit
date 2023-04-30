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
            :data="reporttreatmentresults"
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
                            <a @click="showReportTreatmentResult(props.row)">
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
                                <a @click="editReportTreatmentResult(props.row)" class="tw-inline-block tw-mr-3 text-warning">
                                    <b-icon
                                        pack="fas"
                                        icon="pencil-square-o"
                                        size="is-small">
                                    </b-icon>
                                </a>
                                <a @click="deleteReportTreatmentResult(props.row)" class="tw-inline-block tw-mr-3 text-danger">
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

                <ReportTreatmentResultItem :reporttreatmentresult_prop="props.row"></ReportTreatmentResultItem>

            </template>

            <template #empty>
                <div class="has-text-centered">No Data Available</div>
            </template>

        </b-table>

    </section>
</template>

<script>

import ReportTreatmentResultBus from "../reporttreatmentresults/reporttreatmentresultBus";

export default {
    name: "reporttreatmentresult-list",
    props: {
        reporttreatmentresults_prop: {}
    },
    components: {
        ReportTreatmentResultItem: () => import('../reporttreatmentresults/item'),
    },
    mounted() {
        ReportTreatmentResultBus.$on('reporttreatmentresult_created', (reporttreatmentresult) => {
            this.addReportTreatmentResultToList(reporttreatmentresult)
        })

        ReportTreatmentResultBus.$on('reporttreatmentresult_updated', (reporttreatmentresult) => {
            this.updateReportTreatmentResultFromList(reporttreatmentresult)
        })
    },
    data() {
        return {
            reporttreatmentresults: this.reporttreatmentresults_prop,
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
        showReportTreatmentResult(reporttreatmentresult) {
            window.location = reporttreatmentresult.show_url
        },
        createReportTreatmentResult() {
            ReportTreatmentResultBus.$emit('create_new_reporttreatmentresult')
        },
        editReportTreatmentResult(reporttreatmentresult) {
            ReportTreatmentResultBus.$emit('edit_reporttreatmentresult', { reporttreatmentresult })
        },
        deleteReportTreatmentResult(reporttreatmentresult) {
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
                    axios.delete(`/reporttreatmentresults/${reporttreatmentresult.uuid}`)
                        // eslint-disable-next-line no-unused-vars
                        .then(resp => {
                            this.removeReportTreatmentResultFromList(reporttreatmentresult)
                        }).catch(error => {
                        window.handleErrors(error)
                    })

                }
            })
        },
        addReportTreatmentResultToList(reporttreatmentresult) {
            let reporttreatmentresultIndex = this.reporttreatmentresults.findIndex(c => {
                return reporttreatmentresult.id === c.id
            })

            console.log("addReportTreatmentResultToList: ", reporttreatmentresult, reporttreatmentresultIndex)

            // if this Account doesn't belong to the list
            if (reporttreatmentresultIndex === -1) {
                //J'ajoute dans la liste
                this.reporttreatmentresults.push(reporttreatmentresult)
                this.$emit('reporttreatmentresult_added', reporttreatmentresult)
                console.log("reporttreatmentresult_added")
            }
        },
        updateReportTreatmentResultFromList(reporttreatmentresult) {
            let stepIndex = this.reporttreatmentresults.findIndex(s => {
                return reporttreatmentresult.id === s.id
            })

            // if this Account belongs to the list
            if (stepIndex > -1) {
                this.reporttreatmentresults.splice(stepIndex, 1, reporttreatmentresult)
            }
        },
        removeReportTreatmentResultFromList(reporttreatmentresult) {
            let reporttreatmentresultIndex = this.reporttreatmentresults.findIndex(s => {
                return reporttreatmentresult.id === s.id
            })

            // if this attribute belongs to the list
            if (reporttreatmentresultIndex > -1) {
                this.reporttreatmentresults.splice(reporttreatmentresultIndex, 1)

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
