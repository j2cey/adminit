<template>
    <div class="row">
        <div class="col-sm-3 col-6 border-right">
            <span class="text text-sm">{{ user.name }}</span>
        </div>
        <!-- /.col -->
        <div class="col-sm-3 col-6 border-right">
            <span class="text text-xs">{{ user.email }}</span>
        </div>
        <!-- /.col -->
        <div class="col-sm-2 col-6 border-right">
            <div v-for="role in user.roles" v-if="user.roles" :key="role.id">
                <RoleDisplay :role_prop="role"></RoleDisplay>
            </div>
        </div>
        <div class="col-sm-2 col-6 border-right">
            <StatusDisplay :model_type_prop="user.model_type" :model_id_prop="user.id" :status_prop="user.status" v-if="user.status" :key="user.id"></StatusDisplay>
        </div>
        <!-- /.col -->
        <div class="col-sm-2 col-6">
            <span class="text text-xs text-center">
                <a @click="editUser(user)" class="text text-success">
                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                </a>
            </span>
            <span class="text text-xs text-center">
                <a @click="deleteUser(user)" class="text text-danger">
                    <i class="fa fa-trash" aria-hidden="true"></i>
                </a>
            </span>
        </div>

    </div>
    <!-- /.row -->
</template>

<script>
import UserBus from "./userBus";

export default {
    name: "user-item",
    props: {
        user_prop: {}
    },
    components: {
        RoleDisplay: () => import('../roles/display'),
        StatusDisplay: () => import('../statuses/inline-display'),
    },
    mounted() {
        UserBus.$on('user_updated', (user) => {
            if (this.user.id === user.id) {
                this.user = user
            }
        })
    },
    created() {
        axios.get('/users.fetchone/' + this.user_prop.id)
            .then(({data}) => this.user = data);
    },
    data() {
        return {
            user: this.user_prop,
        };
    },
    methods: {
        editUser(user) {
            UserBus.$emit('user_edit',user);
        },
        deleteUser(user) {
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
                    axios.delete(`/users/${user.id}`)
                        .then(resp => {
                            this.$swal({
                                html: '<small>Utilisateur supprimé avec succès !</small>',
                                icon: 'success',
                                timer: 3000
                            }).then(() => {
                                this.$emit('user_deleted', user)
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
