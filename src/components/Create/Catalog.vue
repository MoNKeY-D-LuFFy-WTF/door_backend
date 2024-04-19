<template>
    <div>
        <select @change=cahngeSelect class="form-control mb-3" name="catalog">
            <option value="yes">Уже есть</option>
            <option value="create">Создать</option>
        </select>
        <!-- http://127.0.0.1:8000/api/catalogs -->
        <CreateCatalog v-if="selectValue == `create`" />
        <AlredyCatalog v-else-if="selectValue == `yes`" />
    </div>
</template>

<script>
import CreateCatalog from '../CatalogComponents/CreateCatalog.vue';
import AlredyCatalog from '../CatalogComponents/AlredyCatalog.vue';
export default {
    components: {
        CreateCatalog,
        AlredyCatalog
    },
    data() {
        return {
            selectValue: ""
        }
    },
    methods: {
        cahngeSelect(e) {
            if (e == undefined) {
                this.selectValue = "yes";
            } else {
                this.selectValue = e.target.value
            }
        }
    },
    mounted() {
        this.cahngeSelect()
    },

}
</script>

<style scoped></style>