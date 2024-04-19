<template>
    <form action="http://127.0.0.1:8000/api/furnitures" method="post" enctype="multipart/form-data">
        <input type="hidden" :value="catalogChildId" name="catalog_child_id">
        <div class="mb-3">
            <label for="image">Изображение</label>
            <input name="image" class="form-control mb-3" type="file">
        </div>
        <div class="mb-3">
            <label for="title">Загаловок</label>
            <input name="title" placeholder="Загаловок" class="form-control" type="text">
        </div>
        <div class="mb-3">
            <label for="title">Цена</label>
            <input name="price" placeholder="1999" class="form-control mb-3" type="number">
        </div>
        <button class="btn btn-primary">Создать</button>
    </form>
</template>

<script>
export default {
    props: {
        catalogChildId: {
            type: Number,
            require: true,
        }
    }
}
</script>

<style lang="scss" scoped></style>
