<template>
    <section>
        <p>
            <b-button size="is-small" type="is-info is-light" @click="createCollectedReportFile()">Ajouter</b-button>
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
            :data="collectedreportfiles"
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
                        <span v-else-if="column.field === 'local_file_name'" class="has-text-primary is-italic text-xs">
                            <a @click="showCollectedReportFile(props.row)">
                                {{ props.row[column.field] }}
                            </a>
                        </span>
                        <span v-else-if="column.field === 'reportfile'" class="has-text-info is-italic text-xs">
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
                                <a @click="editCollectedReportFile(props.row)" class="tw-inline-block tw-mr-3 text-warning">
                                    <b-icon
                                        pack="fas"
                                        icon="pencil-square-o"
                                        size="is-small">
                                    </b-icon>
                                </a>
                                <a @click="deleteCollectedReportFile(props.row)" class="tw-inline-block tw-mr-3 text-danger">
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

                <CollectedReportFileItem :collectedreportfile_prop="props.row"></CollectedReportFileItem>

            </template>

            <template #empty>
                <div class="has-text-centered">No Data Available</div>
            </template>

        </b-table>

        <AddUpdateCollectedReportFile></AddUpdateCollectedReportFile>
    </section>
</template>

<script>
import CollectedReportFileBus from "../collectedreportfiles/collectedreportfileBus";

export default {
    props: {
        collectedreportfiles_prop: {}
    },
    name: "collectedreportfiles-index",
    components: {
        AddUpdateCollectedReportFile: () => import('../collectedreportfiles/addupdate'),
        CollectedReportFileItem: () => import('../collectedreportfiles/item'),
    },
    mounted() {
        CollectedReportFileBus.$on('collectedreportfile_created', (collectedreportfile) => {
            if (this.report.id === collectedreportfile.report.id) {
                this.addReportFileToList(collectedreportfile)
            }
        })

        CollectedReportFileBus.$on('collectedreportfile_updated', (collectedreportfile) => {
            if (this.report.id === collectedreportfile.report.id) {
                this.updateCollectedReportFileFromList(collectedreportfile)
            }
        })
    },
    data() {
        return {
            report: this.report_prop,
            collectedreportfiles: this.collectedreportfiles_prop,
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
                    field: 'local_file_name',
                    key: 'local_file_name',
                    label: 'Local File Name',
                    searchable: true,
                    sortable: true,
                },
                {
                    field: 'reportfile',
                    key: 'reportfile',
                    label: 'Fichier Rapport',
                    searchable: false,
                    sortable: true,
                },
                {
                    field: 'file_size',
                    key: 'file_size',
                    label: 'Taille',
                    numeric: true,
                    searchable: false,
                    sortable: true,
                },
                {
                    field: 'nb_rows',
                    key: 'nb_rows',
                    label: 'Lignes',
                    numeric: true,
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
        showCollectedReportFile(collectedreportfile) {
            console.log("showCollectedReportFile: ",collectedreportfile.show_url)
            window.location = collectedreportfile.show_url
        },
        createCollectedReportFile() {
            let report = this.report
            CollectedReportFileBus.$emit('create_new_collectedreportfile', { report })
        },
        editCollectedReportFile(collectedreportfile) {
            CollectedReportFileBus.$emit('edit_collectedreportfile', { collectedreportfile })
        },
        deleteCollectedReportFile(collectedreportfile) {
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

                    axios.delete(`/collectedreportfiles/${collectedreportfile.uuid}`)
                        .then(resp => {
                            this.removeCollectedReportFileFromList(collectedreportfile)
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
        addCollectedReportFileToList(collectedreportfile) {
            let collectedreportfileIndex = this.collectedreportfiles.findIndex(c => {
                return collectedreportfile.id === c.id
            })

            // if this attribute doesn't exists in the list
            if (collectedreportfileIndex === -1) {

                //J'ajoute dans la liste
                this.collectedreportfiles.push(collectedreportfile)

                this.$emit('report_file_created', collectedreportfile)
            }
        },
        updateCollectedReportFileFromList(collectedreportfile) {
            let stepIndex = this.collectedreportfiles.findIndex(s => {
                return collectedreportfile.id === s.id
            })

            // if this attribute belongs to the list
            if (stepIndex > -1) {
                this.collectedreportfiles.splice(stepIndex, 1, collectedreportfile)
            }
        },
        removeCollectedReportFileFromList(collectedreportfile) {
            let collectedreportfileIndex = this.collectedreportfiles.findIndex(s => {
                return collectedreportfile.id === s.id
            })

            // if this attribute belongs to the list
            if (collectedreportfileIndex > -1) {
                this.collectedreportfiles.splice(collectedreportfileIndex, 1)

                this.$swal({
                    html: '<small>Fichier de rapport supprimé avec succès !</small>',
                    icon: 'success',
                    timer: 3000
                }).then(() => {

                })
            }
        }
    },
    computed: {
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
