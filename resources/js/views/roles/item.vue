<template>
    <div class="row">
        <div class="col-sm-3 col-6 border-right">
            <span class="text text-sm">{{ role.name }}</span>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 col-6 border-right">
            <span class="text text-xs">{{ role.description }}</span>
        </div>
        <!-- /.col -->
        <div class="col-sm-3 col-6 border-right">
            <div v-for="permission in role.permissions" v-if="role.permissions" :key="permission.id">
                <PermissionDisplay :permission="permission"></PermissionDisplay>
            </div>
        </div>
        <!-- /.col -->
        <div class="col-sm-2 col-6">
            <span class="text text-xs text-center">
                <a @click="editRole(role)" class="text text-success">
                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                </a>
            </span>
            <span class="text text-xs text-center">
                <a @click="deleteRole(role)" class="text text-danger">
                    <i class="fa fa-trash" aria-hidden="true"></i>
                </a>
            </span>
        </div>

    </div>
    <!-- /.row -->
</template>

<script>
import RoleBus from "./roleBus";

export default {
    name: "role-item",
    props: {
        role_prop: {}
    },
    components: {
        PermissionDisplay: () => import('../permissions/display'),
    },
    mounted() {
        RoleBus.$on('role_updated', (role) => {
            if (this.role.id === role.id) {
                this.role = role
            }
        })
    },
    data() {
        return {
            role: this.role_prop,
        };
    },
    methods: {
        editRole(role) {
            RoleBus.$emit('role_edit',role);
        },
        deleteRole(role) {
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
                    axios.delete(`/roles/${role.id}`)
                        .then(resp => {
                            this.$swal({
                                html: '<small>Profile supprimé avec succès !</small>',
                                icon: 'success',
                                timer: 3000
                            }).then(() => {
                                this.$emit('role_deleted', role)
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
