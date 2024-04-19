<template>
    <div>
        <TableDoors @productId="getProductWithId" :doors="doorsCatalog" />
        {{ Object.keys(door).length }}
        <form v-if="Object.keys(door).length" @submit="updatedDoor"
            :action="`http://127.0.0.1:8000/api/doors/${door.id}/update`" method="post">
            <div class="mb-3">
                <label for="">Называние двери</label>
                <input class="form-control" v-model.trim="door.name" name="name" type="text">
            </div>
            <div class="mb-3">
                <label for="">Выберите статус товара</label>
                <select class="form-control" name="door_status" id="">
                    <option v-for="statuse in door.statuse_all" :key="statuse.id" :value="statuse.id"
                        :selected="statuse.id === door.door_statuse_id">
                        {{ statuse.name }}
                    </option>
                </select>
            </div>
            <div class="mb-3">
                <label for="">Материалы покрития</label>
                <div class="btn-group d-flex" role="group" data-bs-toggle="buttons">
                    <label v-for="material in door.door_material_all" class="btn btn-primary">
                        <input ref="doorMaterials" @click="getColorsDoor(material.id, $event, $refs.radioColors)"
                            type="checkbox"
                            :checked="door.door_materials.some(mat => mat.door_material_id === material.id)"
                            class="me-2" autocomplete="off" :name="`door_material_${material.id}`" :value="material.id">
                        {{ material.name }}
                    </label>
                </div>
                <div v-if="colors.length" class="my-3">
                    <label>
                        Выберите цвет
                    </label>
                    <div class="colors">
                        <div v-for="color in colors" class="color">
                            <div class="color__title">
                                {{ color.name }}
                            </div>
                            <div>
                                <img class="w-75" :src="`http://127.0.0.1:8000/api/door_colors/${color.image}/image`"
                                    alt="">
                            </div>
                            <div>
                                <input ref="radioColors" @click="radioChange('Цвет', color.price, $refs.radioColors)"
                                    :checked="door.door_color_id === color.id" :value="color.id" class="input-radio"
                                    name="door_color" type="radio">
                            </div>
                        </div>
                    </div>
                </div>
                <div v-else class="alert alert-danger">
                    Выберите Материалы покрития
                </div>
            </div>
            <div class="mb-3">
                <label for="">Остекления</label>
                <div class="form-control">
                    <input @change="radioChange('Остекление', 'yes')" :checked="door.window" class="mx-3" type="radio"
                        value="yes" name="window" id="" />
                    <label for="">Есть</label>
                </div>
                <div class="form-control">
                    <input :checked="!door.window" class="mx-3" type="radio" value="no" name="window" id="" />
                    <label for="">Нет</label>
                </div>
            </div>
            <div class="mb-3">
                <label for="">Система открывания</label>
                <div class="btn-group d-flex" role="group" data-bs-toggle="buttons">
                    <label v-for="open in door.door_opensystem_all" class="btn btn-primary">
                        <input type="checkbox" ref="openSystem" @click="changeInputs(`openSystem`, $refs.openSystem)"
                            :checked="door.door_open_system.some(op => op.door_open_system_id === open.id)" class="me-2"
                            autocomplete="off" :name="`door_system_open_${open.id}`" :value="open.id" />
                        {{ open.name }}
                    </label>
                </div>
            </div>
            <div class="mb-3">
                <label for="">Толщина стены</label>
                <div class="btn-group d-flex" role="group" data-bs-toggle="buttons">
                    <label v-for="thick in door.door_thick_all" class="btn btn-primary">
                        <input ref="doorThick" @click="changeInputs(`doorThick`, $refs.doorThick)" type="checkbox"
                            :checked="door.door_thick.some(thi => thi.door_thick_id === thick.id)" class="me-2"
                            autocomplete="off" :name="`door_thick_${thick.id}`" :value="thick.id" />
                        {{ thick.name }}
                    </label>
                </div>
            </div>
            <div class=" mb-3">
                <label for="">Звукоизоляция</label>
                <div class="form-control">
                    <input :checked="door.soung" class="mx-3" type="radio" value="yes" name="soung" id="" />
                    <label for="">Есть</label>
                </div>
                <div class="form-control">
                    <input :checked="!door.soung" class="mx-3" type="radio" value="no" name="soung" id="" />
                    <label for="">Нет</label>
                </div>
            </div>
            <div class="mb-3">
                <label for="">Скидка в проценте (20)%</label>
                <input v-model.number="door.discount" placeholder="20" name="discount" class="form-control"
                    type="number">
            </div>
            <div class="prise">
                Цена {{ door.price }} р. <br>
                Цена со скидкой {{ door.price_discount }} р.
            </div>
            <ul v-if="errors.length" class="alert alert-danger">
                <li class="ml-3" v-for="error in errors"><em>{{ error }}</em></li>
            </ul>
            <input type="hidden" :value="door.price" name="price">
            <input type="hidden" :value="door.price_discount" name="price_discount">
            <input type="hidden" :value="catalogChildId" name="catalog_child_id">
            <input type="hidden" :value="input.url" name="url">
            <button type="submit" class="btn btn-warning">Изменить</button>
        </form>
    </div>
</template>

<script>
import axios from "axios";
import TableDoors from '@/components/CatalogComponents/TableDoors.vue'
export default {
    components: {
        TableDoors
    },
    props: {
        doorsCatalog: {
            type: [Array, Object],
            require: true,
        },
        catalogChildId: {
            type: [Number, String],
            require: true,
        }
    },
    data() {
        return {
            door: {},
            colors: [],
            input: {
                url: '',
            },
            form: {
                status: 1,
                color: null,
                material: 1,
                open: null,
                thick: 1,
            },
            errors: [],
        }
    },
    methods: {
        getProductWithId(id) {
            axios.get(`http://127.0.0.1:8000/api/doors/${id}`)
                .then(res => {
                    this.door = { ...res.data[0] }
                    this.colors = [];
                    console.log(this.door);
                    this.door.door_materials.forEach(element => {
                        this.colors.push(...element.material.door_colors);
                    });
                })

            console.log(id)
        },
        async getColorsDoor(id, e, elements) {
            const doorMaterials = this.$refs.doorMaterials;
            let checkeds = doorMaterials.some(material => material.checked);
            if (checkeds) {
                this.form.material = e.target.value;
            } else {
                this.form.material = null;
            }
            if (e.target.checked) {
                await axios.get(`http://127.0.0.1:8000/api/door_materials/${id}/colors`)
                    .then(res => {
                        if (this.colors.length !== 0) {
                            this.colors.push(...res.data);
                        } else {
                            this.colors = res.data;
                        }
                    })
            } else {
                this.colors = this.colors.filter(item => item.door_material_id !== id);
            }
            if (elements) {
                let result = elements.some(element => element.checked);
                if (result) {
                    this.form.color = 1;
                } else {
                    this.form.color = null;
                }
            }

        },
        radioChange(param, value, elements) {
            if (param === `Цвет`) {
                this.door.price = value;
                this.door.price_discount = value - (value * this.door.discount / 100)
                if (elements) {
                    let result = elements.some(element => element.checked);
                    this.form.color = result
                }
            }
        },
        updatedDoor(e) {
            this.errors = [];
            if (!this.door.name) {
                this.errors.push('Поля Называние двери не заполнено');
            }
            if (!this.form.status) {
                this.errors.push('Выберите статус двери');
            }
            if (!this.door.door_materials.length) {
                if (!this.form.material) {
                    this.errors.push('Выберите материал покрытия двери');

                }
            } else {
                if (this.form.material && !this.colors.length) {
                    this.errors.push('Выберите материал покрытия двери');
                }
            }
            if (!this.colors.length) {
                this.errors.push('Выберите Цвет материал покрытия двери');
            } else {
                if (!this.form.color && !this.colors.length) {
                    this.errors.push('Выберите Цвет материал покрытия двери');
                }
            }

            if (!this.door.discount) {
                this.errors.push('Поля Скидка не заполнено');
            }
            if (!this.door.door_open_system.length) {
                if (!this.form.open) {
                    this.errors.push('Выберите Система открывания для двери');
                } else if (!this.door.door_open_system.length && !this.form.open) {
                    this.errors.push('Выберите Система открывания для двери');
                }
            }
            if (!this.form.thick) {
                this.errors.push('Выберите толщину стены для двери');
            }
            if (!this.errors.length) {
                return
            }
            e.preventDefault();
        },
        changeInputs(param, elements) {
            let result = null;
            if (param === 'openSystem') {
                result = elements.some(open => open.checked);
                console.log(result);
                if (result) {
                    this.form.open = param;
                } else {
                    this.form.open = null;
                }
            }
            if (param === 'doorThick') {
                result = elements.some(open => open.checked);
                console.log(result);
                if (result) {
                    this.form.thick = param;
                } else {
                    this.form.thick = null;
                }
            }
            if (param === 'radio') {
                this.form.soung = 1;
            }
        },
        translateTextUrl(text) {
            const en = [
                'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm',
                'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', " "
            ];
            const ru = [
                "а", "б", "", "д", "е", "ф", "г", "х", "и", "ж", "к", "л", "м", "н", "о",
                "п", "", "р", "с", "т", "у", "в", "", "х", "з", "_"
            ]
            let translate = '/';
            const userText = text.toLowerCase().split("");
            for (let i = 0; i < userText.length; i++) {
                for (let a = 0; a < ru.length; a++) {
                    if (userText[i] === ru[a]) {
                        translate += en[a]
                    }
                    if (userText[i] === " " || userText[i] === "_" || userText[i] === "-") {
                        translate += "_"
                        break
                    }
                    if (userText[i] === "ы") {
                        translate += "i"
                        break
                    }
                }
            }
            return translate;
        },
    },
    watch: {
        "door.name": function (newValue) {
            this.input.url = this.translateTextUrl(newValue);

        },
        "door.discount": function (newValue, oldValue) {
            this.door.price_discount = Math.floor(Number(this.door.price) - (Number(this.door.price) * this.door.discount / 100));
        }
    }
}
</script>

<style scoped>
input[type="radio"] {
    cursor: pointer;
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
}

.prise {
    width: 300px;
    position: fixed;
    top: 80%;
    left: 95%;
    font-size: 22px;
    background: #3472F7;
    color: #fff;
    font-weight: 800;
    padding: 0.3rem 1rem;
    transition: all ease 0.3s;
}

.prise:hover {
    left: 77%;
}
</style>