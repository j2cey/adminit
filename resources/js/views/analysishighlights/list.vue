<template>

    <div class="card collapsed-card border-0">

        <header>
            <div class="card-header-title row">
                <div class="col-md-6 col-sm-8 col-12">
                    <span :class="'text-' + list_color + ' text-xs'" @click="collapseHighlightClicked()" data-card-widget="collapse">
                        {{ list_title }}
                    </span>
                </div>
                <div class="col-md-6 col-sm-4 col-12 text-right">
                    <span v-if="highlights" class="text text-xs">
                        <b-tag v-if="highlights.length < 1" type="is-danger is-light" size="is-small">{{ highlights.length }}</b-tag>
                        <b-tag v-else-if="highlights.length === 1" type="is-success is-light" size="is-small">{{ highlights.length }}</b-tag>
                        <b-tag v-else type="is-danger is-light" size="is-small">{{ highlights.length }}</b-tag>

                        <a type="button" class="btn btn-tool" @click="collapseHighlightClicked()" data-card-widget="collapse">
                            <i :class="currentHighlightCollapseIcon"></i>
                        </a>
                        <a type="button" class="btn btn-tool" data-card-widget="maximize">
                            <i class="fas fa-expand"></i>
                        </a>
                    </span>
                </div>
            </div>
            <!-- /.user-block -->
        </header>
        <!-- /.card-header -->

        <div class="card-body p-0">
            <div class="card-body table-responsive p-0" style="min-height: 200px;">
                <table class="table m-0">
                    <thead v-if="highlights">
                        <tr class="text text-sm">
                            <th>Type</th>
                            <th>Status</th>
                            <th>Details</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(highlight, index) in highlights_list" v-if="highlights_list.length" class="text text-xs">
                        <td>
                            <span class="badge badge-default">{{ highlight.highlighttype.name }}</span>
                        </td>
                        <td>
                            <status-inline-display :model_type_prop="highlight.model_type" :model_id_prop="highlight.id" :status_prop="highlight.status"></status-inline-display>
                        </td>
                        <td>
                            <component :ref="highlight.innerhighlight.id" :is="highlight.highlighttype.view_name" :model_type_prop="highlight.innerhighlight_type" :innerhighlight_prop="highlight.innerhighlight"></component>
                        </td>
                        <td>
                            <div class="block">
                                <span class="fa fa-pencil-square-o text-warning" @click="editHighlit(highlight)"></span>
                                <span class="fa fa-trash text-danger" @click="deleteHighlit(highlight)"></span>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <!-- /.table-responsive -->
        </div>
        <!-- /.card-body -->
        <div class="card-footer">

        </div>
        <!-- /.card-footer -->
    </div>
    <!-- /.card -->

</template>

<script>
    import HighlightBus from "../analysishighlights/analysishighlightBus";

    export default {
        name: "highlights-list",
        props: {
            analysisrule_prop: {},
            highlights_prop: [],
            list_title_prop: "",
            list_color_prop: "",
            when_rule_result_is_prop: "",
        },
        watch: {
            highlights_prop: function (newValue, oldValue) {
                this.highlights = newValue
            },
        },
        components: {
            StatusShow: () => import('../statuses/show'),
            StatusInlineDisplay: () => import('../statuses/inline-display'),
            highlighttextcolor: () => import('./innerhighlights/highlighttextcolor'),
            highlighttextsize: () => import('./innerhighlights/highlighttextsize'),
            highlighttextweight: () => import('./innerhighlights/highlighttextweight'),
        },
        mounted() {
            HighlightBus.$on('highlight_created', (highlight) => {
                if (this.analysisrule.id === highlight.analysis_rule_id && this.when_rule_result_is === highlight.when_rule_result_is) {
                    this.addHighlightToList(highlight)
                }
            })

            HighlightBus.$on('highlight_updated', (highlight) => {
                if (this.analysisrule.id === highlight.analysis_rule_id && this.when_rule_result_is === highlight.when_rule_result_is) {
                    this.updateHighlightFromList(highlight)
                }
            })

            this.$parent.$on('analysisrule_reloaded', ({ when_rule_result_is, highlights, analysisrule }) => {
                console.log('analysisrule_reloaded receive on list ' + this.when_rule_result_is + ': ', when_rule_result_is, highlights, analysisrule)
                if (this.analysisrule.id === analysisrule.id && this.when_rule_result_is === when_rule_result_is) {
                    this.highlights = highlights
                }
            })
        },
        created() {
            //axios.get('/highlighttypes.fetchall').then(({data}) => this.highlighttypes = data);
        },
        data() {
            return {
                analysisrule: this.analysisrule_prop,
                highlights: this.highlights_prop,
                list_title: this.list_title_prop,
                list_color: this.list_color_prop,
                when_rule_result_is: this.when_rule_result_is_prop,
                editing: false,
                loading: false,
                highlighttypes: [],
                highlight_collapse_icon: 'fas fa-chevron-down'
            }
        },
        methods: {
            editHighlit(highlight) {
                HighlightBus.$emit('edit_highlight', highlight)
            },
            collapseHighlightClicked() {
                if (this.highlight_collapse_icon === 'fas fa-chevron-down') {
                    this.highlight_collapse_icon = 'fas fa-chevron-up';
                } else {
                    this.highlight_collapse_icon = 'fas fa-chevron-down';
                }
            },
            addHighlightToList(highlight) {
                let highlightIndex = this.highlights.findIndex(c => {
                    return highlight.id === c.id
                })

                // if this highlight doesn't exists in the list
                if (highlightIndex === -1) {
                    this.highlights.push(highlight)
                }
            },
            updateHighlightFromList(highlight) {
                let highlightIndex = this.reportattributes.findIndex(s => {
                    return highlight.id === s.id
                })

                // if this highlight belongs to the list
                if (highlightIndex > -1) {
                    this.highlights.splice(highlightIndex, 1, highlight)
                }
            },
            deleteHighlit(highlight) {
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

                        axios.delete(`/analysishighlights/${highlight.uuid}`)
                            .then(resp => {
                                this.$swal({
                                    html: '<small>Highlight successfully deleted !</small>',
                                    icon: 'success',
                                    timer: 3000
                                }).then(() => {
                                    this.$parent.$emit('highlight_deleted', highlight)
                                })
                            }).catch(error => {
                            window.handleErrors(error)
                        })

                    }
                })
            }
        },
        computed: {
            isValidCreateForm() {
                return !this.loading
            },
            currentHighlightCollapseIcon() {
                return this.highlight_collapse_icon;
            },
            highlights_list() {
                return this.highlights
            }
        }
    }
</script>

<style scoped>

</style>
