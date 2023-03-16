<template>
    <div class="card">
        <div class="card-header">

            <h5>
                {{ list_title }}
                <small class="text text-xs">
                    {{ searchReportfileaccesses === "" ? "" : " (" + filteredReportfileaccesses.length + ")" }}
                </small>
            </h5>

            <div class="card-tools">

            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive p-0">
            <table class="table table-head-fixed text-nowrap">
                <thead>
                <tr>
                    <th>
                        <div class="row">
                            <div class="col-sm-3 col-6">
                                <div class="btn-group">
                                    <b-button size="is-small" type="is-info is-light" @click="createReportFileAccess">Ajouter</b-button>
                                </div>
                            </div>
                            <div class="col-sm-3 col-6"></div>
                            <div class="col-sm-3 col-6"></div>
                            <div class="col-sm-3 col-6">
                                <div class="btn-group">
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <b-select placeholder="Select Rechercher" size="is-small" @input="searchtypeSelected($event)" :loading="searching" v-model="searchtype_selected">
                                                <option
                                                    v-for="option in searchtypes"
                                                    :value="option"
                                                    :key="option">
                                                    {{ option }}
                                                </option>
                                            </b-select>
                                        </div>
                                        <input class="form-control form-control-navbar" type="search" placeholder="Rechercher ..." aria-label="Search" v-model="searchReportfileaccesses" :disabled="!searchtype_selected">
                                        <div class="input-group-append">
                                            <button class="btn btn-navbar" type="button" :disabled="!searchtype_selected" @click="clearSearchtype">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3 col-6">
                                <span class="text text-sm">Compte</span>
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-3 col-6">
                                <span class="text text-sm">Serveur</span>
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-2 col-6">
                                <span class="text text-sm">Protocole</span>
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-2 col-6">
                                <span class="text text-sm">Statut</span>
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-2 col-6">
                                <span class="text text-sm"></span>
                            </div>
                        </div>
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(reportfileaccess, index) in filteredReportfileaccesses" v-if="filteredReportfileaccesses" :key="reportfileaccess.id" class="text text-xs">
                    <td v-if="index < 10">
                        <ReportFileAccessListdetail :reportfileaccess_prop="reportfileaccess" v-on:report_file_access_deleted="deleteReportFileAccess"></ReportFileAccessListdetail>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <!-- ./card-body -->
        <div class="card-footer">

        </div>
        <!-- /.card-footer -->
        <ReportFileAccessAddUpdate></ReportFileAccessAddUpdate>
    </div>
    <!-- /.card -->
</template>

<script>
import ReportFileAccessBus from "../reportfileaccesses/reportfileaccessBus";

export default {
    name: "reportfileaccess-list",
    props: {
        list_title_prop: {default: "Accès", type: String},
        reportfile_prop: {},
        reportfileaccesses_list_prop: {},
    },
    components: {
        ReportFileAccessAddUpdate: () => import('./addupdate'),
        ReportFileAccessListdetail: () => import('./listitem')
    },
    mounted() {
        ReportFileAccessBus.$on('report_file_type_created', (reportfileaccess) => {
            if (this.reportfile.id === reportfileaccess.reportfile.id) {
                this.addReportfileaccessToList(reportfileaccess)
            }
        })
    },
    data() {
        return {
            list_title: this.list_title_prop,
            reportfile: this.reportfile_prop,
            reportfileaccesses_list: this.reportfileaccesses_list_prop,
            searchReportfileaccesses: "",
            searchtypes: ['compte','serveur','protocole'],
            searchtype_selected: null,
            searching: false
        };
    },
    methods: {
        createReportFileAccess() {
            let reportfile = this.reportfile
            ReportFileAccessBus.$emit('report_file_type_create', reportfile);
        },
        deleteReportFileAccess($event) {
            //console.log("report_file_access_deleted received at list: ", $event)
            let itemIndex = this.reportfileaccesses_list.findIndex(c => {
                return $event.id === c.id
            })
            console.log("itemIndex : ", itemIndex)
            if (itemIndex !== -1) {
                this.reportfileaccesses_list.splice(itemIndex, 1)
                // emission vers le parent
                //this.$emit('reportfileaccess_removed_from_list', $event)
            }
        },
        searchtypeSelected($event) {
            console.log("searchtypeSelected: ",$event)
            console.log("searchtype_selected: ",this.searchtype_selected)
        },
        clearSearchtype() {
            this.searchReportfileaccesses = ""
            this.searchtype_selected = null
        },
        addReportfileaccessToList(reportfileaccess) {
            let itemIndex = this.reportfileaccesses_list.findIndex(c => {
                return reportfileaccess.id === c.id
            })

            if (itemIndex === -1) {
                this.reportfileaccesses_list.push(reportfileaccess)
                this.$emit('report_file_type_added', reportfileaccess)
            }
        }
    },
    computed: {
        filteredReportfileaccesses() {
            let tempReportfileaccesses = this.reportfileaccesses_list
            if (this.searchReportfileaccesses !== '' && this.searchReportfileaccesses) {
                if (this.searchtype_selected === "compte") {
                    // search by compte
                    tempReportfileaccesses = tempReportfileaccesses.filter((item) => {
                        return item.accessaccount.login
                            .toUpperCase()
                            .includes(this.searchReportfileaccesses.toUpperCase())
                    })
                } else if (this.searchtype_selected === "serveur") {
                    // search by serveur
                    tempReportfileaccesses = tempReportfileaccesses.filter((item) => {
                        return item.reportserver.name
                            .toUpperCase()
                            .includes(this.searchReportfileaccesses.toUpperCase())
                    })
                } else {
                    // search by protocole
                    tempReportfileaccesses = tempReportfileaccesses.filter((item) => {
                        return item.accessprotocole.name
                            .toUpperCase()
                            .includes(this.searchReportfileaccesses.toUpperCase())
                    })
                }
            }
            // Sorting
            tempReportfileaccesses = tempReportfileaccesses.sort((a, b) => {
                let fa = a.name.toLowerCase(), fb = b.name.toLowerCase()
                if (fa > fb) {
                    return -1
                }
                if (fa < fb) {
                    return 1
                }
                return 0
            })
            if (!this.ascending) {
                tempReportfileaccesses.reverse()
            }
            // end Sorting
            return tempReportfileaccesses
        }
    }
}
</script>

<style scoped>

</style>
