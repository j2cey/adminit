<template>
    <div class="card collapsed-card">
        <div class="card-header">
            <h5 type="button" class="btn btn-tool" data-card-widget="collapse">
                {{ list_title }}
                <small class="text text-xs">
                    {{ searchPermissions === "" ? "" : " (" + filteredPermissions.length + ")" }}
                </small>
            </h5>

            <div class="card-tools">

                <!--<button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-plus"></i>
                </button>-->

                <!--<button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                </button>-->
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
                                    <b-button size="is-small" type="is-info is-light" @click="createPermission">Ajouter</b-button>
                                </div>
                            </div>
                            <div class="col-sm-3 col-6"></div>
                            <div class="col-sm-3 col-6"></div>
                            <div class="col-sm-3 col-6">
                                <div class="btn-group">
                                    <div class="input-group input-group-sm">
                                        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search" v-model="searchPermissions">
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
                            <div class="col-sm-3 col-6">
                                <span class="text text-sm">Name</span>
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-4 col-6">
                                <span class="text text-sm">Level</span>
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-3 col-6">
                                <span class="text text-sm">Guard Name</span>
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
                <tr v-for="(permission, index) in filteredPermissions" v-if="filteredPermissions" :key="permission.id" class="text text-xs">
                    <td v-if="index < 10">
                        <PermissionItem v-if="permission.name" :permission_prop="permission" v-on:permission_deleted="deletePermission"></PermissionItem>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <!-- ./card-body -->
        <div class="card-footer">

        </div>
        <!-- /.card-footer -->
        <PermissionAddUpdate></PermissionAddUpdate>
    </div>
    <!-- /.card -->
</template>

<script>
import PermissionBus from "./permissionBus";
import SystemBus from "../systems/systemBus";

export default {
    name: "permission-item-list",
    props: {
        list_title_prop: {default: "Permissions", type: String},
        permissions_prop: {}
    },
    components: {
        PermissionAddUpdate: () => import('./addupdate'),
        PermissionItem: () => import('./item')
    },
    mounted() {
        PermissionBus.$on('permission_created', (newpermission) => {
            this.permissions.push(newpermission)
            //SystemBus.$emit('permission_created', newpermission)
            this.$emit('permission_created', newpermission)
        })

        PermissionBus.$on('permission_updated', (updpermission) => {
            //this.permissions.push(newpermission)
            //SystemBus.$emit('permission_created', newpermission)
            //PermissionBus.$emit('permission_updated', updpermission)
        })
    },
    data() {
        return {
            list_title: this.list_title_prop,
            permissions: this.permissions_prop,
            searchPermissions: "",
        };
    },
    methods: {
        createPermission() {
            PermissionBus.$emit('permission_create');
        },
        deletePermission($event) {
            console.log("permission_deleted received at list: ", $event)

            let permissionIndex = this.permissions.findIndex(c => {
                return $event.id === c.id
            })

            if (permissionIndex !== -1) {
                this.permissions.splice(permissionIndex, 1)
            }
        }
    },
    computed: {
        filteredPermissions() {

            let tempPermissions = this.permissions

            if (this.searchPermissions !== '' && this.searchPermissions) {
                tempPermissions = tempPermissions.filter((item) => {
                    return item.name
                        .toUpperCase()
                        .includes(this.searchPermissions.toUpperCase())
                })
            }

            // Sorting
            tempPermissions = tempPermissions.sort((a, b) => {
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
                tempPermissions.reverse()
            }
            // end Sorting

            return tempPermissions
        }
    }
}
</script>

<style scoped>

</style>
