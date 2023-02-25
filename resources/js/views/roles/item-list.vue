<template>
    <div class="card collapsed-card">
        <div class="card-header">
            <h5 class="card-title">{{ list_title ? list_title : 'Roles' }}</h5>

            <div class="card-tools">

                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-plus"></i>
                </button>
                <div class="btn-group">
                    <button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown">
                        <i class="fas fa-wrench"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" role="menu">
                        <a href="#" class="dropdown-item">Action</a>
                        <a href="#" class="dropdown-item">Another action</a>
                        <a href="#" class="dropdown-item">Something else here</a>
                        <a class="dropdown-divider"></a>
                        <a href="#" class="dropdown-item">Separated link</a>
                    </div>
                </div>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive p-0">
            <table class="table table-head-fixed text-nowrap">
                <thead>
                <tr>
                    <th>
                        <div class="row">
                            <div class="col-sm-3 col-6"></div>
                            <div class="col-sm-3 col-6"></div>
                            <div class="col-sm-3 col-6"></div>
                            <div class="col-sm-3 col-6">
                                <div class="btn-group">
                                    <div class="input-group input-group-sm">
                                        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search" v-model="searchRoles">
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
                                <span class="text text-sm">Description</span>
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-3 col-6">
                                <span class="text text-sm">Permission(s)</span>
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
                <tr v-for="(role, index) in filteredRoles" v-if="filteredRoles" :key="role.id" class="text text-xs">
                    <td v-if="index < 10">
                        <RoleItem v-if="role.name" :role_prop="role"></RoleItem>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <!-- ./card-body -->
        <div class="card-footer">

        </div>
        <!-- /.card-footer -->
        <RoleAddUpdate></RoleAddUpdate>
    </div>
    <!-- /.card -->
</template>

<script>
    export default {
        name: "role-item-list",
        props: {
            list_title_prop: null,
            roles_prop: {}
        },
        components: {
            RoleAddUpdate: () => import('./addupdate'),
            RoleItem: () => import('./item')
        },
        data() {
            return {
                list_title: this.list_title_prop,
                roles: this.roles_prop,
                searchRoles: null,
            };
        },
        methods: {
        },
        computed: {
            filteredRoles() {

                let tempRoles = this.roles

                if (this.searchRoles !== '' && this.searchRoles) {
                    tempRoles = tempRoles.filter((item) => {
                        return item.name
                            .toUpperCase()
                            .includes(this.searchRoles.toUpperCase())
                    })
                }

                // Sorting
                tempRoles = tempRoles.sort((a, b) => {
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
                    tempRoles.reverse()
                }
                // end Sorting

                return tempRoles
            }
        }
    }
</script>

<style scoped>

</style>
