<template>
    <div class="card collapsed-card">
        <div class="card-header">

            <h5 type="button" class="btn btn-tool" data-card-widget="collapse">
                {{ list_title }}
                <small class="text text-xs">
                    {{ searchAccessprotocoles === "" ? "" : " (" + filteredAccessprotocoles.length + ")" }}
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
                                    <b-button size="is-small" type="is-info is-light" @click="createAccessProtocole">Ajouter</b-button>
                                </div>
                            </div>
                            <div class="col-sm-3 col-6"></div>
                            <div class="col-sm-3 col-6"></div>
                            <div class="col-sm-3 col-6">
                                <div class="btn-group">
                                    <div class="input-group input-group-sm">
                                        <input class="form-control form-control-navbar" type="search" placeholder="Rechercher" aria-label="Search" v-model="searchAccessprotocoles">
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
                            <div class="col-sm-2 col-6">
                                <span class="text text-sm">Description</span>
                            </div>
                        </div>
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(accessprotocole, index) in filteredAccessprotocoles" v-if="filteredAccessprotocoles" :key="accessprotocole.id" class="text text-xs">
                    <td v-if="index < 10">
                        <AccessProtocoleItem :accessprotocole_prop="accessprotocole" v-on:accessprotocole_deleted="deleteAccessProtocole"></AccessProtocoleItem>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <!-- ./card-body -->
        <div class="card-footer">

        </div>
        <!-- /.card-footer -->
        <AccessProtocoleAddUpdate></AccessProtocoleAddUpdate>
    </div>
    <!-- /.card -->
</template>

<script>
import AccessProtocoleBus from "../accessprotocoles/accessprotocoleBus";

export default {
    name: "accessprotocole-list",
    props: {
        list_title_prop: {default: "Accessprotocoles", type: String},
        accessprotocoles_list_prop: {},
    },
    components: {
        AccessProtocoleAddUpdate: () => import('./addupdate'),
        AccessProtocoleItem: () => import('./item')
    },
    mounted() {
        AccessProtocoleBus.$on('access_protocole_created', (accessprotocole) => {
            this.accessprotocoles_list.push(accessprotocole)
            // émet l'événement au pararent pour envoyer le nouvel objet créé
            this.$emit('access_protocole_created', accessprotocole)
        })
    },
    data() {
        return {
            list_title: this.list_title_prop,
            accessprotocoles_list: this.accessprotocoles_list_prop,
            searchAccessprotocoles: "",
        };
    },
    methods: {
        createAccessProtocole() {
            AccessProtocoleBus.$emit('access_protocole_create');
        },
        deleteAccessProtocole($event) {
            //console.log("accessprotocole_deleted received at list: ", $event)
            let itemIndex = this.accessprotocoles_list.findIndex(c => {
                return $event.id === c.id
            })
            console.log("itemIndex : ", itemIndex)
            if (itemIndex !== -1) {
                this.accessprotocoles_list.splice(itemIndex, 1)
                // emission vers le parent
                //this.$emit('accessprotocole_removed_from_list', $event)
            }
        }
    },
    computed: {
        filteredAccessprotocoles() {
            let tempAccessprotocoles = this.accessprotocoles_list
            if (this.searchAccessprotocoles !== '' && this.searchAccessprotocoles) {
                tempAccessprotocoles = tempAccessprotocoles.filter((item) => {
                    return item.name
                        .toUpperCase()
                        .includes(this.searchAccessprotocoles.toUpperCase())
                })
            }
            // Sorting
            tempAccessprotocoles = tempAccessprotocoles.sort((a, b) => {
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
                tempAccessprotocoles.reverse()
            }
            // end Sorting
            return tempAccessprotocoles
        }
    }
}
</script>

<style scoped>

</style>
