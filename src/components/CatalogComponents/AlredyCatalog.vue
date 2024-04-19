<template>
    <div>
        <h2>Выберите каталог</h2>
        <select @change="cahngeSelect" class="form-control mb-3" name="select">
            <option selected disabled class="text-success" value="">Выберите из списка</option>
            <option v-for="item in response" :value="item.id">
                {{ item.name }}
            </option>
        </select>
        <TableControl @chekBtn="chekBtn" :data="valueTable" :show="show.table" />
        {{ text.table }}
        <select v-if="text.table.length !== 0" @change="changeSelectAction" class="form-control mb-3" name="select">
            <option value="door">Дверь</option>
            <option value="furniture">Фурнитура для дверей</option>
        </select>
        <Door :textTable="text.table" :catalogChildId="mobileValue.idChild"
            v-if="show.product === `door` && text.table.length !== 0" />
        <Furniture :action="text.table" :catalogChildId="mobileValue.idChild"
            v-else-if="show.product === `furniture` && text.table.length !== 0" />
    </div>
</template>

<script>
import axios from "axios";
import TableControl from "@/components/CatalogComponents/TableControl.vue";
import Door from "@/components/CatalogComponents/Door.vue";
import Furniture from "@/components/CatalogComponents/Furniture.vue";
export default {
    components: {
        TableControl,
        Door,
        Furniture
    },
    data() {
        return {
            response: "",
            valueSelect: "",
            valueTable: [],
            mobileValue: {
                inputFilter: "",
                idChild: 0,

            },
            children: [],
            show: {
                table: false,
                catalogIntup: false,
                product: "door",
            },
            text: {
                table: "",
            }
        }
    },
    methods: {
        async getCatalog() {
            axios.get("http://127.0.0.1:8000/api/catalogs").then(res => {
                this.response = res.data;
            })
        },
        cahngeSelect(e) {
            this.valueSelect = e.target.value;
            this.mobileValue.inputFilter = this.response.filter(item => item.id == this.valueSelect)[0]
            this.children = this.mobileValue.inputFilter.catalog_child;
            this.show.catalogIntup = true;
            this.show.table = true
            this.valueTable = this.mobileValue.inputFilter;

        },
        chekBtn(id, param) {
            this.mobileValue.idChild = id;
            if (param === "create") {
                this.text.table = "Создать"
            } else if (param === "update") {
                this.text.table = "Изменить"
            } else if (param === "refresh") {
                this.text.table = "Восстановить"
            } else {
                this.text.table = "Удалить"
            }
        },
        changeSelectAction(e) {
            this.show.product = e.target.value;
        },

    },
    mounted() {
        this.getCatalog();
    },

}
</script>

<style scoped></style>