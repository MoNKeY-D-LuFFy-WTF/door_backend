<template>
    <form @submit="changeForm" action="http://127.0.0.1:8000/api/promotions" method="post"
        enctype="multipart/form-data">
        <div class="mb-3">
            <label for="title">Загаловок</label>
            <input v-model="from.title" placeholder="Акция" class="form-control" name="title" type="text">
        </div>
        <div class="mb-3">
            <label for="title">Описание</label>
            <input v-model="from.subtitle" placeholder="Акция" class="form-control" name="subtitle" type="text">
        </div>
        <div class="mb-3">
            <label for="text">Текст</label>
            <textarea v-model="from.text" placeholder="Текст" class="form-control" name="text" id="text"></textarea>
        </div>
        <div class="mb-3">
            <label for="date">Дата истечение</label>
            <input v-model="from.data" class="form-control w-50" name="date" type="date">
        </div>
        <div class="mb-3">
            <label for="title">Картинка</label>
            <input @change="from.image = $event.target.value" class="form-control" name="image" type="file">
        </div>
        <div class="mb-3">
            <button type="submit" class="btn btn-success">Создать</button>
        </div>
        <ul v-if="errors.length" class="alert alert-danger">
            <li class="ml-3" v-for="error in errors">
                <em>{{ error }}</em>
            </li>
        </ul>
    </form>
</template>

<script>
export default {
    data() {
        return {
            from: {
                title: null,
                subtitle: null,
                text: null,
                data: null,
                image: null
            },
            errors: [],
        }
    },
    methods: {
        changeForm(e) {
            this.errors = [];
            if (!this.from.title) {
                this.errors.push('Поле загаловок обязательно');
            }
            if (!this.from.subtitle) {
                this.errors.push('Поле описание обязательно');
            }
            if (!this.from.text) {
                this.errors.push('Поле текст обязательно');
            }
            if (!this.from.data) {
                this.errors.push('Поле дата обязательно');
            }
            if (!this.from.image) {
                this.errors.push('Выберите фото');
            }
            if (!this.errors.length) {
                return
            }
            e.preventDefault();

        }
    },
}
</script>

<style scoped></style>