<template>
    <div class="card collapsed-card">
        <div class="card-header">

            <h5 type="button" class="btn btn-tool" data-card-widget="collapse">
                {{ list_title }}
                <small class="text text-xs">
                    {{ searchOsservers === "" ? "" : " (" + filteredOsservers.length + ")" }}
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
                                    <b-button size="is-small" type="is-info is-light" @click="createOsServer">Ajouter</b-button>
                                </div>
                            </div>
                            <div class="col-sm-3 col-6"></div>
                            <div class="col-sm-3 col-6"></div>
                            <div class="col-sm-3 col-6">
                                <div class="btn-group">
                                    <div class="input-group input-group-sm">
                                        <input class="form-control form-control-navbar" type="search" placeholder="Rechercher" aria-label="Search" v-model="searchOsservers">
                                        <div class="input-group-append">
                                            <button class="btn btn-navbar" type="button">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2 col-6">
                                <span class="text text-sm">ID</span>
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-3 col-6">
                                <span class="text text-sm">Nom</span>
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-3 col-6">
                                <span class="text text-sm">Famille</span>
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-2 col-6">
                                <span class="text text-sm">Architecture</span>
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-2 col-6">
                            </div>

                        </div>
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(osserver, index) in filteredOsservers" v-if="filteredOsservers" :key="osserver.id" class="text text-xs">
                    <td v-if="index < 10">
                        <OsServerItem :osserver_prop="osserver" v-on:osserver_deleted="deleteOsServer"></OsServerItem>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <!-- ./card-body -->
        <div class="card-footer">

        </div>
        <!-- /.card-footer -->
        <OsServerAddUpdate></OsServerAddUpdate>
    </div>
    <!-- /.card -->
</template>

<script>
import OsServerBus from "../osservers/osserverBus";

export default {
    name: "osserver-list",
    props: {
        list_title_prop: {default: "Osservers", type: String},
        osservers_list_prop: {},
    },
    components: {
        OsServerAddUpdate: () => import('./addupdate'),
        OsServerItem: () => import('./item')
    },
    mounted() {
        OsServerBus.$on('os_server_created', (osserver) => {
            this.osservers_list.push(osserver)
            // émet l'événement au pararent pour envoyer le nouvel objet créé
            this.$emit('os_server_created', osserver)
        })
    },
    data() {
        return {
            list_title: this.list_title_prop,
            osservers_list: this.osservers_list_prop,
            searchOsservers: "",
        };
    },
    methods: {
        createOsServer() {
            OsServerBus.$emit('os_server_create');
        },
        deleteOsServer($event) {
            //console.log("osserver_deleted received at list: ", $event)
            let itemIndex = this.osservers_list.findIndex(c => {
                return $event.id === c.id
            })
            console.log("itemIndex : ", itemIndex)
            if (itemIndex !== -1) {
                this.osservers_list.splice(itemIndex, 1)
                // emission vers le parent
                //this.$emit('osserver_removed_from_list', $event)
            }
        }
    },
    computed: {
        filteredOsservers() {
            let tempOsservers = this.osservers_list
            if (this.searchOsservers !== '' && this.searchOsservers) {
                tempOsservers = tempOsservers.filter((item) => {
                    return item.name
                        .toUpperCase()
                        .includes(this.searchOsservers.toUpperCase())
                })
            }
            // Sorting
            tempOsservers = tempOsservers.sort((a, b) => {
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
                tempOsservers.reverse()
            }
            // end Sorting
            return tempOsservers
        }
    }
}
</script>

<style scoped>

</style>
