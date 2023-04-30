<template>
    <section>
        <b-table
            :data="operationresults"
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
                            <a @click="showOperationResult(props.row)">
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
                                <a @click="editOperationResult(props.row)" class="tw-inline-block tw-mr-3 text-warning">
                                    <b-icon
                                        pack="fas"
                                        icon="pencil-square-o"
                                        size="is-small">
                                    </b-icon>
                                </a>
                                <a @click="deleteOperationResult(props.row)" class="tw-inline-block tw-mr-3 text-danger">
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

                <OperationResultItem :operationresult_prop="props.row"></OperationResultItem>

            </template>

            <template #empty>
                <div class="has-text-centered">No Data Available</div>
            </template>

        </b-table>

    </section>
</template>

<script>
import OperationResultBus from "../operationresults/operationresultBus";

export default {
    name: "operationresult-list",
    props: {
        operationresults_prop: {}
    },
    components: {
        OperationResultItem: () => import('../operationresults/item'),
    },
    mounted() {
        OperationResultBus.$on('operationresult_created', (operationresult) => {
            this.addOperationResultToList(operationresult)
        })

        OperationResultBus.$on('operationresult_updated', (operationresult) => {
            this.updateOperationResultFromList(operationresult)
        })
    },
    data() {
        return {
            operationresults: this.operationresults_prop,
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
        showOperationResult(operationresult) {
            window.location = operationresult.show_url
        },
        createOperationResult() {
            OperationResultBus.$emit('create_new_operationresult')
        },
        editOperationResult(operationresult) {
            OperationResultBus.$emit('edit_operationresult', { operationresult })
        },
        deleteOperationResult(operationresult) {
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
                    axios.delete(`/operationresults/${operationresult.uuid}`)
                        // eslint-disable-next-line no-unused-vars
                        .then(resp => {
                            this.removeOperationResultFromList(operationresult)
                        }).catch(error => {
                        window.handleErrors(error)
                    })

                }
            })
        },
        addOperationResultToList(operationresult) {
            let operationresultIndex = this.operationresults.findIndex(c => {
                return operationresult.id === c.id
            })

            console.log("addOperationResultToList: ", operationresult, operationresultIndex)

            // if this Account doesn't belong to the list
            if (operationresultIndex === -1) {
                //J'ajoute dans la liste
                this.operationresults.push(operationresult)
                this.$emit('operationresult_added', operationresult)
                console.log("operationresult_added")
            }
        },
        updateOperationResultFromList(operationresult) {
            let stepIndex = this.operationresults.findIndex(s => {
                return operationresult.id === s.id
            })

            // if this Account belongs to the list
            if (stepIndex > -1) {
                this.operationresults.splice(stepIndex, 1, operationresult)
            }
        },
        removeOperationResultFromList(operationresult) {
            let operationresultIndex = this.operationresults.findIndex(s => {
                return operationresult.id === s.id
            })

            // if this attribute belongs to the list
            if (operationresultIndex > -1) {
                this.operationresults.splice(operationresultIndex, 1)

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
