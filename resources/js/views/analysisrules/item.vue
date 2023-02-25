<template>
    <div class="card">
        <header>
            <div class="card-header-title row">
                <div class="col-md-6 col-sm-9 col-12">
                    <span class="text-indigo text-xs" @click="collapseClicked()" data-toggle="collapse" data-parent="#rulelist" :href="'#collapse-rules-'+index">
                        {{ analysisrule.title }}
                    </span>
                </div>
                <div class="col-md-6 col-sm-3 col-12 text-right">
                    <span class="text text-xs">
                        <a type="button" class="btn btn-tool text-warning" data-toggle="tooltip" @click="editRule(analysisrule)">
                            <i class="fa fa-pencil-square-o"></i>
                        </a>
                        <a type="button" class="btn btn-tool" @click="collapseClicked()" data-toggle="collapse" data-parent="#rulelist" :href="'#collapse-rules-'+index">
                            <i :class="currentCollapseIcon"></i>
                        </a>
                        <a type="button" class="btn btn-tool text-danger" @click="deleteRule(analysisrule, index)">
                            <i class="fa fa-trash"></i>
                        </a>
                    </span>
                </div>
            </div>
            <!-- /.user-block -->
        </header>
        <!-- /.card-header -->
        <div :id="'collapse-rules-'+index" class="card-content panel-collapse collapse in">
            <form role="form">
                <div class="form-group row">
                    <label for="rule_type" class="col-sm-2 col-form-label text-xs">Rule Type</label>
                    <div class="col-sm-10">
                        <input readonly type="text" class="form-control form-control-sm border-0" style="background-color: white" id="rule_type" name="type" placeholder="Type" v-model="analysisrule.analysisruletype.name">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success col-sm-6">
                        <input disabled type="checkbox" class="custom-control-input" :id="'alert_when_allowed'+ analysisrule.id" name="alert_when_allowed" placeholder="Alert when allowed" v-model="analysisrule.alert_when_allowed">
                        <label class="custom-control-label" :for="'alert_when_allowed' + analysisrule.id"><span class="text text-xs">Alert when Allowed <i class="far fa-bell"></i></span></label>
                    </div>
                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success col-sm-6">
                        <input disabled type="checkbox" class="custom-control-input" :id="'alert_when_broken' + analysisrule.id" name="alert_when_broken" placeholder="Alert when allowed" v-model="analysisrule.alert_when_broken">
                        <label class="custom-control-label" :for="'alert_when_broken' + analysisrule.id"><span class="text text-xs">Alert when Broken <i class="far fa-bell"></i></span></label>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="description" class="col-sm-2 col-form-label text-xs">Description</label>
                    <div class="col-sm-10">
                        <input readonly type="text" class="form-control form-control-sm border-0" style="background-color: white" id="description" name="description" placeholder="Type" v-model="analysisrule.description">
                    </div>
                </div>
            </form>

            <status-show :model_type_prop="analysisrule.model_type" :model_id_prop="analysisrule.id" :status_prop="analysisrule.status"></status-show>

            <component :ref="analysisrule.innerrule.id" :is="innerruleview" :model_type_prop="analysisrule.innerrule_type" :innerrule_prop="analysisrule.innerrule"></component>

            <div class="card" :id="'highlightsgroup_' + analysisrule.id">
                <header>
                    <div class="card-header-title row">
                        <div class="col-md-6 col-sm-8 col-12">
                            <span class="text-olive text-xs" @click="collapseHighlightsGroupClicked()" data-toggle="collapse" :data-parent="'#highlightsgroup_' + analysisrule.id" :href="'#collapse-highlightsgroup-'+analysisrule.id">
                                Highlights
                            </span>
                            <b-button size="is-small" type="is-ghost" @click="createHighlight()"><i class="fas fa-plus"></i></b-button>
                        </div>
                        <div class="col-md-6 col-sm-4 col-12 text-right">
                                <span class="text text-sm">
                                    <a type="button" class="btn btn-tool" @click="collapseHighlightsGroupClicked()" data-toggle="collapse" :data-parent="'#highlightsgroup_' + analysisrule.id" :href="'#collapse-highlightsgroup-'+analysisrule.id">
                                        <i :class="currentHighlightsGroupCollapseIcon"></i>
                                    </a>
                                </span>
                        </div>
                    </div>
                </header>
                <!-- /.card-header -->
                <div :id="'collapse-highlightsgroup-'+analysisrule.id" class="card-content panel-collapse collapse in">

                    <analysis-highlights v-if="whenbrokenhighlights.length" :key="highlighs_brokrn_key" :analysisrule_prop="analysisrule" :highlights_prop="whenbrokenhighlights" when_rule_result_is_prop="broken" list_title_prop="When Broken" list_color_prop="danger"></analysis-highlights>
                    <analysis-highlights v-if="whenallowedhighlights.length" :key="highlighs_allowed_key" :analysisrule_prop="analysisrule" :highlights_prop="whenallowedhighlights" when_rule_result_is_prop="allowed" list_title_prop="When Allowed" list_color_prop="success"></analysis-highlights>

                </div>
                <!-- /.card-body -->
            </div>

        </div>
        <!-- /.card-body -->
        <add-update-highlight></add-update-highlight>
    </div>
</template>

<script>
    import RuleBus from "./analysisruleBus";
    import HighlightBus from "../analysishighlights/analysishighlightBus";

    export default {
        name: "rule-item",
        props: {
            analysisrule_prop: {},
            index_prop: {}
        },
        components: {
            analysisrulethreshold: () => import('./innerrules/analysisrulethreshold'),
            StatusShow: () => import('../statuses/show'),
            AddUpdateHighlight: () => import('../analysishighlights/addupdate'),
            AnalysisHighlights: () => import('../analysishighlights/list'),
        },
        mounted() {
            RuleBus.$on('analysisrule_updated', (analysisrule) => {
                if (this.analysisrule.id === analysisrule.id) {
                    this.updateRule(analysisrule)
                }
            })

            this.$on('analysisrule_updated', (upd_data) => {
                if (this.analysisrule.id === upd_data.rule.id) {
                    this.updateRule(upd_data.rule)
                }
            })

            this.$on('highlight_created', (highlight) => {
                //HighlightBus.$emit('highlight_created', highlight)
                console.log('highlight_created received on rule: ', this.analysisrule, highlight)
                if (this.analysisrule.id === highlight.analysis_rule_id) {
                    this.reloadHighlights(highlight)
                }
            })

            HighlightBus.$on('edit_highlight', (highlight) => {
                this.$emit('edit_highlight', { highlight })
            })

            this.$on('highlight_updated', (highlight) => {
                console.log('highlight_updated received on rule: ', this.analysisrule, highlight)
                if (this.analysisrule.id === highlight.analysis_rule_id) {
                    this.reloadHighlights(highlight)
                }
            })

            this.$on('highlight_deleted', (highlight) => {
                console.log('highlight_deleted received on rule: ', this.analysisrule, highlight)
                if (this.analysisrule.id === highlight.analysis_rule_id) {
                    this.reloadHighlights(highlight)
                }
            })
        },
        data() {
            return {
                analysisrule: this.analysisrule_prop,
                innerruleview: this.analysisrule_prop.analysisruletype.view_name,
                index: this.index_prop,
                collapse_icon: 'fas fa-chevron-down',
                highlightsgroup_collapse_icon: 'fas fa-chevron-down',
                commom_key: 0,
                highlighs_allowed_key: this.analysisrule_prop + '_allowed_' + 0,
                highlighs_brokrn_key: this.analysisrule_prop + '_brokrn_' + 0,
                isOpen: true
            }
        },
        methods: {
            forceRerenderHighlightsLists() {
                this.commom_key += 1;
                this.highlighs_allowed_key = this.analysisrule.id + '_allowed_' + this.commom_key;
                this.highlighs_brokrn_key += this.analysisrule.id + '_brokrn_' + this.commom_key0;
            },
            createHighlight() {
                let analysisrule = this.analysisrule
                this.$emit('create_new_highlight', { analysisrule })
            },
            editRule(analysisrule) {
                RuleBus.$emit('edit_analysisrule', { analysisrule });
            },
            updateRule(analysisrule) {
                this.analysisrule = analysisrule
            },
            deleteRule(analysisrule, index) {

                this.$swal({
                    title: '<small>Are you sure ?</small>',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if(result.value) {

                        axios.delete(`/analysisrules/${analysisrule.uuid}`)
                            .then(resp => {
                                this.$swal({
                                    html: '<small>Aanalysis Rule successfully deleted !</small>',
                                    icon: 'success',
                                    timer: 3000
                                }).then(() => {
                                    this.$parent.$emit('analysisrule_deleted', { analysisrule, index })
                                })
                            }).catch(error => {
                            window.handleErrors(error)
                        })

                    }
                })
            },
            reloadHighlights(highlight) {
                // analysisrules.fetchone
                axios.get(`/analysisrules.fetchone/${this.analysisrule.id}`)
                    .then((result => {
                        this.analysisrule = result.data;
                        console.log('analysisrule reloaded on rule: ', result, highlight)
                        this.$emit('analysisrule_reloaded', { 'when_rule_result_is': "allowed", 'highlights':result.data.whenallowedhighlights, 'analysisrule':result.data});
                        this.$emit('analysisrule_reloaded', { 'when_rule_result_is': "broken", 'highlights':result.data.whenbrokenhighlights, 'analysisrule':result.data});

                        this.forceRerenderHighlightsLists()
                    }))
                    .catch(error => {
                    window.handleErrors(error)
                });
            },
            collapseClicked() {
                if (this.collapse_icon === 'fas fa-chevron-down') {
                    this.collapse_icon = 'fas fa-chevron-up';
                } else {
                    this.collapse_icon = 'fas fa-chevron-down';
                }
            },
            collapseHighlightsGroupClicked() {
                if (this.highlightsgroup_collapse_icon === 'fas fa-chevron-down') {
                    this.highlightsgroup_collapse_icon = 'fas fa-chevron-up';
                } else {
                    this.highlightsgroup_collapse_icon = 'fas fa-chevron-down';
                }
            }
        },
        computed: {
            currentCollapseIcon() {
                return this.collapse_icon;
            },
            currentHighlightsGroupCollapseIcon() {
                return this.highlightsgroup_collapse_icon;
            },
            whenbrokenhighlights() {
                return this.analysisrule.whenbrokenhighlights
            },
            whenallowedhighlights() {
                return this.analysisrule.whenallowedhighlights
            }
        }
    }
</script>

<style scoped>

</style>
