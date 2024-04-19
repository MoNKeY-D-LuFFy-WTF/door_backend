<template>
    <div class="form-wrapper">
        <form @submit.prevent="formValide(param)" method="post" class="form-content">
            <button @click.prevent="returnData" class="btn btn-danger align-self-end">x</button>
            <h4>{{ param }}</h4>
            <div class="mb-3">
                <label for="NAME">NAME</label>
                <input v-model="form.name" placeholder="NAME" class="form-control" type="text">
            </div>
            <div class="mb-3">
                <label for="NAME">URL</label>
                <input v-model="form.url" placeholder="/url" class="form-control" type="text">
            </div>
            <ul v-if="errors.length" class="alert alert-danger">
                <li v-for="error in errors" class="ml-3"><em>{{ error }}</em></li>
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
        param: {
            type: String,
            require: true,
        },
    },
    data() {
        return {
            form: {
                name: null,
                url: null
            },
            response: {},
            errors: [],
        }
    },
    methods: {
        returnData() {
            this.errors = []
            console.log('ok');
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
            if (!this.errors.length) {
                if (param === 'Изменить') {
                    axios.patch(`http://127.0.0.1:8000/api/catalog_children/${this.data.id}`,
                        {
                            id: this.$route.params.id,
                            name: this.form.name,
                            url: this.form.url,
                        }
                    )
                        .then(res => {
                            this.response = res.data
                        })
                        .finally(fin => {
                            this.form.name = '';
                            this.form.url = '';
                            return this.$emit('returnData', false, this.response);
                        });
                } else {
                    axios.post(
                        `http://127.0.0.1:8000/api/catalog_children`,
                        {
                            id: this.$route.params.id,
                            name: this.form.name,
                            url: this.form.url,
                        }
                    ).then(res => {
                        this.response = res.data;
                    })
                        .finally(fin => {
                            this.form.name = '';
                            this.form.url = '';
                            return this.$emit('returnData', false, this.response);
                        });
                }
            }

        },
        renameData() {
            if (Object.keys(this.data).length) {
                console.log(this.data);
                this.form.name = this.data.name;
                this.form.url = this.data.url;
            }
        }
    },
    mounted() {
        this.renameData()
    },
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
    left: 5%;
    top: 0;
    height: 100%;
    color: #fff;

}

.form-content {
    padding: 1rem 2rem;
    width: 40%;
    border-radius: 10px;
    display: flex;
    flex-direction: column;
    background: #000;
    margin: 0px 0px 5rem 0px;
}
</style>