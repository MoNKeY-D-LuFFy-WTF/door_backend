<template>
    <div>
        <FormCreateDoor v-if="textTable === 'Создать'" :catalogChildId="catalogChildId" />
        <FormUpdateDoor v-else-if="textTable === 'Изменить'" :doorsCatalog="doorsCatalog"
            :catalogChildId="catalogChildId" />
        <TableDoors v-else-if="(textTable === 'Восстановить' || textTable === 'Удалить') && doorsCatalog.length"
            :doors="doorsCatalog" @productId="deleteAndReturn" :params="textTable" />
        <div v-else>
            <div class="alert alert-primary fs-3" v-if="!doorsCatalog.length">
                У вас нечего {{ textTable }}
            </div>
        </div>

    </div>
</template>

<script>
import axios from 'axios'
import FormCreateDoor from '@/components/FormCatalog/FormCreateDoor.vue';
import FormUpdateDoor from '../FormCatalog/FormUpdateDoor.vue';
import TableDoors from './TableDoors.vue';
export default {
    components: {
        FormCreateDoor,
        FormUpdateDoor,
        TableDoors
    },
    props: {
        catalogChildId: {
            type: Number,
            require: true,
        },
        textTable: {
            type: String,
            require: true,
        }
    },
    data() {
        return {
            doorsCatalog: [],
        }
    },
    methods: {
        getDoors() {
            if (this.textTable == `Восстановить`) {
                axios.get(`http://127.0.0.1:8000/api/doors/get/trash/${this.catalogChildId}`)
                    .then(res => {
                        this.doorsCatalog = res.data;
                    });
            } else {
                axios.get(`http://127.0.0.1:8000/api/doors/catalog_children/${this.catalogChildId}`)
                    .then(res => {
                        this.doorsCatalog = res.data;
                    });
            }

        },
        deleteAndReturn(productId) {
            this.doorsCatalog = this.doorsCatalog.filter(door => door.id !== productId);
        }
    },
    mounted() {
        this.getDoors();
    },
    watch: {
        catalogChildId() {
            if (this.textTable == `Восстановить`) {
                axios.get(`http://127.0.0.1:8000/api/doors/get/trash/${this.catalogChildId}`)
                    .then(res => {
                        this.doorsCatalog = res.data;
                    });
            } else {
                axios.get(`http://127.0.0.1:8000/api/doors/catalog_children/${this.catalogChildId}`)
                    .then(res => {
                        this.doorsCatalog = res.data;
                    });
            }
        },
        textTable() {
            if (this.textTable == `Восстановить`) {
                axios.get(`http://127.0.0.1:8000/api/doors/get/trash/${this.catalogChildId}`)
                    .then(res => {
                        this.doorsCatalog = res.data;
                    });
            } else {
                axios.get(`http://127.0.0.1:8000/api/doors/catalog_children/${this.catalogChildId}`)
                    .then(res => {
                        this.doorsCatalog = res.data;
                    });
            }
        }
    }
}
</script>

<style lang="scss" scoped></style>