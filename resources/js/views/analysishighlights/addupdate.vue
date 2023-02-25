<template>
    <div class="modal fade" id="addUpdateHighlight" tabindex="-1" role="dialog" aria-labelledby="highlightModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-sm" id="highlightModalLabel">{{ formTitle }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form class="form-horizontal" @submit.prevent @keydown="highlightForm.errors.clear()">
                        <div class="form-group row">
                            <label for="highlight_title" class="col-sm-4 col-form-label text-xs">Title</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control text-xs" id="highlight_title" name="title" autocomplete="title" autofocus placeholder="Titre" v-model="highlightForm.title">
                                <span class="invalid-feedback d-block text-xs" role="alert" v-if="highlightForm.errors.has('title')" v-text="highlightForm.errors.get('title')"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="when_rule_result_is" class="col-sm-4 col-form-label text-xs">When Rule result is</label>
                            <div class="col-sm-8">
                                <b-field id="when_rule_result_is">
                                    <b-select name="when_rule_result_is" v-model="highlightForm.when_rule_result_is"
                                        placeholder="Small"
                                        size="is-small">
                                        <option value="allowed">Allowed</option>
                                        <option value="broken">Broken</option>
                                    </b-select>
                                </b-field>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="m_select_highlighttype" class="col-sm-4 col-form-label text-xs">Highlight Type</label>
                            <div class="col-sm-8 text-xs">
                                <multiselect class="text text-xs"
                                             id="m_select_highlighttype"
                                             v-model="highlightForm.highlighttype"
                                             selected.sync="highlightForm.highlighttype"
                                             value=""
                                             :options="highlighttypes"
                                             :searchable="true"
                                             :multiple="false"
                                             label="name"
                                             track-by="id"
                                             key="id"
                                             placeholder="Highlight Type"
                                >
                                </multiselect>
                                <span class="invalid-feedback d-block text-xs" role="alert" v-if="highlightForm.errors.has('highlighttype')" v-text="highlightForm.errors.get('highlighttype')"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="highlight_description" class="col-sm-4 col-form-label text-xs">Description</label>
                            <div class="col-sm-8">
                                <input @keyup.enter="formKeyEnterDown()" type="text" class="form-control text-xs" id="highlight_description" name="description" required autocomplete="description" autofocus placeholder="Description" v-model="highlightForm.description">
                                <span class="invalid-feedback d-block text-xs" role="alert" v-if="highlightForm.errors.has('description')" v-text="highlightForm.errors.get('description')"></span>
                            </div>
                        </div>
                    </form>

                </div>
                <div class="modal-footer justify-content-between">
                    <b-button type="is-dark" size="is-small" data-dismiss="modal">Close</b-button>
                    <b-button type="is-primary" size="is-small" :loading="loading" @click="updateHighlight()" :disabled="!isValidCreateForm" v-if="editing">Save</b-button>
                    <b-button type="is-primary" size="is-small" :loading="loading" @click="createHighlight()" :disabled="!isValidCreateForm" v-else>Create Highlight</b-button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</template>

<script>
    import Multiselect from 'vue-multiselect'

    import HighlightBus from "./analysishighlightBus";

    class Highlight {
        constructor(highlight) {
            this.title = highlight.title || ''
            this.highlighttype = highlight.highlighttype || ''
            this.description = highlight.description || ''
            this.analysis_rule_id = highlight.analysis_rule_id || ''
            this.when_rule_result_is = highlight.when_rule_result_is || ''
        }
    }
    export default {
        name: "highlight-addupdate",
        props: {
        },
        components: { Multiselect },
        mounted() {
            this.$parent.$on('create_new_highlight', ({ analysisrule }) => {

                console.log('create_new_highlight received: ', analysisrule)

                this.editing = false

                this.highlight = new Highlight({})
                this.highlight.analysis_rule_id = analysisrule.id

                this.highlightForm = new Form(this.highlight)

                console.log('form ready: ', this.highlightForm)

                this.formTitle = 'Create New Highlight'

                $('#addUpdateHighlight').modal()
            })

            this.$parent.$on('edit_highlight', ({ highlight }) => {
                this.editing = true
                this.highlight = new Highlight(highlight)
                this.highlightForm = new Form(this.highlight)
                this.highlightId = highlight.uuid

                this.formTitle = 'Edit Highlight'

                $('#addUpdateHighlight').modal()
            })
        },
        created() {
            axios.get('/analysishighlighttypes.fetchall')
                .then(({data}) => this.highlighttypes = data);
        },
        data() {
            return {
                formTitle: 'Create Highlight',
                analysisrule: {},
                when_rule_result_is: "",
                highlight: {},
                highlightForm: new Form(new Highlight({})),
                highlightId: null,
                editing: false,
                loading: false,
                highlighttypes: []
            }
        },
        methods: {
            formKeyEnterDown() {
                if (this.editing) {
                    this.updateHighlight()
                } else {
                    this.createHighlight()
                }
            },
            createHighlight() {
                this.loading = true

                //this.highlightForm.analysis_rule_id = this.highlight.analysis_rule_id
                //this.highlightForm.when_rule_result_is = this.when_rule_result_is

                console.log('form to post: ', this.highlightForm)

                this.highlightForm
                    .post('/analysishighlights')
                    .then(highlight => {
                        this.loading = false

                        this.$swal({
                            html: '<small>Highlight successfully created !</small>',
                            icon: 'success',
                            timer: 3000
                        }).then(() => {
                            this.$parent.$emit('highlight_created', highlight)
                            $('#addUpdateHighlight').modal('hide')
                        })

                    }).catch(error => {
                    this.loading = false
                });
            },
            updateHighlight() {
                this.loading = true

                this.highlightForm
                    .put(`/analysishighlights/${this.highlightId}`,undefined)
                    .then(highlight => {

                        this.loading = false
                        console.log('analysishighlights updated result', highlight)

                        this.$swal({
                            html: '<small>Highlight successfully updated !</small>',
                            icon: 'success',
                            timer: 3000
                        }).then(() => {
                            this.$parent.$emit('highlight_updated', highlight)
                            $('#addUpdateHighlight').modal('hide')
                        })

                    }).catch(error => {
                    this.loading = false
                });
            }
        },
        computed: {
            isValidCreateForm() {
                return !this.loading
            }
        }
    }
</script>
