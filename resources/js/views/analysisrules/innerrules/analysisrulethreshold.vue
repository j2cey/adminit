<template>
    <form class="form-horizontal" @submit.prevent @keydown="innerruleForm.errors.clear()">
        <div class="form-group row" :id="'innerrule_' + innerrule.id">
            <div class="col">
                <div class="card">
                    <header>
                        <div class="card-header-title row">
                            <div class="col-md-6 col-sm-8 col-12">
                                <span class="text-orange text-xs" @click="collapseInnerruleClicked()" data-toggle="collapse" :data-parent="'#innerrule_' + innerrule.id" :href="'#collapse-innerrule-'+innerrule.id">
                                    Rule Details
                                </span>
                            </div>
                            <div class="col-md-6 col-sm-4 col-12 text-right">
                                <span class="text text-sm">
                                    <a type="button" class="btn btn-tool" @click="collapseInnerruleClicked()" data-toggle="collapse" :data-parent="'#innerrule_' + innerrule.id" :href="'#collapse-innerrule-'+innerrule.id">
                                        <i :class="currentInnerruleCollapseIcon"></i>
                                    </a>
                                </span>
                            </div>
                        </div>
                    </header>
                    <!-- /.card-header -->
                    <div :id="'collapse-innerrule-'+innerrule.id" class="card-content panel-collapse collapse in">
                        <b-field grouped group-multiline>
                            <b-field label="Threshold" label-position="on-border" custom-class="is-small"
                                     :type="innerruleForm.errors.has('threshold') ? 'is-danger' : ''"
                                     :message="innerruleForm.errors.get('threshold')">
                                <b-input name="threshold" size="is-small" v-model="innerrule.threshold"></b-input>
                            </b-field>
                        </b-field>
                        <br>
                        <b-field grouped group-multiline>
                            <b-radio v-for="(thresholdtype, index) in thresholdtypes" :key="thresholdtype.id" size="is-small" v-model="innerrule.thresholdtype.code"
                                     name="thresholdtype"
                                     :native-value="thresholdtype.code" @input="testRadioClicked()">
                                {{ thresholdtype.label }}
                            </b-radio>
                        </b-field>
                        <br>
                        <b-field label="Comment" label-position="on-border" custom-class="is-small"
                                 :type="innerruleForm.errors.has('comment') ? 'is-danger' : ''"
                                 :message="innerruleForm.errors.get('comment')">
                            <b-input name="comment"
                                     size="is-small" v-model="innerrule.comment"></b-input>
                        </b-field>
                        <hr>
                        <b-field grouped group-multiline>
                            <b-button label="Save" type="is-danger is-light" size="is-small" :loading="loading" @click="saveInnerrule()" />
                        </b-field>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
    </form>
</template>

<script>
    class InnerRule {
        constructor(innerrule) {
            this.threshold = innerrule.threshold || ''
            this.thresholdtype = innerrule.thresholdtype || ''
            this.label = innerrule.label || ''
            this.comment = innerrule.comment || ''
            this.status = innerrule.status || ''
        }
    }

    export default {
        name: "analysisrulethreshold",
        props: {
            innerrule_prop: {},
            model_type_prop: "",
        },
        components: {

        },
        created() {
            axios.get('/thresholdtypes.fetchall')
                .then(({data}) => this.thresholdtypes = data);
        },
        data() {
            return {
                model_type: this.model_type_prop,
                innerrule: this.innerrule_prop,
                innerruleForm: new Form( this.innerrule_prop ),
                editing: false,
                loading: false,
                thresholdtypes: [],
                innerrule_collapse_icon: 'fas fa-chevron-down'
            }
        },
        methods: {
            testRadioClicked() {
                console.log("radio clicked !")
            },
            testBuefyToast() {
                this.$buefy.toast.open('Something happened');
            },
            saveInnerrule() {
                this.loading = true
                const fd = undefined;

                this.innerruleForm = new Form( this.innerrule )

                this.innerruleForm
                    .put(`/analysisrulethresholds/${this.innerrule.uuid}`, fd)
                    .then(innerrule => {
                        this.loading = false
                        //$('#addUpdateWorkflowstep').modal('hide')
                        this.$swal({
                            html: '<small>Threshold Rule Details Successfully Updated !</small>',
                            icon: 'success',
                            timer: 3000
                        }).then(() => {
                            this.innerrule = innerrule
                        })
                    }).catch(error => {
                    this.loading = false
                }).finally(

                );
            },
            collapseInnerruleClicked() {
                if (this.innerrule_collapse_icon === 'fas fa-chevron-down') {
                    this.innerrule_collapse_icon = 'fas fa-chevron-up';
                } else {
                    this.innerrule_collapse_icon = 'fas fa-chevron-down';
                }
            },
        },
        computed: {
            isValidCreateForm() {
                return !this.loading
            },
            currentInnerruleCollapseIcon() {
                return this.innerrule_collapse_icon;
            },
            getInnerruleForm() {
                return this.innerruleForm;
            }
        }
    }
</script>

<style scoped>

</style>
