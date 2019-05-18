<template>
    <!--    <div class="">-->
    <div class="qty mt-5">
        <span class="plus" @click="increment">+</span>
        <input type="text" class="count" :name="name" :id="id" value="0" v-model="counter">
        <span class="minus" @click="decrement">-</span>
    </div>
    <!--    </div>-->
</template>

<script>
    export default {
        props: ['name', 'id'],
        data: function () {
            return {
                counter: 0,
                // test: 'test'
            }
        },
        methods: {
            increment() {
                if (this.counter < 9) {
                    this.counter++
                } else {
                    this.counter = 0
                }
            },
            decrement() {
                if (this.counter !== 0) {
                    this.counter--
                }
            }
        },
    }
</script>

<style scoped>
    div .qty {
        width: 70px;
        padding: 5px;
    }

    .qty {
        border: 1px solid red;
        margin-left: auto;
        margin-right: auto;
    }


    .qty .count {
        color: #000;
        display: inline-block;
        vertical-align: top;
        font-size: 25px;
        font-weight: 700;
        line-height: 30px;
        padding: 0 2px;
        min-width: 35px;
        text-align: center;
    }

    .qty .plus {
        cursor: pointer;
        display: inline-block;
        vertical-align: top;
        color: #5ca5ff;
        width: 30px;
        height: 30px;
        font: 25px/1 Arial, sans-serif;
        text-align: center;
        border: 3px solid #5ca5ff;
        border-radius: 50%;
    }

    .qty .minus {
        cursor: pointer;
        display: inline-block;
        vertical-align: top;
        color: #5ca5ff;
        width: 30px;
        height: 30px;
        font: 25px/1 Arial, sans-serif;
        text-align: center;
        border: 3px solid #5ca5ff;
        border-radius: 50%;
        background-clip: padding-box;
    }
</style>