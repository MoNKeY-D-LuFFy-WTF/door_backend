<template>
    <div class="form-wrapper">
        <form @submit.prevent="formValide(param)" method="post" class="form-content">
            <button @click.prevent="returnData" class="btn btn-danger align-self-end">x</button>
            <h4>{{ param }}</h4>
            <div class="mb-3">
                <label for="NAME">Называние двери</label>
                <input v-model.trim="form.name" placeholder="NAME" class="form-control" type="text">
            </div>
            <div class="mb-3">
                <label for="URL">URL двери</label>
                <input v-model.trim="form.url" placeholder="/url" class="form-control" type="text">
            </div>
            <div class="mb-3">
                <label for="price">Цена двери</label>
                <input v-model.number="form.price" placeholder="1199" class="form-control" type="number">
            </div>
            <div class="mb-3">
                <label for="price">Скидка (необязательно )`20%`</label>
                <input v-model.number="form.discount" placeholder="20" class="form-control" type="number">
            </div>
            <div class="mb-3">
                <label for="door_status">Выберите статус товара</label>
                <select @change="changeStatusDoor" class="form-control" name="door_status" id="door_status">
                    <option selected disabled value="">Выберите статус товара</option>
                    <option :selected="data.door_statuse_id === status.id" :key="status.id"
                        v-for="status in materials.door_statuses" :value="status.id">
                        {{ status.name }}
                    </option>
                </select>
            </div>
            <div class="mb-3">
                <label for="">Материал покрытия</label>
                <div class="btn-group d-flex" role="group" data-bs-toggle="buttons">
                    <label v-for="material in materials.door_materials" :key="material.id" class="btn btn-primary">
                        <input type="checkbox" @change="cahgeMaterialsDoor($event, material)" :value="(material.id)"
                            class="me-2" :checked="form.materials.some(mat => mat.id == material.id)"
                            :name="`door_material_${material.id}`" autocomplete="off" />
                        {{ material.name }}
                    </label>
                </div>
                <div v-if="form.materials.length">
                    <label>
                        Выберите цвет
                    </label>
                    <div class="colors">
                        <div class="color" v-for="color in form.colors" :key="color.id">
                            <div class="color__title">
                                {{ color.name }}
                            </div>
                            <label>
                                <img class="w-75" :src="`http://127.0.0.1:8000/api/door_colors/${color.image}/image`"
                                    alt="">
                                <div>
                                    <input
                                        :checked="data.door_color !== undefined ? data.door_color.id == color.id : false"
                                        @click="changeRadio('color', color)" class="input-radio" name="door_color"
                                        :value="color.id" type="radio">
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label for="">Система открывания</label>
                <div class="btn-group d-flex " role="group" data-bs-toggle="buttons">
                    <label v-for="systemOpen in materials.door_opens" :key="systemOpen.id" class="btn btn-primary">
                        <input :checked="form.opens.some(op => op.id == systemOpen.id)"
                            @change="cahgeOpenDoors($event, systemOpen)" type="checkbox" class="me-2"
                            :value="systemOpen.id" :name="`door_system_open_${systemOpen.id}`" id=""
                            autocomplete="off" />
                        {{ systemOpen.name }}
                    </label>
                </div>
                <div v-if="show.opens.length" class="opens">
                    <label class="open" v-for="open in show.opens" :key="open.id" :for="open.id + open.name">
                        {{ open.name }} {{ open.price }}
                        <input :checked="data.combo !== undefined ? data.combo.open.id == open.id : false"
                            @change="changeRadio('open', $event)" :value="JSON.stringify(open)" type="radio" name="open"
                            :id="open.id + open.name">
                    </label>
                </div>
            </div>
            <div class="mb-3">
                <label for="">Толщина стены</label>
                <div class="btn-group d-flex" role="group" data-bs-toggle="buttons">
                    <label v-for="thick in materials.door_thicks" :key="thick.id" class="btn btn-primary">
                        <input :checked="form.thicks.some(th => th.id == thick.id)"
                            @change="changeThickDoor($event, thick)" type="checkbox" :value="thick.id" class="me-2"
                            :name="`door_thick_${thick.id}`" id="" autocomplete="off" />
                        {{ thick.name }}
                    </label>
                </div>
                <div v-if="show.thicks.length" class="opens">
                    <label class="open" v-for="thick in show.thicks" :key="thick.id" :for="thick.id + thick.name">
                        {{ thick.name }} {{ thick.price }}
                        <input :checked="data.combo !== undefined ? data.combo.thick.id == thick.id : false"
                            @change="changeRadio('thick', $event)" :value="JSON.stringify(thick)" type="radio"
                            name="thick" :id="thick.id + thick.name">
                    </label>
                </div>
            </div>
            <div class="mb-3">
                <label for="">Остекление</label>
                <div class="d-flex flex-column">
                    <label class="lable__radio">
                        Есть
                        <input :checked="data.window == 1" @change="changeRadio('window', $event)" value="yes"
                            name="window" type="radio">
                    </label>
                    <label class="lable__radio">
                        Нет
                        <input :checked="data.window == 0" @change="changeRadio('window', $event)" value="no"
                            name="window" type="radio">
                    </label>
                </div>
            </div>
            <div class="mb-3">
                <label for="">Звукоизоляция</label>
                <div class="d-flex flex-column">
                    <label class="lable__radio">
                        Есть
                        <input :checked="data.soung == 1" @change="changeRadio('soung', $event)" value="yes"
                            name="soung" type="radio">
                    </label>
                    <label class="lable__radio">
                        Нет
                        <input :checked="data.soung == 0" @change="changeRadio('soung', $event)" value="no" name="soung"
                            type="radio">
                    </label>
                </div>
            </div>
            <ul class="mb-3 alert alert-primary">
                <li class="ml-3">Называние двери <em>{{ form.name }}</em> </li>
                <li class="ml-3">Путь двери <em>{{ form.url }}</em> </li>
                <li class="ml-3">Цена двери <em>{{ form.price }}</em> руб. </li>
                <li class="ml-3" v-if="form.status">Статус двери <em>{{ form.status.name }} {{ form.status.price }}
                        руб.</em> </li>
                <li class="ml-3" v-if="form.discount">Скидка на дверь <em>{{ form.discount }}%</em> </li>
                <li class="ml-3">
                    Материал(ы) покрития двери
                    <ul>
                        <li v-for="material in form.materials" :key="material.id">
                            {{ material.name }} <span> <em>{{ material.price }}</em> руб.</span>
                        </li>
                    </ul>
                </li>
                <li class="ml-3">
                    Цвет покрытия двери
                    <em v-if="form.color">
                        {{ form.color.name }}
                        <span>{{ form.color.price }} руб.</span>
                    </em>
                </li>
                <li class="ml-3">
                    Система(ы) открывания двери
                    <ul>
                        <li v-for="open in form.opens" :key="open.id">
                            {{ open.name }} <span> <em>{{ open.price }}</em> руб.</span>
                        </li>
                    </ul>
                </li>
                <li class="ml-3">
                    Толщина(ы) стены открывания двери
                    <ul>
                        <li v-for="thick in form.thicks" :key="thick.id">
                            {{ thick.name }} <span> <em>{{ thick.price }}</em> руб.</span>
                        </li>
                    </ul>
                </li>

                <li class="ml-3">Остекление двери <em>{{ form.window === 'yes' ? 'Есть 600 руб.' : 'Нет' }}</em> </li>
                <li class="ml-3">Звукоизоляция двери <em>{{ form.soung === 'yes' ? 'Доступно 500 руб.' : 'Нет' }}</em>
                </li>
                <li v-if="show.totalPrice" class="ml-3 bg-dark p-3">
                    Цена по материалам <b>(по умолчанию)</b> КОМБО
                    <ul>
                        <li>Цена за полотно {{ form.price }} руб.</li>
                        <li v-if="form.material">
                            Цена за материала покрытия {{ form.material.name }}
                            <em>{{ form.material.price }}</em> руб.
                        </li>
                        <li v-if="form.status">
                            Цена за статус двери
                            {{ form.status.name }} <em>{{ form.status.price }}</em> руб.
                        </li>
                        <li v-if="form.color">
                            Цвет покрытия
                            {{ form.color.name }} <em>{{ form.color.price }}</em> руб.
                        </li>
                        <li v-if="form.open">
                            Цена за систему открывания
                            {{ form.open.name }} <em> {{ form.open.price }}</em> руб.</li>
                        <li v-if="form.thick">
                            Цена за толщину стены
                            {{ form.thick.name }} <em>{{ form.thick.price }}</em> руб.</li>
                        <li v-if="form.window">Цена за остекление {{ form.window === 'yes' ? '600' : '0' }} руб.</li>
                        <li v-if="form.soung">Цена за звукоизоляцию {{ form.soung === 'yes' ? '500' : '0' }} руб.</li>
                        <li v-if="form.discount">Скидка {{ form.discount }}%</li>
                        <div class="d-flex align-items-center">
                            <input v-model.number="form.total_price" class="form-control w-25 mr-3" type="number">
                            <button class="btn btn-primary" @click.prevent="сalculateTotalPrice(form.total_price)">
                                Комбо
                            </button>
                        </div>
                    </ul>
                </li>
            </ul>
            <ul v-if="errors.length" class="alert alert-danger">
                <li v-for="(error, index) in errors" :key="index" class="ml-3"><em>{{ error }}</em></li>
            </ul>
            <button type="submit" class="btn btn-primary align-self-end my-4">{{ param }}</button>
        </form>
    </div>
</template>

<script>
import axios from 'axios';
export default {
    props: {
        data: {
            type: Object,
            require: true,
        },
        materials: {
            type: [Array, Object],
            require: true,
        },
        param: {
            type: String,
            require: true,
        },
    },
    data() {
        return {
            form: {
                name: null,
                url: null,
                price: null,
                discount: "0",
                status: null,
                materials: [],
                material: null,
                colors: [],
                color: null,
                opens: [],
                open: null,
                thicks: [],
                thick: null,
                window: null,
                soung: null,
                price_discount: null,
                catalog_child_id: null,
                total_price: 0,
            },
            show: {
                opens: [],
                thicks: [],
                totalPrice: false,
            },
            combo: {
                showName: false,
                price: null,
            },
            response: {},
            errors: [],
        }
    },
    methods: {
        returnData() {
            this.errors = []
            this.$emit('returnData', false);
        },
        formValide(param) {
            this.errors = [];
            if (!this.form.name) {
                this.errors.push('Поле имя обязательно');
            }
            if (!this.form.url) {
                this.errors.push('Поле url обязательно');
            }
            if (!this.form.price) {
                this.errors.push('Поле Цена двери обязательно');
            }
            if (!this.form.status) {
                this.errors.push('Выберите статус двери');
            }
            if (!this.form.materials.length) {
                this.errors.push('Выберите материалы покрития двери');
            }
            if (!this.form.material) {
                this.errors.push('Выберите материал покрития двери');
            }
            if (!this.form.color) {
                this.errors.push('Выберите цвет покрития двери');
            }
            if (!this.form.opens.length) {
                this.errors.push('Выберите системы отркывания двери');
            }
            if (!this.form.open) {
                this.errors.push('Выберите систему отркывания двери');
            }
            if (!this.form.thicks.length) {
                this.errors.push('Выберите толщину двери');
            }
            if (!this.form.thick) {
                this.errors.push('Выберите толщину для комбинации двери');
            }
            if (this.form.window == null) {
                this.errors.push('Выберите остекления двери');
            }
            if (!this.form.soung == null) {
                this.errors.push('Выберите звукоизоляцию двери');
            }
            if (this.form.total_price == 0 || !this.form.total_price == null) {
                this.errors.push('Выберить цену для комбо дыери');
            }
            if (!this.errors.length) {
                if (param === 'Изменить') {
                    this.form.catalog_child_id = this.$route.params.id;
                    if (this.form.discount) {
                        this.form.price_discount = Math.round(this.form.price - (this.form.price * this.form.discount / 100));
                    }
                    axios.post(`http://127.0.0.1:8000/api/doors/${this.data.id}/update`,
                        {
                            form: this.form,
                        }
                    )
                        .then(res => {
                            this.response = res.data
                        })
                        .finally(fin => {

                            return this.$emit('returnData', false, this.response);
                        });
                } else {
                    axios.post(
                        'http://127.0.0.1:8000/api/doors',
                        {
                            form: this.form,
                        }
                    )
                        .then(res => {
                            this.response = res.data;
                        }).finally(fin => {
                            return this.$emit('returnData', false, this.response);
                        });


                }
            }

        },
        renameData() {
            if (Object.keys(this.data).length) {
                if (this.data.combo.id !== undefined) {
                    this.data.combo = JSON.parse(this.data.combo.combo);
                }
                this.form.name = this.data.name;
                this.form.url = this.data.url;
                this.form.price = this.data.price;
                this.form.discount = this.data.discount;
                this.form.status = this.data.door_statuse;
                this.data.door_materials.forEach(mat => this.form.materials.push(mat.material))
                this.data.door_materials.forEach(mat => this.form.colors.push(...mat.material.door_colors));
                this.form.color = this.data.door_color;
                this.form.material = this.data.door_materials.filter(mat => mat.door_material_id == this.data.door_color.door_material_id)[0].material;
                this.data.door_open_system.forEach(open => this.form.opens.push(open.open_system));
                this.data.door_open_system.forEach(open => this.show.opens.push(open.open_system));
                this.form.open = this.data.combo.open;
                this.data.door_thick.forEach(thick => this.form.thicks.push(thick.thick))
                this.data.door_thick.forEach(thick => this.show.thicks.push(thick.thick));

                this.form.thick = this.data.combo.thick;

                this.form.thick = this.data.combo.thick;
                this.form.window = this.data.window || 0;
                this.form.soung = this.data.soung || 0;
                this.form.price_discount = this.form.color.price + this.form.material.price + this.form.price + this.form.opens[0].price + this.form.status.price + this.form.thicks[0].price;
                if (this.form.soung) {
                    this.form.price_discount += 600;
                }
                if (this.form.window) {
                    this.form.price_discount += 500;
                }
                if (this.data.discount) {
                    this.form.price_discount = Math.round(this.form.price_discount - (this.form.price_discount * this.data.discount / 100));
                }
                if (this.data.combo) {
                    this.form.total_price = this.data.combo.total_price;
                }
                console.log(this.form);
                // price_discount: null,

            }
            this.form.catalog_child_id = this.$route.params.id;
        },
        cahgeMaterialsDoor(e, material) {

            if (e.target.checked) {
                this.form.materials.push(material);
                //Colors filtred
                this.form.colors = this.form.colors.filter(color => color.id !== color.id);
                this.form.materials.forEach(mat => {
                    this.materials.door_colors.forEach(color => {
                        if (mat.id === color.door_material_id) {
                            this.form.colors.push(color);
                        }
                    });
                });
            } else {
                this.form.materials = this.form.materials.filter(mat => mat.id !== material.id);
                this.form.colors = this.form.colors.filter(color => color.door_material_id !== material.id);
            }

        },
        cahgeOpenDoors(e, open) {
            if (e.target.checked) {
                this.form.opens.push(open);
                this.show.opens.push(open);
            } else {
                this.form.opens = this.form.opens.filter(op => op.id !== open.id);
                this.show.opens = this.show.opens.filter(op => op.id !== open.id);
            }

        },
        changeThickDoor(e, thick) {
            if (e.target.checked) {
                this.form.thicks.push(thick);
                this.show.thicks.push(thick);
            } else {
                this.form.thicks = this.form.thicks.filter(thi => thi.id !== thick.id);
                this.show.thicks = this.show.thicks.filter(thi => thi.id !== thick.id);
            }
        },
        changeStatusDoor(e) {
            this.form.status = this.materials.door_statuses.filter(status => status.id == e.target.value)[0];
        },
        changeRadio(param, e) {
            if (param == 'window') {
                this.form.window = e.target.value;
            } else if (param == 'soung') {
                this.form.soung = e.target.value;
            } else if (param == 'color') {
                this.form.color = e;
                this.form.material = this.form.materials.filter(mat => mat.id === this.form.color.door_material_id)[0]
            } else if (param == 'open') {
                const open = JSON.parse(e.target.value);
                this.form.open = open;
            } else if (param == 'thick') {
                const thick = JSON.parse(e.target.value);
                this.form.thick = thick;
            }
        },
        сalculateTotalPrice(price) {
            this.form.total_price = 0;
            let windowPrice = 0;
            let soungPrice = 0;
            if (this.form.window == 'yes') {
                windowPrice += 600;
            }
            if (this.form.soung == 'yes') {
                soungPrice += 500;
            }
            if (this.form.discount) {
                this.form.total_price = Math.round(this.form.price + this.form.status.price + this.form.material.price + this.form.color.price + this.form.open.price + this.form.thick.price + windowPrice + soungPrice);
                this.form.total_price = Math.round(this.form.total_price - (this.form.total_price * this.form.discount / 100));
                this.price_discount = this.form.total_price;
            } else {
                this.form.total_price = Math.round(this.form.price + this.form.status.price + this.form.material.price + this.form.color.price + this.form.open.price + this.form.thick.price + windowPrice + soungPrice);
            }
        }
    },
    mounted() {
        this.renameData();

    },
    watch: {
        form: {
            handler(newVal) {
                if (this.form.discount) {
                    this.form.price_discount = Math.round(this.form.price - (this.form.price * this.form.discount / 100));
                }
                let IsAllPrices = Object.values(this.form).every(item => item !== null);
                if (IsAllPrices) {
                    this.show.totalPrice = true;
                } else {
                    this.show.totalPrice = false;
                }

            },
            deep: true,
        },
    }
}
</script>

<style scoped>
.form-wrapper {
    display: flex;
    align-items: center;
    justify-content: center;
    position: fixed;
    background: #00000067;
    width: 100%;
    left: 0;
    top: 0;
    height: 100%;
    color: #fff;
    z-index: 5;
}

input {
    transition: 0.3s ease;
}

input:focus {
    box-shadow: 2px 3px 10px #fff;
}

input[type="radio"] {
    cursor: pointer;
}

form {
    overflow: auto;
    height: 90%;
}

.form-content {
    padding: 1rem 2rem;
    width: 100%;
    border-radius: 10px;
    display: flex;
    flex-direction: column;
    background: #000;
    margin: 0px 3rem 0px 3rem;
}

.colors {
    display: grid;
    grid-template: 1fr / repeat(8, 1fr);
    align-items: center;
    gap: 20px 10px;
    margin: 0px 0px 3rem 0px;
}

.color {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: space-between;
    text-align: center;
    height: 85px;
}

.color__title {
    font-size: 14px;
    margin: 0px 0px 10px 0px;
}

.lable__radio {
    display: flex;
    align-items: center;
    justify-content: space-between;
    border: solid 1px #ccc;
    padding: 0.5rem 1rem;
    cursor: pointer;
}

.opens {
    display: grid;
    grid-template: 1fr / repeat(6, 1fr);
    justify-content: center;
    gap: 20px 10px;
    margin: 0px 0px 1rem 0px;
}

.open {
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 5px;
    padding: 5px 10px;
    background: #007bff7c;
}
</style>