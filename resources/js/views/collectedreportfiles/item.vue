<template>
    <b-tabs size="is-small" type="is-boxed">
        <b-tab-item>
            <template #header>
                <b-icon icon="information-outline"></b-icon>
                <span> Infos </span>
            </template>

            <div class="card card-default">
                <div class="card-body">
                    <dl>
                        <dt class="text text-xs">Nom Initiale</dt>
                        <dd class="text text-xs">{{ collectedreportfile.initial_file_name }}</dd>
                        <dt class="text text-xs">Nom Local</dt>
                        <dd class="text text-xs">{{ collectedreportfile.local_file_name }}</dd>
                        <dt class="text text-xs">Fichier de Rapport</dt>
                        <dd class="text text-xs">
                            <a @click="showReportFile(collectedreportfile.reportfile)">
                                {{ collectedreportfile.reportfile.name }}
                            </a>
                        </dd>
                        <dt class="text text-xs">Taille</dt>
                        <dd class="text text-xs">{{ collectedreportfile.file_size }}</dd>
                        <dt class="text text-xs">Nombre de Lignes</dt>
                        <dd class="text text-xs">{{ collectedreportfile.nb_rows }}</dd>
                        <dt class="text text-xs">Nombre de Lignes importées</dt>
                        <dd class="text text-xs">
                            <span class="badge badge-pill badge-success">{{ collectedreportfile.nb_rows_import_success }}</span>
                        </dd>
                        <dt class="text text-xs">Nombre de Lignes échèc importation</dt>
                        <dd class="text text-xs">
                            <span class="badge badge-pill badge-danger">{{ collectedreportfile.nb_rows_import_failed }}</span>
                        </dd>
                        <dt class="text text-xs">Created at</dt>
                        <dd class="text text-xs">{{ collectedreportfile.created_at | formatDate}}</dd>
                    </dl>
                </div>
            </div>
        </b-tab-item>

        <b-tab-item>
            <template #header>
                <b-icon size="small" icon="database"></b-icon>
                <span class="help-inline pr-1 text-sm"> Résultat Importation </span>
                <b-tag rounded type="is-info is-light">{{ collectedreportfile.nb_rows_import_success }}</b-tag>
            </template>
                <ImportedLines :importedlines_prop="collectedreportfile.lines_values" :columns_prop="report.attributes_list"></ImportedLines>
        </b-tab-item>
    </b-tabs>
</template>

<script>
export default {
    props: {
        report_prop: {},
        collectedreportfile_prop: {},
    },
    name: "collectedreportfile-item",
    components: {
        ImportedLines: () => import('../collectedreportfiles/importedlines'),
    },
    data() {
        return {
            collectedreportfile: this.collectedreportfile_prop,
            report: this.report_prop,
            lines_values: JSON.parse( this.collectedreportfile_prop.lines_values ),
        };
    },
    methods: {
        showReportFile(reportfile) {
            window.location = `/reportfiles/${reportfile.uuid}`
        },
    }
}
</script>

<style scoped>

</style>
