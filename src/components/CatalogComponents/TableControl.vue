<template>
    <div v-if="show">
        <div class="row">
            <div class="col-12">
                <div class="card strpied-tabled-with-hover">
                    <div class="card-header">
                        <h4 class="card-title">{{ data.name }} </h4>
                        <p class="card-category">Ваши действия<b class="text-dark"> УДАЛИТЬ ИЗМЕНИТЬ ДОБАВИТЬ ТОВАР</b>
                        </p>
                    </div>
                    <div class="card-body table-full-width table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>Добавить</th>
                                    <th>Изменить</th>
                                    <th>Удалить</th>
                                    <th>ВОССТАНОВИТЬ</th>
                                    <th>Путь</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="children in data.catalog_child">
                                    <td>
                                        <button @click="chekBtn(children.id, `create`)"
                                            class="btn btn-success w-100 nc-icon nc-simple-add"></button>
                                    </td>
                                    <td>
                                        <button @click="chekBtn(children.id, `update`)"
                                            class="btn btn-warning w-100 nc-icon nc-settings-90"></button>
                                    </td>
                                    <td>
                                        <button @click="chekBtn(children.id, `destroy`)"
                                            class="nc-icon nc-simple-remove btn btn-danger w-100"></button>
                                    </td>
                                    <td>
                                        <button @click="chekBtn(children.id, `refresh`)"
                                            class="btn btn-primary  w-100 nc-icon nc-cloud-upload-94"></button>
                                    </td>
                                    <td>{{ children.name }} <br> "{{ data.name }} -> {{ children.name }}"</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        show: {
            defualt: false,
            type: Boolean,
        },
        data: {
            type: [Object, Array],
            require: true,
        }
    },
    methods: {
        chekBtn(id, param) {
            return this.$emit('chekBtn', id, param);
        }
    },
}
</script>

<style scoped></style>