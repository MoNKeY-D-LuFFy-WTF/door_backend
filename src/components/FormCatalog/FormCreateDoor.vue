<template>
    <form @submit="createDoor" action="http://127.0.0.1:8000/api/doors" method="post">
        <div class="mb-3">
            <label for="">Называние двери</label>
            <input v-model.trim="form.name" name="name" class="form-control mb-3" placeholder="Дверь что то там"
                type="text">
        </div>
        <div class="mb-3">
            <label for="">Выберите статус товара</label>
            <select @change="form.status = $event.target.value" class="form-control" name="door_status" id="">
                <option v-for="status in door.status" :key="status.id" :value="status.id">{{ status.name }}</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="">Материал покрытия</label>
            <div class="btn-group d-flex" role="group" data-bs-toggle="buttons">
                <label v-for="material in door.material" :key="material.id" class="btn btn-primary">
                    <input ref="doorMaterials" @click="getColorsDoor(material.id, $event)" type="checkbox"
                        :value="(material.id)" class="me-2" :name="`door_material_${material.id}`" autocomplete="off" />
                    {{ material.name }}
                </label>
            </div>
            <div v-if="door.colors.length !== 0" class="my-3">
                <label>
                    Выберите цвет
                </label>
                <div class="colors">
                    <div class="color" v-for="color in door.colors">
                        <div class="color__title">
                            {{ color.name }}
                        </div>
                        <div>
                            <img class="w-75" :src="`http://127.0.0.1:8000/api/door_colors/${color.image}/image`"
                                alt="">
                        </div>
                        <div>
                            <input @click="radioChange('Цвет', color.price)" class="input-radio" name="door_color"
                                :value="color.id" type="radio">
                        </div>
                    </div>
                </div>
            </div>
            <div v-else class="bg-danger py-2 px-3">
                <span class="text-light">Выберите Материал покрытия</span>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-check-label" for="">Остекление</label>
            <div class="form-control">
                <input @change="radioChange('Остекление', 'yes')" class="mx-3" type="radio" value="yes" name="window"
                    id="" />
                <label for="">Есть</label>
            </div>
            <div class="form-control">
                <input @change="radioChange('Остекление', 'no')" class="mx-3" type="radio" value="no" name="window"
                    id="" />
                <label for="">Нет</label>
            </div>
        </div>
        <div class="mb-3">
            <label for="">Система открывания</label>
            <div class="btn-group d-flex" role="group" data-bs-toggle="buttons">
                <label v-for="systemOpen in door.systemOpen" :key="systemOpen.id" class="btn btn-primary">
                    <input ref="openSystems" @click="changeInputs('openSystem', $refs.openSystems)" type="checkbox"
                        class="me-2" :value="systemOpen.id" :name="`door_system_open_${systemOpen.id}`" id=""
                        autocomplete="off" />
                    {{ systemOpen.name }}
                </label>
            </div>
        </div>
        <div class="mb-3">
            <label for="">Толщина стены</label>
            <div class="btn-group d-flex" role="group" data-bs-toggle="buttons">
                <label v-for="thick in door.thick" :key="thick.id" class="btn btn-primary">
                    <input ref="doorThicks" @click="changeInputs('doorThick', $refs.doorThicks)" type="checkbox"
                        :value="thick.id" class="me-2" :name="`door_thick_${thick.id}`" id="" autocomplete="off" />
                    {{ thick.name }}
                </label>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-check-label" for="">Звукоизоляция</label>
            <div class="form-control">
                <input @click="changeInputs('radio', '')" class="mx-3" type="radio" name="soung" value="yes" id="" />
                <label for="">Есть</label>
            </div>
            <div class="form-control">
                <input @click="changeInputs('radio', '')" class="mx-3" type="radio" name="soung" value="no" id="" />
                <label for="">Нет</label>
            </div>
        </div>
        <div class="mb-3">
            <label for="">Скидка в проценте (20)%</label>
            <input v-model.number="form.discount" @change="changePrecent" name="discount" class="form-control mb-3"
                placeholder="20" type="number">
        </div>
        <div class="prise">
            Цена {{ door.price }} р. <br>
            Цена со скидкой {{ door.priceDiscount }} р.
        </div>
        <input type="hidden" :value="door.price" name="price">
        <input type="hidden" :value="door.priceDiscount" name="price_discount">
        <input type="hidden" :value="catalogChildId" name="catalog_child_id">
        <input type="hidden" :value="input.url" name="url">
        <ul v-if="errors.length" class="alert alert-danger">
            <li class='text-light fw-bold  ml-3' v-for="error in errors">
                <em>{{ error }}</em>
            </li>
        </ul>
        <button type="submit" class="btn btn-success">Создать</button>
    </form>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            door: {
                status: [],
                material: [],
                colors: [],
                systemOpen: [],
                thick: [],
                price: 0,
                priceDiscount: 0
            },
            input: {
                precent: 0,
                url: '',
            },
            quan: 0,
            form: {
                name: null,
                status: 1,
                material: null,
                color: null,
                window: null,
                open: null,
                thick: null,
                soung: null,
                discount: null
            },
            errors: [],
        }
    },
    props: {
        catalogChildId: {
            type: Number,
            require: true,
        }
    },
    methods: {
        async getStatusData() {
            axios.get("http://127.0.0.1:8000/api/door_status")
                .then(res => {
                    this.door.status = res.data;
                })
        },
        async getMatrialData() {
            axios.get("http://127.0.0.1:8000/api/door_materials")
                .then(res => {
                    this.door.material = res.data;
                })
        },
        async getColorsDoor(id, e) {
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
                        if (this.door.colors.length !== 0) {
                            this.door.colors.push(...res.data);
                        } else {
                            this.door.colors = res.data;
                        }
                    })
            } else {
                this.door.colors = this.door.colors.filter(item => item.door_material_id !== id);
            }
        },
        async getSystemOpenDoor() {
            axios.get('http://127.0.0.1:8000/api/door_open_systems')
                .then(res => {
                    this.door.systemOpen = res.data;
                })
        },
        async getThickDoor() {
            axios.get("http://127.0.0.1:8000/api/door_thicks")
                .then(res => {
                    this.door.thick = res.data;
                })
        },
        createDoor(e) {
            this.input.url = this.translateTextUrl(e.target[0].value);
            this.errors = []
            if (!this.form.name) {
                this.errors.push('Поле Называние двери не заполнино');
            }
            if (!this.form.status) {
                this.errors.push('Выберите статус двери');
            }
            if (!this.form.material) {
                this.errors.push('Выберите материал покрытия двери');
            }
            if (!this.form.color) {
                this.errors.push('Выберите цвет материал покрытия двери');
            }
            if (!this.form.window) {
                this.errors.push('Выберите остекления');
            }
            if (!this.form.open) {
                this.errors.push('Выберите систему открывания двери');
            }
            if (!this.form.thick) {
                this.errors.push('Выберите толшину двери');
            }
            if (!this.form.soung) {
                this.errors.push('Выберите звукоизоляцию двери');
            }
            if (!this.form.discount) {
                this.errors.push('Поле Скидка не заполнено');
            }
            if (!this.errors.length) {
                return
            }
            e.preventDefault();
        },
        radioChange(param, value) {
            if (param == 'Цвет') {
                this.form.color = value
                this.door.price = value;
            } else if (param == 'Остекление') {
                this.form.window = value;
                this.quan++;
                if (value == 'yes') {
                    this.door.prise += 1000;
                } else {
                    if (this.quan !== 1) {
                        this.door.prise -= 1000;
                    }
                }
            }
        },
        changePrecent() {
            this.door.priceDiscount = Math.floor(Number(this.door.price) - (Number(this.door.price) * this.form.discount / 100));
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
        }
    },
    mounted() {
        this.getStatusData();
        this.getMatrialData();
        this.getSystemOpenDoor();
        this.getThickDoor();
    },
}   
</script>

<style scoped>
.input-radio {
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
