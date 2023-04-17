<template>
    <section>
        <b-tabs>
            <b-tab-item>
                <template #header>
                    <span class="help-inline pr-1 text-xs"> {{ analysisrule.title }} </span>
                </template>

                <b-field size="is-small" horizontal>

                    <template #label>
                        <span class="text text-xs text-orange">{{ analysisrule.analysisruletype.name }}</span>
                    </template>

                    <b-field size="is-small">
                        <b-field size="is-small" :type="analysisRuleForm.errors.has('title') ? 'is-danger' : 'is-default'">
                            <b-input size="is-small" v-model="analysisRuleForm.title" name="name" placeholder="Titre" :loading="loading" :readonly="!editing"></b-input>
                        </b-field>
                        <b-field size="is-small" :type="analysisRuleForm.errors.has('rule_result_for_notification') ? 'is-danger' : 'is-default'">
                            <b-select size="is-small" placeholder="Résultat pour Notification" name="rule_result_for_notification" v-model="analysisRuleForm.rule_result_for_notification" :disabled="!editing">
                                <option
                                    v-for="option in ruleresultenums"
                                    :value="option"
                                    :key="option.value">
                                    {{ option.name }}
                                </option>
                            </b-select>
                        </b-field>
                        <b-field size="is-small" :type="analysisRuleForm.errors.has('description') ? 'is-danger' : 'is-default'">
                            <b-input size="is-small" v-model="analysisRuleForm.description" name="description" :loading="loading" placeholder="Description" :readonly="!editing"></b-input>
                        </b-field>
                        <component :ref="analysisrule.inneranalysisrule.id" :is="analysisrule.analysisruletype.view_name" :analysisrule_prop="analysisrule" :model_type_prop="analysisrule.inneranalysisrule_type" :inneranalysisrule_prop="analysisrule.inneranalysisrule"></component>

                        <b-field size="is-small" class="text-xs" horizontal>
                            <a @click="editAnalysisRule(analysisrule)" v-if="!editing" class="tw-inline-block tw-mr-3 text-warning">
                                <b-icon
                                    pack="fas"
                                    icon="pencil-square-o"
                                    size="is-small">
                                </b-icon>
                            </a>
                            <a @click="updateAnalysisRule(analysisrule)" v-if="editing" class="tw-inline-block tw-mr-3 text-success">
                                <b-icon
                                    pack="fas"
                                    icon="check"
                                    size="is-small">
                                </b-icon>
                            </a>
                            <a @click="cancelEditAnalysisRule(analysisrule)" v-if="editing" class="tw-inline-block tw-mr-3 text-info">
                                <b-icon
                                    pack="fas"
                                    icon="ban"
                                    size="is-small">
                                </b-icon>
                            </a>
                            <a @click="deleteAnalysisRule(analysisrule)" class="tw-inline-block tw-mr-3 text-danger">
                                <b-icon
                                    pack="fas"
                                    icon="trash"
                                    size="is-small">
                                </b-icon>
                            </a>
                        </b-field>
                    </b-field>
                </b-field>

            </b-tab-item>

            <b-tab-item>
                <template #header>
                    <span class="help-inline pr-1 text-xs"> Formattage </span>
                    <b-tag rounded type="is-info is-light text-xs">{{ analysisrule.formatrules.length }}</b-tag>
                </template>

                    <FormatRuleList :model_prop="analysisrule" list_title_prop="Formattage à appliquer pour cette règle"></FormatRuleList>

            </b-tab-item>
        </b-tabs>
    </section>
</template>

<script>
    import AnalysisRuleBus from "./analysisruleBus";
    import {resumeTimer, stopTimer} from "sweetalert2";

    class AnalysisRule {
        constructor(analysisrule) {
            this.title = analysisrule.title || ''
            this.rule_result_for_notification = analysisrule.rule_result_for_notification || ''
            this.description = analysisrule.description || ''
            this.analysisruletype = analysisrule.analysisruletype || ''

            this.inneranalysisrule = analysisrule.inneranalysisrule || ''
        }
    }

    export default {
        name: "analysisrule-item",
        props: {
            analysisrule_prop: {}
        },
        components: {
            FormatRuleList: () => import('../formatrules/list'),
            analysisrulethreshold: () => import('./inneranalysisrules/analysisrulethreshold'),
            analysisrulecomparison: () => import('./inneranalysisrules/analysisrulecomparison'),
        },
        mounted() {
            this.$watch(
                "$refs.analysisrule.inneranalysisrule",
                // eslint-disable-next-line no-unused-vars
                (new_value, old_value) => {
                    this.inneranalysisrule = new_value
                }
            );
        },
        created() {
            // eslint-disable-next-line no-undef
            axios.get('/ruleresultenums.fetch')
                .then(({data}) => this.ruleresultenums = data);
        },
        data() {
            return {
                analysisrule: this.analysisrule_prop,
                inneranalysisrule: this.analysisrule_prop.inneranalysisrule,

                // eslint-disable-next-line no-undef
                analysisRuleForm: new Form(new AnalysisRule(this.analysisrule_prop)),
                ruleresultenums: [],

                innerruleview: this.analysisrule_prop.analysisruletype.view_name,

                editing: false,
                loading: false
            }
        },
        methods: {
            getNewanalysisRuleForm() {
                // eslint-disable-next-line no-undef
                return new Form(new AnalysisRule({
                    'rule_result_for_notification': this.getRuleResult(this.analysisrule_prop.rule_result_for_notification)
                }))
            },

            editAnalysisRule(analysisrule) {
                this.editing = true
                AnalysisRuleBus.$emit('analysisrule_edit', analysisrule)
            },
            cancelEditAnalysisRule(analysisrule) {
                this.editing = false
                this.loading = false

                this.setAnalysisRuleAndForm(this.analysisrule)

                AnalysisRuleBus.$emit('analysisrule_edit_cancel', analysisrule)
            },
            setAnalysisRuleAndForm(analysisrule, canceledit = false) {
                this.analysisrule = analysisrule
                // eslint-disable-next-line no-undef
                this.analysisRuleForm = new Form(new AnalysisRule(analysisrule))
                if (canceledit) {
                    this.cancelEditAnalysisRule(analysisrule)
                }
            },
            updateAnalysisRule(analysisrule) {
                this.loading = true
                AnalysisRuleBus.$emit('analysisrule_updating', analysisrule)
                this.analysisRuleForm.inneranalysisrule = this.inneranalysisrule

                this.analysisRuleForm
                    .put(`/analysisrules/${this.analysisrule.uuid}`,undefined)
                    .then(newanalysisrule => {
                        this.loading = false

                        /**/

                        this.$swal({
                            html: '<small>Règle modifiée avec succès !</small>',
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
                            this.setAnalysisRuleAndForm(newanalysisrule, true)
                            AnalysisRuleBus.$emit('analysisrule_updated', newanalysisrule)
                        })

                        // eslint-disable-next-line no-unused-vars
                    }).catch(error => {
                    this.loading = false
                    this.cancelEditAnalysisRule(analysisrule)
                });
            },
            deleteAnalysisRule(analysisrule) {
                this.$swal({
                    title: 'Suppresion de la Règle',
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
                        axios.delete(`/analysisrules/${analysisrule.uuid}`)
                            // eslint-disable-next-line no-unused-vars
                            .then(resp => {
                                this.loading = false
                                this.$emit('analysisrule_deleted', analysisrule)
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
