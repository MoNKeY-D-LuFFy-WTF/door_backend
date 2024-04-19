<template>
    <div>
        <FormCreateFurniture v-if="action === `Создать`" :catalogChildId="catalogChildId" />
        <FromUpdateFurniture v-else-if="action === `Изменить`" :catalogChildId="catalogChildId" />
        <TableProducts @deleteItem="deleteItem" :params="action" :data="deleteList" v-else-if="action === 'Удалить'" />
        <TableProducts @deleteItem="deleteItem" :params="action" :data="deleteList"
            v-else-if="action === 'Восстановить'" />
        <!-- http://127.0.0.1:8000/api/catalog_child/furniture/ -->
    </div>
</template>

<script>
import FormCreateFurniture from '@/components/FormCatalog/FormCreateFurniture.vue';
import FromUpdateFurniture from '@/components/FormCatalog/FromUpdateFurniture.vue';
import TableProducts from './TableProducts.vue';
import axios from 'axios';
export default {
    components: {
        FormCreateFurniture,
        FromUpdateFurniture,
        TableProducts
    },
    props: {
        catalogChildId: {
            type: Number,
            require: true,
        },
        action: {
            type: String,
            require: true,
        }
    },
    data() {
        return {
            deleteList: [],
        }
    },
    methods: {
        async getDeleteList(params) {
            if (params === 'Удалить') {
                axios.get(`http://127.0.0.1:8000/api/catalog_child/furniture/${this.catalogChildId}`)
                    .then(res => {
                        this.deleteList = res.data
                    })
            } else if (params === "Восстановить") {
                axios.get(`http://127.0.0.1:8000/api/catalog_child/furniture/trash/${this.catalogChildId}`)
                    .then(res => {
                        this.deleteList = res.data
                    })
            }
        },
        deleteItem(id) {
            this.deleteList = this.deleteList.filter(item => item.id !== id);
        },

    },
    mounted() {
        this.getDeleteList(this.action);
    },
    watch: {
        action(value) {
            this.getDeleteList(value);
            console.log(value);
        }
    }
}
</script>

<style lang="scss" scoped></style>