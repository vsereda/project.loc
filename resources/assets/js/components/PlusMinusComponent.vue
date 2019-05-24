<template>
    <!--    <div class="">-->
    <div>
        <div class="m-b-sm mt-5 equal">

            <div class="qty-tile col-sm-6 col-xs-12 col-sm-push-6">
                <span v-bind:class="{ 'active': isActive }">{{ countPrice ? countPrice : price }} грн. </span>
                <span v-if="!isActive"> /порция</span>
            </div>

            <div class=" qty col-sm-6 col-xs-12 col-sm-pull-6 flex-right">
                <div class="qty-buttons">
                    <span class="plus" @click="increment">+</span>
                    <input type="text" class="count" v-bind:class="{ 'active': isActive }"  :name="name" :id="id" value="0" v-model="counter" >
                    <span class="minus" @click="decrement">-</span>
                </div>
            </div>

        </div>
    </div>
    <!--    </div>-->
</template>

<script>
    export default {
        props: ['name', 'id', 'price'],
        data: function () {
            return {
                counter: 0,
                countPrice: 0,
                // test: 'test'
                isActive: false
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
        watch: {
            counter: function (newCounter, oldCounter) {
                if(newCounter !== 0){
                    this.isActive = true
                    this.countPrice = this.price * newCounter;
                } else {
                    this.isActive = false
                    this.countPrice = 0
                }
            }
        }
    }
</script>

<style scoped>
    .active {
        color: black;
        font-weight: bold;
        font-size: 20px;
    }

    .equal {
        padding-top: 10px;
        padding-bottom: 10px;
    }

    @media (max-width: 768px) {
        .equal {
            padding-top: 0;
        }
    }

    div .qty-buttons {
        width: 90px;
        padding: 5px 14px;
        /*padding-left: auto;*/
        /*padding-right: auto;*/
        /*border: 1px solid green;*/
        margin-left: auto;
        margin-right: 0;
    }

    @media (max-width: 768px) {
        div .qty-buttons {
            width: 60px;
            margin-left: auto;
            margin-right: auto;
        }
    }

    @media (max-width: 768px) {
        div .qty-buttons {
            width: 105px;
            padding: 0;
        }
    }

    div.qty-tile {
        padding: 5px;
        /*border: 1px solid green;*/
        display: flex;
        align-items: center;
        justify-content: left;
    }

    @media (max-width: 768px) {
        div.qty-tile {
            justify-content: center;
        }
    }

    .qty {
        /*border: 1px solid red;*/
        margin-left: auto;
        /*margin-right: auto;*/
        margin-right: auto;
    }

    @media (max-width: 768px) {
        .qty {
            margin-right: auto;
        }
    }


    .qty .count {
        /*color: #000;*/
        display: inline-block;
        vertical-align: top;
        font-size: 25px;
        /*font-weight: 700;*/
        line-height: 30px;
        padding: 0 2px;
        min-width: 35px;
        text-align: center;
        margin-left: 12px;
        margin-right: 12px;
    }

    @media (max-width: 768px) {
        .qty .count {
            font-size: 14px;
            margin-left: auto;
            margin-right: auto;
        }
    }

    .qty .plus {
        cursor: pointer;
        display: inline-block;
        vertical-align: top;
        color: #5ca5ff;
        width: 60px;
        height: 60px;
        font: 54px/1 Arial, sans-serif;
        text-align: center;
        border: 3px solid #5ca5ff;
        border-radius: 50%;
    }

    @media (max-width: 768px) {
        .qty .plus {
            width: 30px;
            height: 30px;
            font: 23px/1 Arial, sans-serif;

        }
    }

    .qty .minus {
        cursor: pointer;
        display: inline-block;
        vertical-align: top;
        color: #5ca5ff;
        width: 60px;
        height: 60px;
        font: 48px/1 Arial, sans-serif;
        text-align: center;
        border: 3px solid #5ca5ff;
        border-radius: 50%;
        background-clip: padding-box;
    }

    @media (max-width: 768px) {
        .qty .minus {
            width: 30px;
            height: 30px;
            font: 23px/1 Arial, sans-serif;

        }
    }

</style>