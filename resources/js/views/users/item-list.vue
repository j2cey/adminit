<template>
    <div class="card collapsed-card">
        <div class="card-header">
            <h5 class="card-title">{{ list_title ? list_title : 'Users' }}</h5>

            <div class="card-tools">



                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-plus"></i>
                </button>
                <div class="btn-group">
                    <button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown">
                        <i class="fas fa-wrench"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" user="menu">
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
                                        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search" v-model="searchUsers">
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
                                <span class="text text-sm">E-mail</span>
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-3 col-6">
                                <span class="text text-sm">Role(s)</span>
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
                <tr v-for="(user, index) in filteredUsers" v-if="filteredUsers" :key="user.id" class="text text-xs">
                    <td v-if="index < 10">
                        <UserItem v-if="user.name" :user_prop="user"></UserItem>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <!-- ./card-body -->
        <div class="card-footer">

        </div>
        <!-- /.card-footer -->
        <UserAddUpdate></UserAddUpdate>
    </div>
    <!-- /.card -->
</template>

<script>
    export default {
        name: "user-item-list",
        props: {
            list_title_prop: null,
            users_prop: {}
        },
        components: {
            UserAddUpdate: () => import('./addupdate'),
            UserItem: () => import('./item')
        },
        data() {
            return {
                list_title: this.list_title_prop,
                users: this.users_prop,
                searchUsers: null,
            };
        },
        methods: {
        },
        computed: {
            filteredUsers() {

                let tempUsers = this.users

                if (this.searchUsers !== '' && this.searchUsers) {
                    tempUsers = tempUsers.filter((item) => {
                        return item.name
                            .toUpperCase()
                            .includes(this.searchUsers.toUpperCase())
                    })
                }

                // Sorting
                tempUsers = tempUsers.sort((a, b) => {
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
                    tempUsers.reverse()
                }
                // end Sorting

                return tempUsers
            }
        }
    }
</script>

<style scoped>

</style>
