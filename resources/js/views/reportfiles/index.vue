<template>

    <section>
        <p>
            <b-button size="is-small" type="is-info is-light" @click="createReportFile()">Ajouter</b-button>
        </p>
        <b-field grouped group-multiline>
            <b-select v-model="perPage" :disabled="!isPaginated">
                <option value="5">5 per page</option>
                <option value="10">10 per page</option>
                <option value="15">15 per page</option>
                <option value="20">20 per page</option>
            </b-select>
        </b-field>
        <b-table
            :data="reportfiles"
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
                            <a @click="editReportFile(props.row)">
                                {{ props.row[column.field] }}
                            </a>
                        </span>
                        <span v-else-if="column.field === 'reportfiletype'" class="has-text-info is-italic text-xs">
                            <span v-if="props.row[column.field]">
                                {{ props.row[column.field].name }}
                            </span>
                            <span v-else></span>
                        </span>
                        <span v-else-if="column.date" class="tag is-success">
                            {{ new Date( props.row[column.field] ).toLocaleDateString() }}
                        </span>
                        <span v-else-if="column.field === 'actions'" class="text-xs">
                            <div class="block">
                                <a @click="editReportFile(props.row)" class="tw-inline-block tw-mr-3 text-warning">
                                    <b-icon
                                        pack="fas"
                                        icon="pencil-square-o"
                                        size="is-small">
                                    </b-icon>
                                </a>
                                <a @click="deleteReportFile(props.row)" class="tw-inline-block tw-mr-3 text-danger">
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

                <b-tabs size="is-small" type="is-boxed">
                    <b-tab-item>
                        <template #header>
                            <b-icon icon="information-outline"></b-icon>
                            <span> Infos </span>
                        </template>

                        <div class="card card-default">
                            <div class="card-body">
                                <dl>
                                    <dt class="text text-xs">Name</dt>
                                    <dd class="text text-xs">{{ props.row.name }}</dd>
                                    <dt class="text text-xs">Wildcard</dt>
                                    <dd class="text text-xs">{{ props.row.wildcard }}</dd>
                                    <dt class="text text-xs">Type de fichier</dt>
                                    <dd class="text text-xs">{{ props.row.reportfiletype.name }}</dd>
                                    <dt class="text text-xs">Created at</dt>
                                    <dd class="text text-xs">{{ props.row.created_at | formatDate}}</dd>
                                </dl>
                            </div>
                        </div>
                    </b-tab-item>
                    <b-tab-item>

                    </b-tab-item>
                </b-tabs>

            </template>

            <template #empty>
                <div class="has-text-centered">No Data Available</div>
            </template>

        </b-table>

        <AddUpdateReportFile></AddUpdateReportFile>
    </section>

</template>

<script>
import ReportFileBus from "../reportfiles/reportfileBus";

export default {
    props: {
        report_prop: {},
        reportfiles_prop: {}
    },
    name: "report-files",
    components: {
        AddUpdateReportFile: () => import('../reportfiles/addupdate'),
    },
    mounted() {
        ReportFileBus.$on('reportfile_created', (reportfile) => {
            if (this.report.id === reportfile.report.id) {
                this.addReportFileToList(reportfile)
            }
        })

        ReportFileBus.$on('reportfile_updated', (reportfile) => {
            if (this.report.id === reportfile.report.id) {
                this.updateReportFileFromList(reportfile)
            }
        })
    },
    data() {
        return {
            report: this.report_prop,
            reportfiles: this.reportfiles_prop,
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
                    label: 'Nom',
                    searchable: true,
                    sortable: true,
                },
                {
                    field: 'reportfiletype',
                    key: 'reportfiletype',
                    label: 'Type',
                    searchable: false,
                    sortable: true,
                },
                {
                    field: 'description',
                    key: 'description',
                    label: 'Description',
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
        createReportFile() {
            let report = this.report
            ReportFileBus.$emit('create_new_reportfile', { report })
        },
        editReportFile(attribute) {
            ReportFileBus.$emit('edit_reportfile', { attribute })
        },
        deleteReportFile(attribute) {
            this.$swal({
                title: 'Êtes vous sûr ?',
                text: "Vous ne pourrez pas revenir en arrière!",
                icon: 'Attention',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Oui, supprimez le!'
            }).then((result) => {
                if(result.value) {

                    axios.delete(`/reportfiles/${attribute.uuid}`)
                        .then(resp => {
                            this.removeReportFileFromList(attribute)
                        }).catch(error => {
                        window.handleErrors(error)
                    })

                }
            })
        },
        removeAt(idx) {
            this.list.splice(idx, 1);
        },
        add: function() {
            id++;
            this.list.push({ name: "Juan " + id, id, text: "" });
        },
        addReportFileToList(reportfile) {
            let reportfileIndex = this.reportfiles.findIndex(c => {
                return reportfile.id === c.id
            })

            // if this attribute doesn't exists in the list
            if (reportfileIndex === -1) {

                //J'ajoute dans la liste
                this.reportfiles.push(reportfile)

                this.$emit('report_file_created', reportfile)
            }
        },
        updateReportFileFromList(reportfile) {
            let stepIndex = this.reportfiles.findIndex(s => {
                return reportfile.id === s.id
            })

            // if this attribute belongs to the list
            if (stepIndex > -1) {
                this.reportfiles.splice(stepIndex, 1, reportfile)
            }
        },
        removeReportFileFromList(reportfile) {
            let reportfileIndex = this.reportfiles.findIndex(s => {
                return reportfile.id === s.id
            })

            // if this attribute belongs to the list
            if (reportfileIndex > -1) {
                this.reportfiles.splice(reportfileIndex, 1)

                this.$swal({
                    html: '<small>Fichier de rapport supprimé avec succès !</small>',
                    icon: 'success',
                    timer: 3000
                }).then(() => {

                })
            }
        },
        columnTdAttrs(row, column) {
            if (row.id === 'Total') {
                if (column.label === 'ID') {
                    return {
                        colspan: 4,
                        class: 'has-text-weight-bold',
                        style: {
                            'text-align': 'left !important'
                        }
                    }
                } else if (column.label === 'Gender') {
                    return {
                        class: 'has-text-weight-semibold'
                    }
                } else {
                    return {
                        style: {display: 'none'}
                    }
                }
            }
            return null
        }
    },
    computed: {
        transitionName() {
            if (this.useTransition) {
                return 'fade'
            }
        }
    }
};
</script>
<style scoped>
dt {
    float: left;
    clear: left;
    width: 110px;
    font-weight: bold;
}

dt::after {
    content: ":";
}

dd {
    margin: 0 0 0 80px;
    padding: 0 0 0.5em 0;
}
</style>
