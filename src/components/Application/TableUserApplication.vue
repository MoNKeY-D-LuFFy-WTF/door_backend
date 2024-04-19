<template>
    <div class="col-12">
        <div class="card strpied-tabled-with-hover">
            <div class="card-header">
                <h4 class="card-title">Заявки на получение дверей</h4>
            </div>
            <div class="card-body table-full-width table-responsive">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Goods</th>
                            <th>Цена</th>
                        </tr>

                    </thead>
                    <tbody>
                        <tr v-for="user in users">
                            <td>{{ user.id }}</td>
                            <td>{{ user.name }}</td>
                            <td>{{ user.email }}</td>
                            <td>{{ user.phone }}</td>
                            <td>
                                <div class="d-flex align-items-center justify-content-around my-3"
                                    v-for="good in user.clinet_goods">
                                    <div class="product-text">
                                        <div>
                                            Полотно: <b> {{ good.name }} <em>{{ good.price_discount || good.price }}
                                                    руб.</em></b>
                                        </div>
                                        <div>
                                            Материал покрытия: <b> {{ good.material.name }} <em>{{ good.material.price
                                                    }} руб.</em></b>
                                        </div>
                                        <div>
                                            Цвет: <b>{{ good.color.name }} <em>{{ good.color.price }}руб.</em></b>
                                        </div>
                                        <div>
                                            Толшина стены: <b> {{ good.thick.name }} <em>{{ good.thick.price }}
                                                    руб.</em></b>
                                        </div>
                                        <div>
                                            Система открывания: <b> {{ good.open_system.name }}<em>{{
                            good.open_system.price }} руб.</em></b>
                                        </div>
                                        <div>
                                            Цена за состав: <b>{{ good.price_comp_discount || good.price_comp }}</b>
                                        </div>
                                        <div>
                                            Обшая цена: <b> {{ good.price_mobile_discount || good.price_mobile }}</b>
                                        </div>
                                        <div>
                                            Количество: <b> {{ good.quantity }}</b>
                                        </div>
                                        <div>
                                            Остекление: <b> {{ good.window == 1 ? 'Со стеклом 500 руб.' : 'Без стекла 0 руб.' }}</b>
                                        </div>
                                        <div>
                                            Статус: <b> {{ good.door_statuse_id }}</b>
                                        </div>
                                        <div>
                                            Звукоизоляция: <b> {{ good.soung == 1 ? 'Со звукоизоляцией 600 руб.' : 'Без звукоизоляции 0 руб.' }}</b>
                                        </div>
                                    </div>
                                    <div class="w-25">
                                        <img class="w-100"
                                            :src="`http://127.0.0.1:8000/api/images_catalog/${good.color.catalog_img_id}?title=${good.color.name}`"
                                            alt="">
                                    </div>
                                </div>

                            </td>
                            <td class="d-flex flex-column">
                                <div>
                                    <div>
                                        Цена: <b>{{ user.total_price }}</b>
                                    </div>
                                    <div>
                                        Цена со скидкой: <b> {{ user.total_price_discount ||  user.total_price}}</b>
                                    </div>
                                </div>
                                <div>
                                    <button class="btn btn-info my-3">Получено</button>
                                </div>
                                <div>
                                    Кол-во товаров: <b> {{ user.clinet_goods.length }} шт.</b>

                                </div>
                            </td>

                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        users: {
            type: [Object, Array],
            require: true,
        }
    }
}
</script>

<style scoped>
.product-text {
    font-size: 12px;
    margin: 0px 10px 0px 0px;
    text-align: center;
}
</style>