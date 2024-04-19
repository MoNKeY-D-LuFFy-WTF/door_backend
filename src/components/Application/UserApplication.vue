<template>
    <div>
        <TableUserApplication :users="users" />
    </div>
</template>

<script>
import axios from 'axios';
import TableUserApplication from "../Application/TableUserApplication.vue"
export default {
    components: {
        TableUserApplication
    },
    data() {
        return {
            users: [],
        }
    },
    methods: {
        getUsers() {
            axios.get(`http://127.0.0.1:8000/api/user_clients`)
                .then(res => {
                    this.users = res.data
                });
        },
    },
    mounted() {
        this.getUsers();
    },
}
</script>

<style lang="scss" scoped></style>