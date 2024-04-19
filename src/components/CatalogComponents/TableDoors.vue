<template>
    <div class="row">
        <div class="col-12">
            <div class="card strpied-tabled-with-hover"><!---->
                <div class="card-header">
                    <h4 class="card-title">Выберить Дверь</h4>
                    <h4 v-if="response" class="card-category alert alert-success text-light">
                        {{ response }}
                    </h4>
                </div>
                <div class="card-body table-full-width table-responsive">
                    <table class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>ИМЯ</th>
                                <th>Цена</th>
                                <th>Статус</th>
                                <th>Мат-покрытия</th>
                                <th>Фото</th>
                                <th>Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="door in doors" :key="door.id">
                                <td>{{ door.id }}</td>
                                <td>{{ door.name }}</td>
                                <td>{{ door.price }} руб.</td>
                                <td>{{ door.door_statuse.name }}</td>
                                <td class="d-felx flex-column">
                                    <div v-for="material in  door.door_materials">
                                        {{ material.material.name }}
                                    </div>
                                </td>
                                <td>
                                    <img class="w-50"
                                        :src="`http://127.0.0.1:8000/api/images_catalog/${door.door_color.catalog_img_id}?title=${door.door_color.name}`"
                                        alt="">
                                </td>
                                <td>
                                    <button v-if="!params" @click="emitValue(door.id)"
                                        class="btn btn-warning">Изменить</button>
                                    <button @click="deleteDoor(door.id)" v-if="params === `Удалить`"
                                        class="btn btn-danger">Удалить</button>
                                    <button @click="returnDoor(door.id)" v-if="params === `Восстановить`"
                                        class="btn btn-primary">Восстановить</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    props: {
        doors: {
            type: [Array, Object],
            require: true,
        },
        params: {
            type: String,
            require: false,
        }
    },
    data() {
        return {
            response: null,
        }
    },
    methods: {
        emitValue(productId) {
            const form = document.querySelector('form[method="post"]');
            if (form) {
                form.scrollIntoView({ behavior: 'smooth' });
            }
            return this.$emit('productId', productId);
        },
        deleteDoor(productId) {

            axios.delete(
                `http://127.0.0.1:8000/api/doors/${productId}`,
            )
                .then(res => {
                    this.response = null;
                    this.response = res.data;

                })
                .catch(err => {
                    console.log(err);
                })
                .finally(fin => {
                    return this.$emit('productId', productId);
                })
        },
        returnDoor(productId) {

            axios.post(
                `http://127.0.0.1:8000/api/doors/get/trash/${productId}`,
            )
                .then(res => {
                    this.response = null;
                    console.log(res);
                    this.response = res.data;
                })
                .catch(err => {
                    console.log(err);
                })
                .finally(fin => {
                    return this.$emit('productId', productId);
                })
        }
    },
}
</script>

<style scoped></style>