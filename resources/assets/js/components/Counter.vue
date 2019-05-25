<template>
    <div>
        <p class="total">Общая стоимость заказа <span class="active">{{ counter }}</span> грн.
            <span v-if="!counter"><strong>Сначала выберите количество, далее Вы сможете выбрать время доставки. </strong></span>
            <span v-if="counter">Теперь выберите время доставки:</span>
        </p>
        <button type="submit" class="btn btn-info btn-lg" :disabled="counter == 0">
            Выбрать время доставки
        </button>
    </div>
</template>

<script>
    export default {
        computed: {
            counter() {
                return this.$store.state.counter
            }
        }
    }
</script>

<style scoped>
    .active {
        color: black;
    }
    .total {
        padding: 10px 30px;
    }
</style>