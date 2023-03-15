<template>
    <div class="row">
        <div class="col-sm-2 col-6 border-right">
            <span class="text text-sm d-inline-block text-truncate text-sm-left">{{ accessprotocole.id }}</span>
        </div>
        <!-- /.col -->
        <div class="col-sm-3 col-6 border-right">
            <span class="text text-sm d-inline-block text-truncate text-sm-left" style="max-width: 100%;">{{ accessprotocole.name }}</span>
        </div>
        <!-- /.col -->
        <div class="col-sm-2 col-6 border-right">
            <span class="text text-xs">{{ accessprotocole.description }}</span>
        </div>
        <!-- /.col -->
        <div class="col-sm-2 col-6">
            <span class="text text-xs text-center">
                <a @click="editAccessProtocole(accessprotocole)" class="text text-success">
                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                </a>
                <a type="button"  @click="deleteAccessProtocole(accessprotocole)" class="btn btn-tool text-danger">
                    <i class="fa fa-trash" aria-hidden="true"></i>
                </a>
            </span>
        </div>

    </div>
    <!-- /.row -->
</template>

<script>
import AccessProtocoleBus from "./accessprotocoleBus";

export default {
    name: "accessprotocole-item",

    props: {
        accessprotocole_prop: {}
    },

    components: {
    },
    mounted() {
        AccessProtocoleBus.$on('access_protocole_updated', (accessprotocole) => {
            if (this.accessprotocole.id === accessprotocole.id) {
                this.accessprotocole = accessprotocole
            }
        })
    },
    data() {
        return {
            accessprotocole: this.accessprotocole_prop,
        };
    },
    methods: {
        editAccessProtocole(accessprotocole) {
            console.log('access_protocole_edit on ITEM: ', accessprotocole)
            AccessProtocoleBus.$emit('access_protocole_edit', accessprotocole);
        },

        deleteAccessProtocole(accessprotocole) {

            this.$swal({
                title: '<small>Êtes vous sûr de vouloir supprimer ce protocole?</small>',
                text: "Cette procédure est irrévocable!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Oui, supprimez le!',
                cancelButtonText: 'Annuler',
            }).then((result) => {
                if (result.value) {

                    // eslint-disable-next-line no-undef
                    axios.delete(`/accessprotocoles/${accessprotocole.uuid}`)
                        // eslint-disable-next-line no-unused-vars
                        .then(resp => {
                            this.$swal({
                                html: '<small>Protocole supprimé avec succès</small>',
                                icon: 'success',
                                timer: 3000
                            }).then(() => {
                                this.$emit('accessprotocole_deleted', accessprotocole)
                            })
                        }).catch(error => {
                        window.handleErrors(error)
                    })

                }
            })
        },

    },
    computed: {
    }
}
</script>

<style scoped>

</style>
