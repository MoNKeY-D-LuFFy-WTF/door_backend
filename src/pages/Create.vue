<template>
    <div class="p-3 bg-light">
        <div class="mb-3">
            <label for="create" class="form-label">Создать</label>
            <select @change="showForms" class="form-control" name="create">
                <option value="banner">Баннер</option>
                <option value="pormation">Акция</option>
                <option selected value="catalog">Каталог</option>
            </select>
        </div>
        <FormBanner v-if="show === 'banner'"></FormBanner>
        <FormPromation v-if="show === 'pormation'"></FormPromation>
        <Catalog v-if="show === 'catalog'"></Catalog>
    </div>
</template>

<script>
import FormBanner from "@/components/Create/Banner.vue";
import FormPromation from "@/components/Create/Promation.vue";
import Catalog from "@/components/Create/Catalog.vue";

export default {
    components: {
        FormBanner,
        FormPromation,
        Catalog
    },
    data() {
        return {
            show: 'catalog',
        }
    },
    methods: {
        showForms(e) {
            if (e) {
                this.show = e.target.value
            }
        }
    },

}
</script>

<style lang="scss" scoped></style>