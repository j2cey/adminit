<template>
    <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-info elevation-1"><i class="fas fa-cog"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Settings</span>
                        <span class="info-box-number">{{ settings.length }}</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-flag"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Statuses</span>
                        <span class="info-box-number">{{ statuses.length }}</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->

            <!-- fix for small devices only -->
            <div class="clearfix hidden-md-up"></div>

            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-success elevation-1"><i class="fas fa-address-card"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Roles</span>
                        <span class="info-box-number">{{ roles.length }}</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Users</span>
                        <span class="info-box-number">{{ users.length }}</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

        <div class="row">
            <div class="col-md-12">
                <SettingList list_title_prop="Settings List" :settings_prop="settings" :settings_grouped_prop="settings_grouped"></SettingList>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

        <div class="row">
            <div class="col-md-12">
                <StatusList list_title_prop="Statuses List" :statuses_prop="statuses"></StatusList>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

        <div class="row">
            <div class="col-md-12">
                <RoleList list_title_prop="Roles List" :roles_prop="roles"></RoleList>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

        <div class="row">
            <div class="col-md-12">
                <UserList list_title_prop="Users List" :users_prop="users"></UserList>
            </div>
        </div>
        <!-- /.card -->

    </div><!--/. container-fluid -->
</template>

<script>

    export default {
        name: "index-index",
        props: {
            statuses_prop: {},
            settings_prop: {},
            settings_grouped_prop: {},
            roles_prop: {},
            users_prop: {}
        },
        components: {
            SettingList: () => import('../settings/item-list'),
            StatusList: () => import('../statuses/item-list'),
            RoleList: () => import('../roles/item-list'),
            UserList: () => import('../users/item-list'),
        },
        data() {
            return {
                statuses: this.statuses_prop,
                settings: this.settings_prop,
                settings_grouped: this.settings_grouped_prop,
                roles: this.roles_prop,
                users: this.users_prop,
            };
        },
        methods: {
        },
        computed: {
        }
    }
</script>

<style scoped>

</style>
