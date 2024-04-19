<template>
    <div class="col-12">
        <div class="card strpied-tabled-with-hover">
            <div class="card-header">
                <h4 class="card-title">Сategories</h4>
                <p class="card-category d-flex align-items-center">
                    This is Сategories table
                    <button @click="action('Добавить')" class="btn btn-success ml-4 nc-icon nc-simple-add"></button>
                    <span v-if="Object.keys(data).length" class="ml-3 animated">
                        Сategory {{ data.name }} is <i class="alert alert-success ">OK</i>
                    </span>
                </p>
            </div>
            <div class="card-body table-full-width table-responsive">
                <table class="table table-hover table-striped table-sm">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>url</th>
                            <th>group-id</th>
                            <th class="justify-content-center">action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="category in categories" :key="category.id" v-if="category.id">
                            <td>{{ category.id }}</td>
                            <td><router-link class="text-primary" :to="`/admin/category/${category.id}`">{{
                                category.name
                                    }}</router-link> </td>
                            <td>{{ category.url }}</td>
                            <td>{{ category.catalog_id }}</td>
                            <td class="row justify-content-center">
                                <button @click="action('Изменить', category)"
                                    class="btn col-3 btn-warning mr-3 nc-icon nc-settings-90"></button>
                                <button @click="action('Удалить', category)"
                                    class="btn col-3 btn-danger nc-icon nc-simple-remove"></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div v-if="loading" ref="observer" class="observer"></div>
            </div>
        </div>
        <modal-delete @yesOrNo="yesOrNo" :item="deleted.title" v-if="deleted.modal" />
        <FormTableCategoryChild v-if="show" :data="renameData" :param="param" @returnData="returnData" />
    </div>
</template>

<script>
import axios from 'axios';
import FormTableCategoryChild from '../Forms/FormTableCategoryChild.vue';
export default {
    components: {
        FormTableCategoryChild
    },
    data() {
        return {
            categories: [],
            param: '',
            data: {},
            renameData: {},
            deleted: {
                modal: false,
                item: false,
                title: null,
            },
            show: false,
            limit: 10,
            page: -1,
            totalItems: 1,
            loading: true,
        }
    },
    methods: {
        getCtegoriesWithId() {
            this.loading = this.totalItems >= this.categories.length;
            if (this.loading) {
                axios.get(`http://127.0.0.1:8000/api/catalog_children/${this.$route.params.id}?page=${this.page}&limit=${this.limit}`)
                    .then(res => {
                        if (res.data[res.data.length - 1].counter) {
                            this.totalItems = res.data[res.data.length - 1].counter
                        }
                        if (!this.categories.length) {
                            this.categories = res.data;
                        } else {
                            this.categories.push(...res.data)
                        }
                        if (this.totalItems <= 9) {
                            this.loading = false;
                        }
                    })
            }
        },
        returnData(bool, data) {
            if (this.param === 'Изменить') {
                if (data !== undefined) {
                    for (let i = 0; i < this.categories.length; i++) {
                        if (this.categories[i].id === data.id) {
                            this.categories[i] = data;
                        }
                    }
                }

            } else if (data) {
                this.data = {};
                this.data = data
                this.categories.push(data);
                let counterInterval = 0;
                let intervel = setInterval(() => {
                    counterInterval++
                    if (counterInterval > 3) {
                        this.data = {};
                        clearInterval(intervel);
                    }
                }, 1000);
            }
            this.show = bool
        },
        action(param, data) {
            this.renameData = {};
            if (param === `Удалить`) {
                if (!this.deleted.item) {
                    this.deleted.modal = true;
                    this.deleted.title = data;
                } else {
                    axios.delete(`http://127.0.0.1:8000/api/catalog_children/${data.id}`)
                        .then(res => {
                            console.log(res);
                        })
                        .finally(fin => {
                            this.categories = this.categories.filter(group => group.id !== data.id);
                            this.deleted.item = null;
                        })
                }
            } else {
                if (param === `Изменить`) {
                    this.renameData = data;
                }
                this.param = param;
                this.show = true;
            }
        },
        yesOrNo(modalClosed, itemDeleted, item) {
            this.deleted.modal = modalClosed;
            this.deleted.item = itemDeleted;
            if (this.deleted.item) {
                this.action('Удалить', item);
            }
        }
    },
    mounted() {
        const options = {
            rootMargin: '0px',
            threshold: 1.0,
        }
        const callbeck = (enterias, observer) => {
            if (enterias[0].isIntersecting) {
                this.page++
                this.getCtegoriesWithId();
            }
        }
        const observer = new IntersectionObserver(callbeck, options);
        observer.observe(this.$refs.observer);
    },
}
</script>

<style lang="scss" scoped></style>