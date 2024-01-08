<template>
    <div>
        <div class="card">
            <header>
                <div class="card-header-title row">
                    <div class="col-md-6 col-sm-8 col-12">
                            <span class="text-olive text-sm">
                                {{ treatment.full_path }}
                            </span>
                    </div>
                    <div class="col-md-6 col-sm-4 col-12 text-right">
                            <span class="text text-sm">
                                <a type="button" class="btn btn-tool text-success" data-toggle="tooltip" @click="showFlowchart(treatment)">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <a type="button" class="btn btn-tool text-warning" data-toggle="tooltip" @click="editTreatment(treatment)">
                                    <i class="fa fa-pencil-square-o"></i>
                                </a>
                                <a type="button" class="btn btn-tool text-danger" @click="deleteTreatment(treatment.uuid)">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </span>
                    </div>
                </div>
                <!-- /.user-block -->
            </header>
            <!-- /.card-header -->
            <div class="card-body">

                <b-tabs size="is-small" type="is-boxed">
                    <b-tab-item>
                        <template #header>
                            <b-icon icon="info-circle" pack="fa"></b-icon>
                            <span> Infos </span>
                        </template>

                        <TreatmentItem :treatment_prop="treatment"></TreatmentItem>

                    </b-tab-item>

                    <b-tab-item>
                        <template #header>
                            <b-icon icon="list-ol" pack="fa"></b-icon>
                            <span class="help-inline pr-1 text-sm"> Sub-Treatments </span>
                        </template>

                        <TreatmentList :treatments_prop="subtreatments"></TreatmentList>

                    </b-tab-item>
                </b-tabs>
            </div>
            <!-- /.card-body -->
        </div>
    </div>

</template>

<script>

import TreatmentBus from "./treatmentBus";

export default {
    name: "treatment-item",
    props: {
        treatment_prop: {},
        subtreatments_prop: {},
    },
    components: {
        TreatmentItem: () => import('../treatments/item'),
        TreatmentList: () => import('../treatments/list'),
    },
    mounted() {
        TreatmentBus.$on('treatment_updated', (updtreatment) => {
            if (this.treatment.id === updtreatment.id) {
                this.treatment = updtreatment
                window.noty({
                    message: 'Treatment successfully updated',
                    type: 'success'
                })
            }
        })
    },
    created() {

    },
    data() {
        return {
            treatment: this.treatment_prop,
            subtreatments: this.subtreatments_prop,
            collapse_icon: 'fas fa-chevron-down',
            collapse_treatmentaccess_icon: 'fas fa-chevron-down',
        }
    },
    methods: {
        editTreatment(treatment) {
            TreatmentBus.$emit('edit_treatment', { treatment })
        },
        showFlowchart(treatment) {
            /*TreatmentBus.$emit('show_flowchart', treatment)*/
            window.location = '/treatments.flowchart/' + treatment.uuid
        },
        deleteTreatment(id, key) {
            this.$swal({
                html: '<small>Do you really want to delete this Treatment ?</small>',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Oui',
                cancelButtonText: 'Non'
            }).then((result) => {
                if(result.value) {

                    axios.delete(`/treatments/${id}`)
                        .then(resp => {

                            console.log('treatment delete resp: ', resp)

                            this.$swal({
                                html: '<small>Treatment successfully deleted !</small>',
                                icon: 'success',
                                timer: 3000
                            }).then(() => {
                                TreatmentBus.$emit('treatmentaction_deleted', {key, resp})
                            })
                        }).catch(error => {
                        window.handleErrors(error)
                    })

                } else {
                    // stay here
                }
            })
        },
        collapseClicked(collapsevar, collapseicon) {
            console.log("collapseClicked: ", collapsevar, collapseicon)
            if (collapseicon === 'fas fa-chevron-down') {
                this[collapsevar] = 'fas fa-chevron-up';
            } else {
                this[collapsevar] = 'fas fa-chevron-down';
            }
        }
    },
    computed: {
        currentCollapseIcon() {
            return this.collapse_icon;
        },

        currentTreatmentAccessCollapseIcon() {
            return this.collapse_treatmentaccess_icon;
        }
    }
}
</script>

<style scoped>

</style>
