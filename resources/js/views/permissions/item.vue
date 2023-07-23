<template>
    <div class="row">
        <div class="col-sm-3 col-6 border-right">
            <span class="text text-sm">{{ permission.name }}</span>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 col-6 border-right">
            <PermissionLevelDisplay :permission_prop="permission"></PermissionLevelDisplay>
        </div>
        <!-- /.col -->
        <div class="col-sm-3 col-6 border-right">
            <span class="text text-xs">{{ permission.guard_name }}</span>
        </div>
        <!-- /.col -->
        <div class="col-sm-2 col-6">
            <span class="text text-xs text-center">
                <a @click="editPermission(permission)" class="text text-success">
                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                </a>
            </span>
            <span class="text text-xs text-center">
                <a @click="deletePermission(permission)" class="text text-danger">
                    <i class="fa fa-trash" aria-hidden="true"></i>
                </a>
            </span>
        </div>

    </div>
    <!-- /.row -->
</template>

<script>
import PermissionBus from "./permissionBus";

export default {
    name: "permission-item",
    props: {
        permission_prop: {}
    },
    components: {
        PermissionLevelDisplay: () => import('../permissions/levelDisplay'),
    },
    mounted() {
        PermissionBus.$on('permission_updated', (updpermission) => {
            if (this.permission.id === updpermission.id) {
                this.permission = updpermission
            }
        })
    },
    data() {
        return {
            permission: this.permission_prop,
        };
    },
    methods: {
        editPermission(permission) {
            PermissionBus.$emit('permission_edit',permission);
        },
        deletePermission(permission) {
            this.$swal({
                title: 'Etes-vous sure ?',
                text: "Vous ne pourrez pas revenir en arrière !",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Oui, supprimer !',
                cancelButtonText: 'Annuler'
            }).then((result) => {
                if(result.value) {
                    axios.delete(`/permissions/${permission.id}`)
                        .then(resp => {
                            this.$swal({
                                html: '<small>Permission supprimé avec succès !</small>',
                                icon: 'success',
                                timer: 3000
                            }).then(() => {
                                this.$emit('permission_deleted', permission)
                            })
                        }).catch(error => {
                        window.handleErrors(error)
                    })
                }
            })
        },
    },
    computed: {}
}
</script>

<style scoped>

</style>
