<template>
    <div>
        <form @submit.prevent="valideForm" action="http://127.0.0.1:8000/api/catalogs" method="post">
            <div v-if="response" class='alert alert-success p-3 my-3'>
                {{ response }}
            </div>
            <select @change="selectedPath" ref="select" class="form-control" name="" id="">
                <option value="new">Новый путь</option>
                <option value="alredy">Уже есть</option>
            </select>
            <div class="my-3" v-if="selectValue == 'new'">
                <div v-for="parent in form.catalogParent" ref="parent" class="mb-3">
                    <label for="catalog">{{ parent.title }}</label>
                    <input v-model.trim="parent.text" :placeholder="parent.placeholder" class="form-control"
                        id="catalog" type="text">
                    <div class="alert alert-danger" v-if="parent.error">
                        <b>{{ parent.error }}</b>
                    </div>
                </div>
                <div v-for="catalogChild in form.catalogChildren" :key="catalogChild.id" class="mb-3">
                    <label for="catalog">{{ catalogChild.id }} {{ catalogChild.title }} </label>
                    <input v-model.trim="catalogChild.text" :name="`${catalogChild.id}_${catalogChild.name}`"
                        :placeholder="catalogChild.placeholder" class="form-control" id="catalog" type="text">
                </div>
            </div>
            <div v-else-if="selectValue == 'alredy'" class="my-3">
                <div>
                    Создать в
                </div>
                <select @change="selectChildData = $event.target.value" class="form-control mb-3">
                    <option v-for="child in dataChildren" :key="child.id" :value="child.id">
                        {{ child.name }}
                    </option>
                </select>
                <div v-if="!response" class="alert alert-warning">
                    <b>Минимум 1 поле полжно быть заполнено</b>
                </div>
                <div class="alert alert-success" v-else>
                    {{ response }}
                </div>
                <div v-for="catalogChild in form.catalogChildren" :key="catalogChild.id" class="mb-3">
                    <label for="catalog">{{ catalogChild.id }} {{ catalogChild.title }} </label>
                    <input v-model.trim="catalogChild.text" :name="`${catalogChild.id}_${catalogChild.name}`"
                        :placeholder="catalogChild.placeholder" class="form-control" id="catalog" type="text">
                    <div v-if="catalogChild.error" class="alert alert-danger">
                        {{ catalogChild.error }}
                    </div>
                </div>
            </div>
            <button class="nc-icon btn-create mt-4 btn btn-success nc-button-play" title="Создать">Создать</button>
        </form>
        <button class="w-100  btn btn-primary mt-5 nc-icon nc-simple-add" @click.prevent="showInputs"></button>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            showQuantity: 0,
            url: [],
            valueCatalog: '',
            response: null,
            form: {
                catalogParent: [
                    {
                        id: 1,
                        title: 'Создать путь каталога',
                        placeholder: 'Межкомнатные двери',
                        name: 'catalogParent',
                        text: null,
                        error: null
                    },
                ],
                catalogChildren: [
                    {
                        id: 1,
                        title: 'Создать путь дочернего каталога ',
                        placeholder: 'Межкомнатные двери -> дочерный каталог',
                        name: '1_catalogChild',
                        text: null,
                    },
                ],
            },
            selectValue: 'new',
            selectChildData: '1',
            dataChildren: [],
        }
    },
    methods: {
        valideForm(e) {
            let parent = this.$refs.parent;
            if (parent.length) {
                if (!this.form.catalogParent[0].text) {
                    this.form.catalogParent[0].error = 'Это поле обязательно для заполнения'
                    parent[0].scrollIntoView({ behavior: "smooth" });
                } else {
                    this.form.catalogParent[0].error = null;
                    let url = this.translateTextUrl(this.form.catalogParent[0].text);
                    this.form.catalogChildren.forEach(element => {
                        if (element.text) {
                            element.url = this.translateTextUrl(element.text);
                        }
                    });
                    console.log(this.form.catalogChildren);
                    axios.post
                        (
                            'http://127.0.0.1:8000/api/catalogs',
                            {
                                name: this.form.catalogParent[0].text,
                                url: url,
                                children: this.form.catalogChildren.filter(child => child.text !== null),
                            }
                        )
                        .then(res => {
                            this.response = res.data
                        })
                        .catch(err => {
                            console.log(err);
                        })
                        .finally(fin => {
                            this.form.catalogChildren = this.form.catalogChildren.filter(element => element.id == 1);
                            const inputs = document.querySelectorAll('input[type="text"]')
                            inputs.forEach(element => {
                                element.value = '';
                            });
                        })
                }
            } else {

                this.form.catalogChildren.forEach(element => {
                    if (element.text) {
                        element.url = this.translateTextUrl(element.text);
                    }
                });
                if (!this.form.catalogChildren[0].text) {
                    this.form.catalogChildren[0].error = 'Ошибка это поле обязательно для заполненя';
                    const firstChild = document.querySelector('input[type="text"]');
                    firstChild.scrollIntoView({ behavior: 'smooth' });
                    this.$forceUpdate();
                } else {
                    this.form.catalogChildren[0].error = null;
                    this.$forceUpdate();

                    axios.post(
                        `http://127.0.0.1:8000/api/catalog_children`,
                        {
                            parentId: this.selectChildData,
                            children: this.form.catalogChildren.filter(child => child.text !== null),
                        }
                    )
                        .then(res => {
                            this.response = res.data;
                        })
                        .catch(err => {
                            console.log(err);
                        })
                        .finally(fin => {
                            const inputs = document.querySelectorAll('input[type="text"]');
                            for (let i = 0; i < inputs.length; i++) {
                                inputs[i].value = '';
                            }
                        })

                }
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
        showInputs() {
            this.showQuantity++;
            let newCatalogChildren = {
                id: this.form.catalogChildren.length + 1,
                title: 'Создать путь дочернего каталога (необязательно)',
                placeholder: 'Межкомнатные двери -> дочерный каталог',
                name: 'catalogChild',
                text: null,
            }
            this.form.catalogChildren.push(newCatalogChildren);
        },
        selectedPath() {
            const select = this.$refs.select;
            this.selectValue = select.value;
        },
        getDataChildren() {
            axios.get('http://127.0.0.1:8000/api/catalogs')
                .then(res => {
                    this.dataChildren = res.data
                })
                .catch(err => {
                    console.log(err);
                })
                .finally(fin => {
                    console.log(fin);
                });
        }
    },
    mounted() {
        this.getDataChildren()
    },


}
</script>

<style scoped>
.nc-icon.nc-check-2,
.nc-simple-add {
    font-weight: 900;
}

.btn-create {
    display: flex;
    gap: 5px;
    align-items: flex-start;
    justify-content: center;
}
</style>


<!-- <catalog-input :place="`Называние каталога`" :type="`text`" :name="`name`" />
            <catalog-input v-if="this.showQuantity > 0" :place="`Называние под коталога необязательно`" :type="`text`"
                :name="`name_child`" /> -->