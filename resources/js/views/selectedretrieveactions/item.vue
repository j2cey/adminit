<template>
    <section>
        <b-tabs>

            <b-field size="is-small" horizontal>

                    <template #label>
                        <span class="text text-xs text-orange">{{ selectedretrieveaction.retrieveaction.name }}</span>
                    </template>

                        <b-field size="is-small" :type="selectedRetrieveActionForm.errors.has('description') ? 'is-danger' : 'is-default'">
                            <b-input size="is-small" v-model="selectedRetrieveActionForm.description" name="description" :loading="loading" placeholder="Description" :readonly="!editing"></b-input>
                        </b-field>


                        <b-field size="is-small" class="text-xs" horizontal>
                            <a @click="editselectedRetrieveAction(selectedretrieveaction)" v-if="!editing" class="tw-inline-block tw-mr-3 text-warning">
                                <b-icon
                                    pack="fas"
                                    icon="pencil-square-o"
                                    size="is-small">
                                </b-icon>
                            </a>
                            <a @click="updateselectedRetrieveAction(selectedretrieveaction)" v-if="editing" class="tw-inline-block tw-mr-3 text-success">
                                <b-icon
                                    pack="fas"
                                    icon="check"
                                    size="is-small">
                                </b-icon>
                            </a>
                            <a @click="cancelEditselectedRetrieveAction(selectedretrieveaction)" v-if="editing" class="tw-inline-block tw-mr-3 text-info">
                                <b-icon
                                    pack="fas"
                                    icon="ban"
                                    size="is-small">
                                </b-icon>
                            </a>
                            <a @click="deleteselectedRetrieveAction(selectedretrieveaction)" class="tw-inline-block tw-mr-3 text-danger">
                                <b-icon
                                    pack="fas"
                                    icon="trash"
                                    size="is-small">
                                </b-icon>
                            </a>
                        </b-field>
                    </b-field>

        </b-tabs>
    </section>
</template>

<script>
import selectedRetrieveActionBus from "./selectedretrieveactionBus";
import {resumeTimer, stopTimer} from "sweetalert2";

class selectedRetrieveAction {
    constructor(selectedretrieveaction) {
        this.actionvalue_valuetype = selectedretrieveaction.actionvalue_valuetype || ''
        this.actionvalue_label = selectedretrieveaction.actionvalue_label || ''
        this.description = selectedretrieveaction.description || ''
        this.selectedretrieveaction = selectedretrieveaction.selectedretrieveaction || ''
        this.retrieveaction = selectedretrieveaction.retrieveaction || ''
    }
}

export default {
    name: "selectedretrieveaction-item",
    props: {
        model_prop: {}
    },
    components: {


    },
    created(){
        // eslint-disable-next-line no-undef
        axios.get('/retrieveaction.fetch')
            .then(({data}) => this.retrieveactions = data);
    },
    data() {
        return {
            selectedretrieveaction: this.model_prop,

            // eslint-disable-next-line no-undef
            selectedRetrieveActionForm: new Form(new selectedRetrieveAction(this.model_prop)),
            retrieveactions: [],
            valuetypeenums: [],

            editing: false,
            loading: false
        }
    },

    methods: {

        editselectedRetrieveAction(selectedretrieveaction) {
            this.editing = true
            selectedRetrieveActionBus.$emit('selectedretrieveaction_edit', selectedretrieveaction)
        },
        cancelEditselectedRetrieveAction(selectedretrieveaction) {
            this.editing = false
            this.loading = false

            this.setselectedRetrieveActionAndForm(this.selectedretrieveaction)

            selectedRetrieveActionBus.$emit('selectedretrieveaction_edit_cancel', selectedretrieveaction)
        },
        setselectedRetrieveActionAndForm(selectedretrieveaction, canceledit = false) {
            this.selectedretrieveaction = selectedretrieveaction
            // eslint-disable-next-line no-undef
            this.selectedRetrieveActionForm = new Form(new selectedRetrieveAction(selectedretrieveaction))
            if (canceledit) {
                this.cancelEditselectedRetrieveAction(selectedretrieveaction)
            }
        },
        updateselectedRetrieveAction(selectedretrieveaction) {
            this.loading = true
            selectedRetrieveActionBus.$emit('selectedretrieveaction_updating', selectedretrieveaction)
            this.selectedRetrieveActionForm.innerselectedretrieveaction = this.innerselectedretrieveaction

            this.selectedRetrieveActionForm
                .put(`/selectedretrieveactions/${this.selectedretrieveaction.uuid}`,undefined)
                .then(newselectedretrieveaction => {
                    this.loading = false

                    /**/

                    this.$swal({
                        html: '<small>Action modifiée avec succès !</small>',
                        icon: 'success',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        onOpen: (toast) => {
                            toast.addEventListener('mouseenter', stopTimer)
                            toast.addEventListener('mouseleave', resumeTimer)
                        }
                    }).then(() => {
                        this.loading = false
                        this.setselectedRetrieveActionAndForm(newselectedretrieveaction, true)
                        selectedRetrieveActionBus.$emit('selectedretrieveaction_updated', newselectedretrieveaction)
                    })

                    // eslint-disable-next-line no-unused-vars
                }).catch(error => {
                this.loading = false
                this.cancelEditselectedRetrieveAction(selectedretrieveaction)
            });
        },
        deleteselectedRetrieveAction(selectedretrieveaction) {
            this.$swal({
                title: 'Suppresion de cette action',
                text: "Validez la Suppression!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Oui'
            }).then((result) => {
                if(result.value) {

                    this.loading = true

                    // eslint-disable-next-line no-undef
                    axios.delete(`/selectedretrieveactions/${selectedretrieveaction.uuid}`)
                        // eslint-disable-next-line no-unused-vars
                        .then(resp => {
                            this.loading = false
                            this.$emit('selectedretrieveaction_deleted', selectedretrieveaction)
                        }).catch(error => {
                        this.loading = false
                        window.handleErrors(error)
                    })
                }
            })
        }
    },
    computed: {

    }
}
</script>

<style scoped>

</style>
