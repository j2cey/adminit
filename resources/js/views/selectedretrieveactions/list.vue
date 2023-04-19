<template>
    <section>
        <b-field>
            <template #label>
                <span class="has-text-black text-xs">Règles d'Analyse
                    <b-button type="is-info is-light" size="is-small" @click="toggleCreating(creating)">
                        <b-icon pack="fa" icon="plus" size="is-small"></b-icon>
                    </b-button>
                </span>
            </template>
        </b-field>
        <b-field v-if="creating">
            <b-field :type="analysisRuleForm.errors.has('analysisruletype') ? 'is-danger' : 'is-default'">
                <b-tooltip :active="analysisRuleForm.errors.has('analysisruletype')" :label="analysisRuleForm.errors.get('analysisruletype')"
                           position="is-bottom"
                           type="is-danger"
                           :animated="false">
                    <b-select size="is-small" placeholder="Type de Règle" name="analysisruletype" v-model="analysisRuleForm.analysisruletype" expanded>
                        <option
                            v-for="option in analysisruletypes"
                            :value="option"
                            :key="option.id">
                            {{ option.name }}
                        </option>
                    </b-select>
                </b-tooltip>
            </b-field>
            <b-field :type="analysisRuleForm.errors.has('title') ? 'is-danger' : 'is-default'">
                <b-tooltip :active="analysisRuleForm.errors.has('title')" :label="analysisRuleForm.errors.get('title')"
                           position="is-bottom"
                           type="is-danger"
                           :animated="false">
                    <b-input size="is-small" placeholder="Titre" name="title" v-model="analysisRuleForm.title"></b-input>
                </b-tooltip>
            </b-field>
            <b-field :type="analysisRuleForm.errors.has('rule_result_for_notification') ? 'is-danger' : 'is-default'">
                <b-tooltip :active="analysisRuleForm.errors.has('rule_result_for_notification')" :label="analysisRuleForm.errors.get('rule_result_for_notification')"
                           position="is-bottom"
                           type="is-danger"
                           :animated="false">
                    <b-select size="is-small" placeholder="Résultat pour Notification" name="rule_result_for_notification" v-model="analysisRuleForm.rule_result_for_notification">
                        <option
                            v-for="option in ruleresultenums"
                            :value="option"
                            :key="option.value">
                            {{ option.name }}
                        </option>
                    </b-select>
                </b-tooltip>
            </b-field>
            <b-field :type="analysisRuleForm.errors.has('description') ? 'is-danger' : 'is-default'" expanded>
                <b-tooltip :active="analysisRuleForm.errors.has('description')" :label="analysisRuleForm.errors.get('description')"
                           position="is-bottom"
                           type="is-danger"
                           :animated="false">
                    <b-input size="is-small" placeholder="Description" name="description" v-model="analysisRuleForm.description" expanded></b-input>
                </b-tooltip>
            </b-field>
            <p class="control">
                <b-button size="is-small" type="is-success" :loading="loading" @click="createAnalysisRule()" label="Valider" />
            </p>
        </b-field>
        <hr>
        <div class="box">
            <AnalysisRuleItem v-for="analysisrule in analysisrules" :key="analysisrule.uuid" :analysisrule_prop="analysisrule" v-on:analysisrule_deleted="removeAnalysisRuleToList"></AnalysisRuleItem>
        </div>
    </section>

</template>

<script>

    import AnalysisRuleBus from "./analysisruleBus";

    class AnalysisRule {
        constructor(analysisrule) {
            this.title = analysisrule.title || ''
            this.rule_result_for_notification = analysisrule.rule_result_for_notification || ''
            this.description = analysisrule.description || ''
            this.analysisruletype = analysisrule.analysisruletype || ''

            this.model_type = analysisrule.model_type || ''
            this.model_id = analysisrule.model_id || ''
        }
    }

    export default {
    name: "list",
        props: {
            selectedretrieveactions_prop: {}
        },
    }
</script>

<style scoped>

</style>
