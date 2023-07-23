<template>
    <b-field size="is-small" horizontal>

        <template #label>
            <span class="has-text-primary text-xs">{{ formatrule.formatruletype.name }}</span>
        </template>

        <b-field :type="formatRuleForm.errors.has('title') ? 'is-danger' : 'is-default'">
            <b-input size="is-small" v-model="formatRuleForm.title" name="name" placeholder="Titre" :loading="loading" :readonly="cantBeEdited"></b-input>
        </b-field>
        <b-field :type="formatRuleForm.errors.has('description') ? 'is-danger' : 'is-default'">
            <b-input size="is-small" v-model="formatRuleForm.description" name="description" :loading="loading" :readonly="cantBeEdited"></b-input>
        </b-field>
        <component :ref="formatrule.innerformatrule.id" :is="formatrule.formatruletype.view_name" :formatrule_prop="formatrule" :model_type_prop="formatrule.innerformatrule_type" :innerformatrule_prop="formatrule.innerformatrule"></component>
        <b-field class="text-xs">
            <a @click="editFormatRule(formatrule)" v-if="!editing" class="tw-inline-block tw-mr-3 text-warning">
                <b-icon
                    pack="fas"
                    icon="pencil-square-o"
                    size="is-small">
                </b-icon>
            </a>
            <a @click="updateFormatRule(formatrule)" v-if="editing" class="tw-inline-block tw-mr-3 text-success">
                <b-icon
                    pack="fas"
                    icon="check"
                    size="is-small">
                </b-icon>
            </a>
            <a @click="cancelEditFormatRule(formatrule)" v-if="editing" class="tw-inline-block tw-mr-3 text-info">
                <b-icon
                    pack="fas"
                    icon="ban"
                    size="is-small">
                </b-icon>
            </a>
            <a @click="deleteFormatRule(formatrule)" class="tw-inline-block tw-mr-3 text-danger">
                <b-icon
                    pack="fas"
                    icon="trash"
                    size="is-small">
                </b-icon>
            </a>
        </b-field>
    </b-field>
</template>

<script>
    import FormatRuleBus from "../formatrules/formatruleBus";

    class FormatRule {
        constructor(formatrule) {
            this.title = formatrule.title || ''
            this.description = formatrule.description || ''
            this.formatruletype = formatrule.formatruletype || ''

            this.innerformatrule = formatrule.innerformatrule || ''
        }
    }

    export default {
        name: "formatrule-item",
        props: {
            formatrule_prop: {},
        },
        components: {
            formattextcolor: () => import('./innerformatrules/formattextcolor'),
            formattextsize: () => import('./innerformatrules/formattextsize'),
            formattextweight: () => import('./innerformatrules/formattextweight'),
        },
        mounted() {
            this.$watch(
                "$refs.formatrule.innerformatrule",
                // eslint-disable-next-line no-unused-vars
                (new_value, old_value) => {
                    this.innerformatrule = new_value
                }
            );
        },
        data() {
            return {
                formatrule: this.formatrule_prop,
                innerformatrule: this.formatrule_prop.innerformatrule,

                formatRuleForm: new Form(new FormatRule(this.formatrule_prop)),

                editing: false,
                loading: false,
            }
        },
        methods: {
            editFormatRule(formatrule) {
                this.editing = true
                FormatRuleBus.$emit('formatrule_edit', formatrule)
            },
            cancelEditFormatRule(formatrule) {
                this.editing = false
                this.loading = false
                FormatRuleBus.$emit('formatrule_edit_cancel', formatrule)
            },
            setFormatRuleUpdated(formatrule) {
                this.formatRuleForm = new Form(new FormatRule(formatrule))
                this.cancelEditFormatRule(formatrule)
            },
            updateFormatRule(formatrule) {
                this.loading = true
                FormatRuleBus.$emit('formatrule_updating', formatrule)
                this.formatRuleForm.innerformatrule = this.innerformatrule

                this.formatRuleForm
                    .put(`/formatrules/${this.formatrule.uuid}`,undefined)
                    .then(formatrule => {
                        this.loading = false
                        this.$swal({
                            html: '<small>Règle modifiée avec succès !</small>',
                            icon: 'success',
                            timer: 3000
                        }).then(() => {
                            this.loading = false
                            this.setFormatRuleUpdated(formatrule)
                            FormatRuleBus.$emit('formatrule_updated', formatrule)
                        })

                    }).catch(error => {
                    this.loading = false
                    this.cancelEditFormatRule(formatrule)
                });
            },
            deleteFormatRule(formatrule) {
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

                        axios.delete(`/formatrules/${formatrule.uuid}`)
                            .then(resp => {
                                this.loading = false
                                this.$emit('formatrule_deleted', formatrule)
                            }).catch(error => {
                                this.loading = false
                                window.handleErrors(error)
                        })
                    }
                })
            }
        },
        computed: {
            cantBeEdited() {
                return ! this.editing;
            }
        }
    }
</script>

<style scoped>

</style>
