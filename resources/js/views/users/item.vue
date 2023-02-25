<template>
    <div class="row">
        <div class="col-sm-3 col-6 border-right">
            <span class="text text-sm">{{ user.name }}</span>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 col-6 border-right">
            <span class="text text-xs">{{ user.email }}</span>
        </div>
        <!-- /.col -->
        <div class="col-sm-3 col-6 border-right">
            <div v-for="role in user.roles" v-if="user.roles" :key="role.id">
                <RoleDisplay :role_prop="role"></RoleDisplay>
            </div>
        </div>
        <!-- /.col -->
        <div class="col-sm-2 col-6">
            <span class="text text-xs text-center">
                <a @click="editUser(user)" class="text text-success">
                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
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
        },
        mounted() {
            UserBus.$on('user_updated', (user) => {
                if (this.user.id === user.id) {
                    this.user = user
                }
            })
        },
        data() {
            return {
                user: this.user_prop,
            };
        },
        methods: {
            editUser(user) {
                UserBus.$emit('user_edit',user);
            }
        },
        computed: {}
    }
</script>

<style scoped>

</style>
