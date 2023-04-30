<template>
    <section>
        <p>
            <b-button size="is-small" type="is-info is-light" @click="createAccessAccount()">Ajouter</b-button>
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
            :data="accessaccounts"
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
                            <a @click="editAccessAccount(props.row)">
                                {{ props.row[column.field] }}
                            </a>
                        </span>
                        <span v-else-if="column.field === 'status'" class="has-text-info is-italic text-xs">
                            <span v-if="props.row[column.field]">
                                <b-tag v-if="props.row[column.field].code === 'active'" type="is-success is-light">{{ props.row[column.field].name }}</b-tag>
                                <b-tag v-else type="is-danger is-light">{{ props.row[column.field].name }}</b-tag>
                            </span>
                            <span v-else></span>
                        </span>
                        <span v-else-if="column.date" class="tag is-success">
                            {{ new Date( props.row[column.field] ).toLocaleDateString() }}
                        </span>
                        <span v-else-if="column.field === 'actions'" class="text-xs">
                            <div class="block">
                                <a @click="editAccessAccount(props.row)" class="tw-inline-block tw-mr-3 text-warning">
                                    <b-icon
                                        pack="fas"
                                        icon="pencil-square-o"
                                        size="is-small">
                                    </b-icon>
                                </a>
                                <a @click="deleteAccessAccount(props.row)" class="tw-inline-block tw-mr-3 text-danger">
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

                <AccessAccountItem :accessaccount_prop="props.row"></AccessAccountItem>

            </template>

            <template #empty>
                <div class="has-text-centered">No Data Available</div>
            </template>

        </b-table>

        <AddUpdateAccessAccount></AddUpdateAccessAccount>
    </section>

</template>

<script>
import AccessAccountBus from "../accessaccounts/accessaccountBus";
import AddUpdateAccessAccount from "../accessaccounts/addupdate";

export default {
    props: {
        accessaccounts_prop: {}
    },
    name: "access-account-list",
    components: {
        AddUpdateAccessAccount,
        AccessAccountItem: () => import('../accessaccounts/item'),
    },
    mounted() {
        AccessAccountBus.$on('accessaccount_created', (accessaccount) => {
            this.addAccessAccountToList(accessaccount)
        })

        AccessAccountBus.$on('accessaccount_updated', (accessaccount) => {
            this.updateAccessAccountFromList(accessaccount)
        })
    },
    data() {
        return {
            accessaccounts: this.accessaccounts_prop,
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
                    field: 'username',
                    key: 'username',
                    label: 'Username',
                    searchable: true,
                    sortable: true,
                },
                {
                    field: 'login',
                    key: 'login',
                    label: 'Login',
                    searchable: true,
                    sortable: true,
                },
                {
                    field: 'email',
                    key: 'email',
                    label: 'Email',
                    searchable: true,
                    sortable: true,
                },
                {
                    field: 'status',
                    key: 'status',
                    label: 'Statut',
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
        createAccessAccount() {
            AccessAccountBus.$emit('create_new_accessaccount')
        },
        editAccessAccount(accessaccount) {
            AccessAccountBus.$emit('edit_accessaccount', { accessaccount })
        },
        deleteAccessAccount(accessaccount) {
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
                    axios.delete(`/accessaccounts/${accessaccount.uuid}`)
                        // eslint-disable-next-line no-unused-vars
                        .then(resp => {
                            this.removeAccessAccountFromList(accessaccount)
                        }).catch(error => {
                        window.handleErrors(error)
                    })

                }
            })
        },
        addAccessAccountToList(accessaccount) {
            let accessaccountIndex = this.accessaccounts.findIndex(c => {
                return accessaccount.id === c.id
            })

            console.log("addAccessAccountToList: ", accessaccount, accessaccountIndex)

            // if this Account doesn't belong to the list
            if (accessaccountIndex === -1) {
                //J'ajoute dans la liste
                this.accessaccounts.push(accessaccount)
                this.$emit('accessaccount_added', accessaccount)
                console.log("accessaccount_added")
            }
        },
        updateAccessAccountFromList(accessaccount) {
            let stepIndex = this.accessaccounts.findIndex(s => {
                return accessaccount.id === s.id
            })

            // if this Account belongs to the list
            if (stepIndex > -1) {
                this.accessaccounts.splice(stepIndex, 1, accessaccount)
            }
        },
        removeAccessAccountFromList(accessaccount) {
            let accessaccountIndex = this.accessaccounts.findIndex(s => {
                return accessaccount.id === s.id
            })

            // if this attribute belongs to the list
            if (accessaccountIndex > -1) {
                this.accessaccounts.splice(accessaccountIndex, 1)

                this.$swal({
                    html: '<small>Compte supprimé avec succès !</small>',
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
