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
                    <input type="text" class="count" v-bind:class="{ 'active': isActive }" :name="name" :id="id"
                           value="0" v-model="counter">
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
                // if(isNaN(this.counter)) {
                //     this.counter = 0;
                // }
                if (this.counter !== 0) {
                    this.counter--
                }
            }
        },
        watch: {
            counter: function (newCounter, oldCounter) {
                if(isNaN(newCounter)) {
                    this.counter = oldCounter;
                } else
                    if(newCounter > 9){
                    this.counter = newCounter % 10;
                }
                if (newCounter != 0 && !isNaN(newCounter)) {
                    this.isActive = true
                    this.countPrice = this.price * newCounter;
                    if (!isNaN(oldCounter)) {
                        this.$store.state.counter -= this.price * oldCounter;
                    }
                    this.$store.state.counter += this.countPrice;
                } else {
                    // this.counter = 0
                    this.isActive = false
                    this.countPrice = 0
                    if (!isNaN(oldCounter)) {
                        this.$store.state.counter -= this.price * oldCounter;
                    }
                }
                this.counter = Number(this.counter)
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
        width: 175px;
        padding: 5px 0 5px 14px;
        /*padding-left: auto;*/
        /*padding-right: auto;*/
        /*border: 1px solid green;*/
        margin-left: auto;
        margin-right: 0;
    }

    @media (max-width: 768px) {
        div .qty-buttons {
            width: 175px;
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
        border: 0;
        /*color: #000;*/
        display: inline-block;
        vertical-align: top;
        font-size: 25px;
        /*font-weight: 700;*/
        line-height: 30px;
        padding: 0 2px;
        min-width: 35px;
        text-align: center;
        margin-left: auto;
        margin-right: auto;
        width: 2%;
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
        width: 40px;
        height: 40px;
        font: 34px/1 Arial, sans-serif;
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
        width: 40px;
        height: 40px;
        font: 28px/1 Arial, sans-serif;
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