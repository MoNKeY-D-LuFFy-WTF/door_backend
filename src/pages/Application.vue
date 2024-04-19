<template>
    <div class="bg-white container">
        <select @change="cahngeSelect" class="form-control">
            <option selected value="instalment">Купить в рассрочку</option>
            <option value="joinus">Заказать звонок</option>
            <option value="door_key">Заказать дверь «под ключ»</option>
            <option value="frozen">Вызов замерщика</option>
            <option value="order_installation">Заказ монтажа</option>
            <option value="user_aplication">Заявки на покупку</option>
        </select>
        <div>
            <Instalment v-if="select === 'instalment'" />
            <JoinUs v-else-if="select === 'joinus'" />
            <Frozen v-else-if="select === 'frozen'" />
            <DoorKey v-else-if="select === `door_key`" />
            <OrderInstallation v-else-if="select === `order_installation`" />
            <UserApplication v-else-if="select === `user_aplication`" />
        </div>
    </div>
</template>

<script>
import Instalment from '@/components/Application/Instalment.vue'
import JoinUs from '@/components/Application/JoinUs.vue'
import Frozen from '@/components/Application/Frozen.vue'
import DoorKey from '@/components/Application/DoorKey.vue'
import OrderInstallation from '@/components/Application/OrderInstallation.vue'
import UserApplication from '@/components/Application/UserApplication.vue'

export default {
    components: {
        JoinUs,
        Frozen,
        DoorKey,
        Instalment,
        OrderInstallation,
        UserApplication
    },
    data() {
        return {
            select: ''
        }
    },
    methods: {
        cahngeSelect(e) {
            this.select = e.target.value;
        }
    },
    mounted() {
        this.select = "instalment";
    },
}
</script>

<style scoped></style>