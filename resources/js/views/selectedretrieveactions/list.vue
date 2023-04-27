<template>
    <section>
        <b-field>
            <template #label>
                <span class="has-text-black text-xs">Ajouter
                    <b-button type="is-info is-light" size="is-small" @click="toggleCreating(creating)">
                        <b-icon pack="fa" icon="plus" size="is-small"></b-icon>
                    </b-button>
                </span>
            </template>
        </b-field>
        <b-field v-if="creating">
            <b-field :type="selectedRetrieveActionForm.errors.has('retrieveaction') ? 'is-danger' : 'is-default'">
                <b-tooltip :active="selectedRetrieveActionForm.errors.has('retrieveaction')" :label="selectedRetrieveActionForm.errors.get('retrieveaction')"
                           position="is-bottom"
                           type="is-danger"
                           :animated="false">
                    <b-select size="is-small" placeholder="actions" name="retrieveaction" v-model="selectedRetrieveActionForm.retrieveaction" expanded>
                        <option
                            v-for="option in retrieveactions"
                            :value="option"
                            :key="option.id">
                            {{ option.name }}
                        </option>
                    </b-select>
                </b-tooltip>
            </b-field>
            <b-field :type="selectedRetrieveActionForm.errors.has('actionvalue_valuetype') ? 'is-danger' : 'is-default'">
                <b-tooltip :active="selectedRetrieveActionForm.errors.has('actionvalue_valuetype')" :label="selectedRetrieveActionForm.errors.get('actionvalue_valuetype')"
                           position="is-bottom"
                           type="is-danger"
                           :animated="false">
                    <b-select size="is-small" placeholder="Type de valeur" name="actionvalue_valuetype" v-model="selectedRetrieveActionForm.actionvalue_valuetype">
                        <option
                            v-for="option in valuetypeenums"
                            :value="option"
                            :key="option.value">
                            {{ option.name }}
                        </option>
                    </b-select>
                </b-tooltip>
            </b-field>
            <b-field :type="selectedRetrieveActionForm.errors.has('actionvalue_label') ? 'is-danger' : 'is-default'" expanded>
                <b-tooltip :active="selectedRetrieveActionForm.errors.has('actionvalue_label')" :label="selectedRetrieveActionForm.errors.get('actionvalue_label')"
                           position="is-bottom"
                           type="is-danger"
                           :animated="false">
                    <b-input size="is-small" placeholder="Libellé" name="actionvalue_label" v-model="selectedRetrieveActionForm.actionvalue_label" expanded></b-input>
                </b-tooltip>
            </b-field>

        <b-field :type="selectedRetrieveActionForm.errors.has('description') ? 'is-danger' : 'is-default'" expanded>
                <b-tooltip :active="selectedRetrieveActionForm.errors.has('description')" :label="selectedRetrieveActionForm.errors.get('description')"
                           position="is-bottom"
                           type="is-danger"
                           :animated="false">
                    <b-input size="is-small" placeholder="Description" name="description" v-model="selectedRetrieveActionForm.description" expanded></b-input>
                </b-tooltip>
            </b-field>
            <p class="control">
                <b-button size="is-small" type="is-success" :loading="loading" @click="createSelectedRetrieveAction()" label="Valider" />
            </p>
        </b-field>
        <hr>
        <div class="box">
            <SelectedRetrieveActionItem v-for="selectedretrieveaction in selectedretrieveactions" :key="selectedretrieveaction.uuid" :model_prop="selectedretrieveaction" v-on:selectedretrieveaction_deleted="removeSelectedRetrieveActionToList"></SelectedRetrieveActionItem>
        </div>
    </section>

</template>

<script>

    import SelectedRetrieveActionBus from "./selectedretrieveactionBus";

    // eslint-disable-next-line no-unused-vars
    class SelectedRetrieveAction {
        constructor(selectedretrieveaction) {
            this.actionvalue_valuetype = selectedretrieveaction.actionvalue_valuetype || ''
            this.actionvalue_label = selectedretrieveaction.actionvalue_label || ''
            this.description = selectedretrieveaction.description || ''
            this.retrieveaction = selectedretrieveaction.retrieveaction || ''
            this.selectedretrieveaction = selectedretrieveaction.selectedretrieveaction || ''

            this.model_id = selectedretrieveaction.model_id || ''
            this.model_type = selectedretrieveaction.model_type || ''
        }
    }

    export default {
        name: "list",
        props: {
            model_prop: {}
        },

        components: {
            SelectedRetrieveActionItem: () => import('../selectedretrieveactions/item'),
        },
        mounted() {
            SelectedRetrieveActionBus.$on('selectedretrieveaction_created', (selectedretrieveaction) => {
                console.log('selectedretrieveaction_created received from actionlist', selectedretrieveaction)
                if (this.attributeId === selectedretrieveaction.dynamic_attribute_id) {
                    this.addRuleToList(selectedretrieveaction)
                }
            })

            this.$on('selectedretrieveaction_deleted', ({selectedretrieveaction, index}) => {
                if (this.attributeId === selectedretrieveaction.dynamic_attribute_id) {
                    this.selectedretrieveactions.splice(index, 1)
                }
            })
        },
        created() {
            // eslint-disable-next-line no-undef
            axios.get('/retrieveactions.fetch')
                .then(({data}) => this.retrieveactions = data);
            // eslint-disable-next-line no-undef
            axios.get('/valuetypeenums.fetch')
                .then(({data}) => this.valuetypeenums = data);
        },
        data() {
            return {
                attributeId: this.attributeid_prop,
                selectedretrieveactions: this.model_prop.selectedretrieveactions,
                selectedRetrieveActionForm: this.getNewselectedRetrieveActionForm(),
                retrieveactions: [],
                valuetypeenums: [],

                creating: false,
                editing: false,
                loading: false
            };
        },
        methods: {
            getNewselectedRetrieveActionForm() {
                // eslint-disable-next-line no-undef
                return new Form(new SelectedRetrieveAction({
                    'model_type': this.model_prop.model_type,
                    'model_id': this.model_prop.id
                }))
            },
            resetFom() {
                this.selectedRetrieveActionForm = this.getNewselectedRetrieveActionForm()
            },
            toggleCreating(creating) {
                this.creating = !creating
            },

            createSelectedRetrieveAction() {
                this.loading = true

                this.selectedRetrieveActionForm
                    .post('/selectedretrieveactions')
                    .then(newselectedretrieveaction => {
                        this.loading = false
                        this.$swal({
                            html: '<small>Action créée avec succès! <br> Prière de compléter les valeurs.</small>',
                            icon: 'success',
                            timer: 3000
                        }).then(() => {
                            SelectedRetrieveActionBus.$emit('selectedretrieveaction_created', newselectedretrieveaction)
                            this.addSelectedRetrieveActionToList(newselectedretrieveaction)
                            this.resetFom()
                        })

                        // eslint-disable-next-line no-unused-vars
                    }).catch(error => {
                    this.loading = false
                });
            },
            addSelectedRetrieveActionToList(selectedretrieveaction) {
                let selectedretrieveactionIndex = this.selectedretrieveactions.findIndex(c => {
                    return selectedretrieveaction.id === c.id
                })
                // si cette action n'existe pas déjà, on l'insère dans la liste
                if (selectedretrieveactionIndex === -1) {
                    this.selectedretrieveactions.push(selectedretrieveaction)
                }
            },
            removeSelectedRetrieveActionToList($event) {
                let selectedretrieveactionIndex = this.selectedretrieveactions.findIndex(c => {
                    return $event.id === c.id
                })

                if (selectedretrieveactionIndex > -1) {
                    this.selectedretrieveactions.splice(selectedretrieveactionIndex, 1)

                    this.$swal({
                        html: '<small>Action supprimée avec succès !</small>',
                        icon: 'success',
                        timer: 3000
                    }).then(() => {

                    })
                }
            }
        }
    }
</script>

<style scoped>

</style>
