<template>
    <div class="wrapper-form mb-3">
        <div class="lable">
            <label :for="name">{{ place }}</label>
        </div>
        <div class="input">
            <input :disabled="disebled" :name="name" :placeholder="place" class="form-control" :type="type">
            <div v-if="!disebled" @click="changeInput" class="nc-icon nc-check-2 btn btn-success"></div>
            <div v-else @click="returnInput" class="nc-icon nc-simple-remove btn btn-danger"></div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'catalog-input',
    props: {
        name: {
            type: String,
            require: true,
        },
        type: {
            type: String,
            require: true,
        },
        place: {
            type: String,
            require: true,
        },

    },
    data() {
        return {
            disebled: false
        }
    },
    methods: {
        changeInput(e) {
            let inputValue = e.target.parentNode.firstChild.value
            if (inputValue.trim() != "") {
                this.disebled = true
                axios.post(`http://127.0.0.1:8000/api/catalogs?name=${inputValue}&url=${this.translateTextUrl(inputValue)}&params=${this.name}`)
                    .then(res => {
                        console.log(res);
                    })
            }
        },
        returnInput(e) {
            this.disebled = false;
            let inputValue = e.target.parentNode.firstChild.value
            axios.delete(`http://127.0.0.1:8000/api/catalogs/${inputValue}/${this.name}`)
                .then(res => {
                    console.log(res);
                })
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
                    if (userText[i] === "ч") {
                        translate += "ch"
                        break
                    }
                    if (userText[i] === "я") {
                        translate += "ya"
                        break
                    }
                }
            }
            return translate;
        },
    },

}
</script>

<style scoped>
.wrapper-form {
    display: flex;
    flex-direction: column;
}

.input {
    display: flex;
    gap: 20px;
}
</style>