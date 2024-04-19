<template>
    <form @submit="changeForm" action="http://127.0.0.1:8000/api/banners" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="title">Загаловок</label>
            <input v-model="from.title" placeholder="Баннер" class="form-control" name="title" type="text">
        </div>
        <div class="mb-3">
            <label for="title">Описание</label>
            <input v-model="from.subtitle" placeholder="Баннер" class="form-control" name="subtitle" type="text">
        </div>
        <div class="mb-3">
            <label for="title">Путь куда направляет баннер</label>
            <input v-model="from.url" placeholder="/baket" class="form-control" name="url" type="text">
        </div>
        <div class="mb-3">
            <label for="title">Картинка</label>
            <input @change="$event.target.value = from.image" class="form-control" name="image" type="file">
        </div>
        <div class="mb-3">
            <button class="btn btn-success">Создать</button>
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
                url: null,
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
            if (!this.from.url) {
                this.errors.push('Поле путь обязательно');
            }
            if (!this.from.image) {
                this.errors.push('Выберите фото');
            }
            if (!this.errors.length) {
                return
            }
            e.preventDefault();
        }
    }
}
</script>

<style scoped></style>