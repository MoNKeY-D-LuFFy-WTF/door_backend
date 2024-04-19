<template>
    <div class="waraper">
        <div class="modal__delete">
            Вы действительно хотите удалить <br>
            <span class="my-4"> {{ item.name }}</span>
            <div class="d-flex">
                <button @click="yesOrNo('yes', item)" class="btn btn-danger mr-3">Да</button>
                <button @click="yesOrNo('no', item)" class="btn btn-success">Нет</button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'modal-delete',
    props: {
        item: {
            type: Object,
            require: true
        }
    },
    methods: {
        yesOrNo(param, item) {
            if (param === 'yes') {
                return this.$emit('yesOrNo', false, true, item);
            } else {
                return this.$emit('yesOrNo', false, false, item);
            }
        }
    }
}
</script>

<style scoped>
.waraper {
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 100;
    left: 0%;
    background: #00000086;
    position: fixed;
    width: 100%;
    height: 100%;
    top: 0;
}

.modal__delete {
    background: #000;
    width: 50%;
    padding: 30px 50px;
    border-radius: 10px;
    color: #cfcfcf;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
}
</style>