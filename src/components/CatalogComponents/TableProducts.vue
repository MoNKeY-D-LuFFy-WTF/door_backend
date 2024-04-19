<template>
    <div class="row">
        <div v-if="data.length > 0" class="col-12">
            <div class="card strpied-tabled-with-hover">
                <div class="card-header">
                    <h4 class="card-title">Выберите товар</h4>
                </div>
                <div class="card-body table-full-width table-responsive">
                    <table class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Товар</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in data" :key="item.id">
                                <td class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <span><b>Имя:</b> {{ item.title }}</span> <br>
                                        <span><b>Цена:</b> {{ item.price }}</span>
                                    </div>
                                    <div>
                                        <span><img
                                                :src="`http://127.0.0.1:8000/api/images_catalog/${item.catalog_img_id}?title=${item.title}`"
                                                alt=""></span>
                                    </div>
                                </td>
                                <td>
                                    <button @click="deleteItem(item.id)" class="btn btn-danger"
                                        v-if="params === `Удалить`">Удалить</button>
                                    <button @click="refreshItem(item.id)" class="btn btn-primary"
                                        v-else-if="params === `Восстановить`">Восстановить</button>
                                    <button v-else @click="getIdPruduct(item.id)" class="btn btn-warning">
                                        Выбрать</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div v-else class="col-12">
            <div class="card strpied-tabled-with-hover">
                <div class="card-header">
                    <h4 class="card-title text-danger pb-3">У вас нет товара!</h4>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';
    export default {
        props: {
            data: {
                type: [Object, Array],
                require: true,
            },
            params: {
                type: String,
                require: false,
            }
        },
        methods: {
            getIdPruduct(id) {
                const fromScroll = document.querySelector(".from-scroll");
                fromScroll.scrollIntoView({ behavior: 'smooth' })
                this.$forceUpdate();
                return this.$emit("productId", id, true);
            },
            async deleteItem(id) {
                axios.delete(`http://127.0.0.1:8000/api/furnitures/${id}`)
                    .then(res => {
                        console.log(res);
                        return this.$emit('deleteItem', id);
                    });
            },
            async refreshItem(id) {
                axios.post(`http://127.0.0.1:8000/api/furnitures/trash/${id}`)
                    .then(res => {
                        console.log(res);
                        return this.$emit('deleteItem', id);
                    })
            }
        },
        mounted() {
        },
    }
</script>

<style scoped></style>