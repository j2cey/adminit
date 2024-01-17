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
            :data="treatments"
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
                            <a @click="showTreatment(props.row)">
                                {{ props.row[column.field] }}
                            </a>
                        </span>
                        <span v-else-if="column.field === 'reportfile'" class="has-text-info is-italic text-xs">
                            <span v-if="props.row[column.field]">
                                <b-tag type="is-default is-light">{{ props.row[column.field].report.title }} / {{ props.row[column.field].name }}</b-tag>
                            </span>
                            <span v-else></span>
                        </span>
                        <span v-else-if="column.field === 'state'" class="has-text-info is-italic text-xs">
                            <span v-if="props.row[column.field]">
                                <b-tag rounded v-if="props.row[column.field] === 'completed'" type="is-success">{{ props.row[column.field] }}</b-tag>
                                <b-tag rounded v-else-if="props.row[column.field] === 'running'" type="is-danger">{{ props.row[column.field] }}</b-tag>
                                <b-tag rounded v-else-if="props.row[column.field] === 'queued'" type="is-warning">{{ props.row[column.field] }}</b-tag>
                                <b-tag rounded v-else type="is-default">{{ props.row[column.field] }}</b-tag>
                                 /
                                <b-tag rounded v-if="props.row['result'] === 'success'" type="is-success">{{ props.row['result'] }}</b-tag>
                                <b-tag rounded v-else-if="props.row['result'] === 'failed'" type="is-danger">{{ props.row['result'] }}</b-tag>
                                <b-tag rounded v-else type="is-default">{{ props.row['result'] }}</b-tag>
                            </span>
                            <span v-else></span>
                        </span>
                        <span v-else-if="column.field === 'progression'" class="has-text-info is-italic text-xs">
                            <span v-if="props.row[column.field]">
                                <b-tag v-if="props.row[column.field].rate >= 100" type="is-success" size="is-small">{{ roundedNum(props.row[column.field].rate) + '%' }}</b-tag>
                                <b-tag v-else-if="props.row[column.field].rate <= 50" type="is-danger" size="is-small">{{ roundedNum(props.row[column.field].rate) + '%' }}</b-tag>
                                <b-tag v-else type="is-warning" size="is-small">{{ roundedNum(props.row[column.field].rate) + '%' }}</b-tag>
                                /
                                <span class="tag is-info is-light">
                                    {{ props.row[column.field].current_step }}
                                </span>
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
                                <a @click="editTreatment(props.row)" class="tw-inline-block tw-mr-3 text-warning">
                                    <b-icon
                                        pack="fas"
                                        icon="pencil-square-o"
                                        size="is-small">
                                    </b-icon>
                                </a>
                                <a @click="deleteTreatment(props.row)" class="tw-inline-block tw-mr-3 text-danger">
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

                <TreatmentItem :treatment_prop="props.row"></TreatmentItem>

            </template>

            <template #empty>
                <div class="has-text-centered">No Data Available</div>
            </template>

        </b-table>

    </section>
</template>

<script>

import TreatmentBus from "./treatmentBus";

export default {
    name: "treatment-list",
    props: {
        treatments_prop: {},
    },
    components: {
        TreatmentItem: () => import('./item'),
    },
    mounted() {
        TreatmentBus.$on('treatment_created', (treatment) => {
            this.addTreatmentToList(treatment)
        })

        TreatmentBus.$on('treatment_updated', (treatment) => {
            this.updateTreatmentFromList(treatment)
        })
    },
    data() {
        return {
            treatments: this.treatments_prop,

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
                    field: 'reportfile',
                    key: 'reportfile',
                    label: 'Report / File',
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
                    field: 'state',
                    key: 'state',
                    label: 'State/Result',
                    searchable: false,
                    sortable: true,
                },
                {
                    field: 'progression',
                    key: 'progression',
                    label: 'Progression',
                    searchable: false,
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
        showTreatment(treatment) {
            window.location = treatment.show_url
        },
        createTreatment() {
            TreatmentBus.$emit('create_new_treatment')
        },
        editTreatment(treatment) {
            TreatmentBus.$emit('edit_treatment', { treatment })
        },
        deleteTreatment(treatment) {
            this.$swal({
                title: 'Supprimer ce Traitement ?',
                text: "Vous ne pourrez pas revenir en arrière!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Oui, supprimez le!'
            }).then((result) => {
                if(result.value) {

                    // eslint-disable-next-line no-undef
                    axios.delete(`/treatments/${treatment.uuid}`)
                        // eslint-disable-next-line no-unused-vars
                        .then(resp => {
                            this.removeTreatmentFromList(treatment)
                        }).catch(error => {
                        window.handleErrors(error)
                    })

                }
            })
        },
        addTreatmentToList(treatment) {
            let treatmentIndex = this.treatments.findIndex(c => {
                return treatment.id === c.id
            })

            console.log("addTreatmentToList: ", treatment, treatmentIndex)

            // if this Account doesn't belong to the list
            if (treatmentIndex === -1) {
                //J'ajoute dans la liste
                this.treatments.push(treatment)
                this.$emit('treatment_added', treatment)
                console.log("treatment_added")
            }
        },
        updateTreatmentFromList(treatment) {
            let stepIndex = this.treatments.findIndex(s => {
                return treatment.id === s.id
            })

            // if this Account belongs to the list
            if (stepIndex > -1) {
                this.treatments.splice(stepIndex, 1, treatment)
            }
        },
        removeTreatmentFromList(treatment) {
            let treatmentIndex = this.treatments.findIndex(s => {
                return treatment.id === s.id
            })

            // if this attribute belongs to the list
            if (treatmentIndex > -1) {
                this.treatments.splice(treatmentIndex, 1)

                this.$swal({
                    html: '<small>Traitement supprimé avec succès !</small>',
                    icon: 'success',
                    timer: 3000
                }).then(() => {

                })
            }
        },
        roundedNum(numb) {
            return Math.floor(numb);
        }
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
