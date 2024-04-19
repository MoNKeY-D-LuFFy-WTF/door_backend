<template>
    <div>
        <div class="col-12">
            <div class="card strpied-tabled-with-hover">
                <div class="card-header">
                    <h4 class="card-title">Groups</h4>
                    <p class="card-category d-flex align-items-center">
                        This is groups table
                        <button @click="action('Добавить')" class="btn btn-success ml-4 nc-icon nc-simple-add"></button>
                        <span v-if="Object.keys(data).length" class="ml-3 animated">
                            Group {{ data.name }} is <i class="alert alert-success ">OK</i>
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
                                <th class="justify-content-center">action</th>
                            </tr>
                        </thead>
                        <tbody v-if="groups.length">
                            <tr v-for="group in groups" :key="group.id" v-if="group.id">
                                <td>{{ group.id }}</td>
                                <td><router-link class="text-primary text-underline"
                                        :to="`/admin/catalog_child/${group.id}`">{{
                                            group.name
                                        }}</router-link>
                                </td>
                                <td>{{ group.url }}</td>
                                <td class="row justify-content-center">
                                    <button @click="action('Изменить', group)"
                                        class="btn col-3 btn-warning mr-3 nc-icon nc-settings-90"></button>
                                    <button @click="action(`Удалить`, group)"
                                        class="btn col-3 btn-danger nc-icon nc-simple-remove"></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div v-if="loading" ref="observer" class="observer"></div>
                </div>
            </div>
        </div>
        <modal-delete @yesOrNo="yesOrNo" :item="deleted.title" v-if="deleted.modal" />
        <FormTableCatalog v-if="show" :data="renameData" :param="param" @returnData="returnData" />
    </div>

</template>

<script>
import axios from 'axios';
import FormTableCatalog from "../Forms/FormTableCatalog.vue";
export default {
    components: {
        FormTableCatalog
    },
    data() {
        return {
            groups: [],
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
        getGroupsData() {
            this.loading = this.totalItems >= this.groups.length;
            if (this.loading) {
                axios.get(`http://127.0.0.1:8000/api/catalogs?page=${this.page}&limit=${this.limit}`)
                    .then(res => {
                        if (res.data[res.data.length - 1].counter) {
                            this.totalItems = res.data[res.data.length - 1].counter
                        }
                        if (!this.groups.length) {
                            this.groups = res.data;
                        } else {
                            this.groups.push(...res.data)
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
                    for (let i = 0; i < this.groups.length; i++) {
                        if (this.groups[i].id === data.id) {
                            this.groups[i] = data;
                        }
                    }
                }
            } else if (data) {
                this.data = {};
                this.data = data
                this.groups.push(data);
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
                    axios.delete(`http://127.0.0.1:8000/api/catalogs/${data.id}`)
                        .then(res => {
                            console.log(res);
                        })
                        .finally(fin => {
                            this.groups = this.groups.filter(group => group.id !== data.id);
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
                this.getGroupsData();

            }

        }
        const observer = new IntersectionObserver(callbeck, options);
        observer.observe(this.$refs.observer);
    },
}
</script>

<style>
.observer {
    height: 40px;
    width: 100%;
    background: url('../../../assets/img/loading.gif') no-repeat center;
}
</style>