<template>
    <table v-if="data !== '' && data.length !== 0" class="table ">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">NAME</th>
                <th scope="col">PHONE</th>
                <th scope="col">E-MAIL</th>
                <th scope="col">TEXT</th>
                <th scope="col">ДЕЙСТВИЯ</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="( item, index ) in  data ">
                <th scope="row">{{ index }}</th>
                <td>{{ item.name }}</td>
                <td><a :href="`tel:${item.phone}`">{{ item.phone }}</a></td>
                <td><a :href="`mailto:${item.email} `">{{ item.email }}</a></td>
                <td>{{ item.text }}</td>
                <td title="Удалить" class="controls"><button @click="destroyItem(item.id)" class="btn btn-danger">x</button>
                </td>
            </tr>
        </tbody>
    </table>
    <div class="my-5" v-else>
        <h1>Нет заявок</h1>
    </div>
</template>

<script>
import axios from 'axios';
export default {
    data() {
        return {
            data: '',
        }
    },
    methods: {
        getDate() {
            axios.get(`http://127.0.0.1:8000/api/door_keys`)
                .then(res => {
                    this.data = res.data;
                });
        },
        destroyItem(id) {
            this.data = this.data.filter(item => item.id != id);
            axios.delete(`http://127.0.0.1:8000/api/door_keys/${id}`);
        }
    },
    mounted() {
        this.getDate();
    },
}
</script>

<style scoped>
.controls {
    text-align: end;
}
</style>