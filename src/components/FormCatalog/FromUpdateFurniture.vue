<template>
    <div>
        <TableProducts @productId="getProduct" :data="tableData" />
        <form class="from-scroll" ref="form" v-show="show.form" @submit.prevent="updateData(pruduct.id)"
            :action="`http://127.0.0.1:8000/api/furnitures/${pruduct.id}`" method="post" enctype="multipart/form-data">
            <input type="hidden" :value="catalogChildId" name="catalog_child_id">
            <div class="mb-3">
                <label for="image">Изображение</label>
                <input name="image" class="form-control mb-3" type="file">
            </div>
            <div class="mb-3">
                <label for="title">Загаловок</label>
                <input :value="pruduct.title" name="title" placeholder="Загаловок" class="form-control" type="text">
            </div>
            <div class="mb-3">
                <label for="title">Цена</label>
                <input :value="pruduct.price" name="price" placeholder="1999" class="form-control mb-3" type="number">
            </div>
            <button type="submit" class="btn btn-warning">Изменить</button>
        </form>
    </div>
</template>

<script>
import axios from 'axios';
import TableProducts from '../CatalogComponents/TableProducts.vue';
export default {
    components: {
        TableProducts
    },
    props: {
        catalogChildId: {
            type: Number,
            require: true,
        }
    },
    data() {
        return {
            tableData: [],
            pruduct: [],
            show: {
                form: false
            },
        }
    },
    methods: {
        getTableData() {
            axios.get(`http://127.0.0.1:8000/api/catalog_child/furniture/${this.catalogChildId}`)
                .then(res => {
                    this.tableData = res.data;
                })
        },
        getProduct(id, showForm) {
            axios.get(`http://127.0.0.1:8000/api/furnitures/${id}`).then(res => {
                this.pruduct = res.data
                console.log(res.data);
            })
            this.show.form = showForm;
        },
        async updateData(id) {
            this.show.form = false;
            let from = this.$refs.form;
            const formData = new FormData();
            formData.append('title', from[2].value);
            formData.append('price', from[3].value);
            formData.append('image', from[1].files[0]);
            try {
                const response = await axios.post(`http://127.0.0.1:8000/api/furnitures/${id}`, formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                });
                for (let i = 0; i < this.tableData.length; i++) {
                    this.tableData = this.tableData.filter(item => item.id !== response.data.id);
                    this.tableData.push(response.data);
                }
                console.log(response.data);
            } catch (error) {
                console.error('Ошибка:', error);
            }
        }
    },
    mounted() {
        this.getTableData();
    },
    watch: {
        catalogChildId() {
            this.getTableData();
        }
    }
}
</script>

<style lang="scss" scoped></style>