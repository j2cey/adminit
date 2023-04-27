<template>
    <section>
        <b-field>
            <template #label>
                <span class="has-text-black text-xs">{{ list_title }}
                    <b-button type="is-info is-light" size="is-small" @click="toggleCreating(creating)">
                        <b-icon pack="fa" icon="plus" size="is-small"></b-icon>
                    </b-button>
                </span>
            </template>
        </b-field>
        <b-field v-if="creating">
            <b-field :type="formatruletype_has_error ? 'is-danger' : 'is-default'">
                <b-tooltip :active="formatruletype_has_error" :label="formatruletype_error_msg"
                           position="is-bottom"
                           type="is-danger"
                           :animated="false">
                    <b-select size="is-small" placeholder="Type de Règle" name="formatruletype" v-model="formatRuleForm.formatruletype">
                        <option
                            v-for="option in formatruletypes"
                            :value="option"
                            :key="option.id">
                            {{ option.name }}
                        </option>
                    </b-select>
                </b-tooltip>
            </b-field>
            <b-field :type="formatRuleForm.errors.has('title') ? 'is-danger' : 'is-default'">
                <b-tooltip :active="formatRuleForm.errors.has('title')" :label="formatRuleForm.errors.get('title')"
                           position="is-bottom"
                           type="is-danger"
                           :animated="false">
                    <b-input size="is-small" placeholder="Titre" name="title" v-model="formatRuleForm.title"></b-input>
                </b-tooltip>
            </b-field>
            <b-field :type="formatRuleForm.errors.has('description') ? 'is-danger' : 'is-default'" expanded>
                <b-tooltip :active="formatRuleForm.errors.has('description')" :label="formatRuleForm.errors.get('description')"
                           position="is-bottom"
                           type="is-danger"
                           :animated="false">
                    <b-input size="is-small" placeholder="Description" name="description" v-model="formatRuleForm.description" expanded></b-input>
                </b-tooltip>
            </b-field>
            <p class="control">
                <b-button size="is-small" type="is-success" :loading="loading" @click="createFormatRule()" label="Valider" />
            </p>
        </b-field>
        <hr>
        <div class="box">
            <FormatRuleItem v-for="formatrule in formatrules" :key="formatrule.uuid" :formatrule_prop="formatrule" v-on:formatrule_deleted="removeFormatRuleToList"></FormatRuleItem>
        </div>
    </section>
</template>

<script>

    import FormatRuleBus from "../formatrules/formatruleBus";

    class FormatRule {
        constructor(formatrule) {
            this.title = formatrule.title || ''
            this.description = formatrule.description || ''
            this.formatruletype = formatrule.formatruletype || ''

            this.model_type = formatrule.model_type || ''
            this.model_id = formatrule.model_id || ''
        }
    }

    export default {
        name: "formatrule-list",
        props: {
            model_prop: {},
            list_title_prop: {
                default: "Règles de Formattage"
            }
        },
        components: {
            FormatRuleItem: () => import('./item'),
        },
        created() {
            // eslint-disable-next-line no-undef
            axios.get('/formatruletypes.fetchall')
                .then(({data}) => this.formatruletypes = data);
        },
        data() {
            return {
                list_title: this.list_title_prop,
                model: this.model_prop,
                formatruletypes: [],
                filteredFormatRuleTypes: [],
                formatRuleForm: this.getNewformatRuleForm(),
                formatrules: this.model_prop.formatrules,

                creating: false,
                loading: false,

                allowNew: false,
                openOnFocus: true
            }
        },
        methods: {
            getNewformatRuleForm() {
                return new Form(new FormatRule({ 'model_type': this.model_prop.model_type, 'model_id': this.model_prop.id }))
            },
            addFormatRuleToList(formatrule) {
                let formatruleIndex = this.formatrules.findIndex(c => {
                    return formatrule.id === c.id
                })

                // if this format rule doesn't exists in the list
                if (formatruleIndex === -1) {
                    this.formatrules.push(formatrule)
                }
            },
            removeFormatRuleToList($event) {
                let formatruleIndex = this.formatrules.findIndex(c => {
                    return $event.id === c.id
                })

                if (formatruleIndex > -1) {
                    this.formatrules.splice(formatruleIndex, 1)

                    this.$swal({
                        html: '<small>Règle supprimée avec succès !</small>',
                        icon: 'success',
                        timer: 3000
                    }).then(() => {

                    })
                }
            },
            resetFom() {
                this.formatRuleForm = this.getNewformatRuleForm()
            },
            toggleCreating(creating) {
                this.creating = !creating
            },
            createFormatRule() {
                this.loading = true

                this.formatRuleForm
                    .post('/formatrules')
                    .then(newformatrule => {
                        this.loading = false
                        this.$swal({
                            html: '<small>Règle créée avec succès! <br> Prière de compléter les valeurs.</small>',
                            icon: 'success',
                            timer: 3000
                        }).then(() => {
                            FormatRuleBus.$emit('formatrule_created', newformatrule)
                            this.addFormatRuleToList(newformatrule)
                            this.resetFom()
                        })

                    }).catch(error => {
                    this.loading = false
                });
            },

            getFilteredFormatRuleTypes(text) {
                this.filteredFormatRuleTypes = this.formatruletypes.filter((option) => {
                    return option.name
                        .toString()
                        .toLowerCase()
                        .indexOf(text.toLowerCase()) >= 0
                })
            }
        },
        computed: {
            formatruletype_has_error() {
                return this.formatRuleForm.errors.has('formatruletype') || this.formatRuleForm.errors.has('formatruletype_key')
            },
            formatruletype_error_msg() {
                return this.formatRuleForm.errors.get('formatruletype') || this.formatRuleForm.errors.get('formatruletype_key')
            }
        }
    }
</script>

<style scoped>

</style>
