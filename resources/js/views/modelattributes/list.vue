<template>

    <section>
        <p>
            <span class="help-inline pr-1 text-sm"> Attributes (Fields). </span>
            <b-button size="is-small" type="is-info is-light" @click="createAttribute(currmodel)"><i class="fas fa-plus"></i></b-button>
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
            :data="modelattributes"
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
                            <a @click="showAttribute(props.row)">
                                {{ props.row[column.field] }}
                            </a>
                        </span>
                        <span v-else-if="column.field === 'attributetype'" class="has-text-info is-italic text-xs">
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
                                <a @click="editAttribute(props.row)" class="tw-inline-block tw-mr-3 text-warning">
                                    <b-icon
                                        pack="fas"
                                        icon="pencil-square-o"
                                        size="is-small">
                                    </b-icon>
                                </a>
                                <a @click="deleteAttribute(props.row)" class="tw-inline-block tw-mr-3 text-danger">
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

                <DynamicAttributeTtem :model_prop="currmodel" :dynamicattribute_prop="props.row"></DynamicAttributeTtem>

            </template>

            <template #empty>
                <div class="has-text-centered">No Data Available</div>
            </template>

        </b-table>

        <AddUpdateAttribute></AddUpdateAttribute>
        <AddUpdateAnalysisRule></AddUpdateAnalysisRule>
    </section>

</template>

<script>
    import DynamicAttributeBus from "../dynamicattributes/attributeBus";
    import AnalysisRuleBus from "../analysisrules/analysisruleBus";

    export default {
        props: {
            currmodel_prop: {},
            modelattributes_prop: {}
        },
        name: "model-attributes-list",
        components: {
            DynamicAttributeTtem: () => import('../dynamicattributes/item'),
            AddUpdateAttribute: () => import('../dynamicattributes/addupdate'),
            AddUpdateAnalysisRule: () => import('../analysisrules/addupdate'),
        },
        mounted() {
            DynamicAttributeBus.$on('dynamicattribute_created', (dynamicattribute) => {
                if (this.currmodel.model_type === dynamicattribute.hasdynamicattribute_type && this.currmodel.id === dynamicattribute.hasdynamicattribute_id) {
                    this.addAttributeToList(dynamicattribute)
                }
            })

            DynamicAttributeBus.$on('dynamicattribute_updated', (dynamicattribute) => {
                if (this.currmodel.model_type === dynamicattribute.hasdynamicattribute_type && this.currmodel.id === dynamicattribute.hasdynamicattribute_id) {
                    this.updateAttributeFromList(dynamicattribute)
                }
            })

            AnalysisRuleBus.$on('analysisrule_created', (attribute) => {
                if (this.currmodel.model_type === attribute.hasdynamicattribute_type && this.currmodel.id === attribute.hasdynamicattribute_id) {
                    this.updateAttributeFromList(attribute)
                }
            })
        },
        data() {
            return {
                currmodel: this.currmodel_prop,
                modelattributes: this.modelattributes_prop,
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
                    },{
                        field: 'num_ord',
                        key: 'num_ord',
                        label: 'Num. Ord',
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
                        field: 'attributetype',
                        key: 'attributetype',
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
            createAttribute(model) {
                let model_type = model.model_type
                let model_id = model.id
                DynamicAttributeBus.$emit('create_new_dynamicattribute', { model_type, model_id })
            },
            editAttribute(attribute) {
                DynamicAttributeBus.$emit('edit_dynamicattribute', { attribute })
            },
            showAttribute(attribute) {
                window.location = `/dynamicattributes/${attribute.uuid}`
            },
            deleteAttribute(attribute) {
                this.$swal({
                    title: 'Êtes vous sûr ?',
                    text: "Vous ne pourrez pas revenir en arrière!",
                    icon: 'Attention',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Oui, supprimez le!!'
                }).then((result) => {
                    if(result.value) {

                        axios.delete(`/dynamicattributes/${attribute.uuid}`)
                            .then(resp => {
                                this.removeAttributeFromList(attribute)
                            }).catch(error => {
                            window.handleErrors(error)
                        })

                    }
                })
            },
            createAnalysisRule(attribute) {
                console.log('create_new_analysisrule sent: ', attribute)
                AnalysisRuleBus.$emit('create_new_analysisrule', { attribute })
            },
            searchTitre(row, input) {
                console.log('Searching Name ...', row, input)
                return input && row.name && row.name.includes(input);
            },
            searchDescription(row, input) {
                console.log('Searching Description ...', row, input)
                return input && row.description && row.description.includes(input);
            },
            searchDefault(row, input) {
                console.log('Searching Default ...', row, input)
                return true;
            },
            createNewAction(modelattribute) {
                axios.get(`/modelactions.fetchbystep/${modelattribute.id}`)
                    .then((resp => {
                        DynamicAttributeBus.$emit('modelaction_create', modelattribute, resp.data);
                    }));
            },
            removeAt(idx) {
                this.list.splice(idx, 1);
            },
            add: function() {
                id++;
                this.list.push({ name: "Juan " + id, id, text: "" });
            },
            addAttributeToList(modelattribute) {
                let modelattributeIndex = this.modelattributes.findIndex(c => {
                    return modelattribute.id === c.id
                })

                // if this attribute doesn't exists in the list
                if (modelattributeIndex === -1) {
                    this.modelattributes.push(modelattribute)
                }
            },
            updateAttributeFromList(modelattribute) {
                let stepIndex = this.modelattributes.findIndex(s => {
                    return modelattribute.id === s.id
                })

                // if this attribute belongs to the list
                if (stepIndex > -1) {
                    this.modelattributes.splice(stepIndex, 1, modelattribute)
                }
            },
            removeAttributeFromList(modelattribute) {
                let attributeIndex = this.modelattributes.findIndex(s => {
                    return modelattribute.id === s.id
                })

                // if this attribute belongs to the list
                if (attributeIndex > -1) {
                    this.modelattributes.splice(attributeIndex, 1)

                    this.$swal({
                        html: '<small>Attribute supprimé avec succès !</small>',
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
