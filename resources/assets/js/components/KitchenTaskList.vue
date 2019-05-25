<template>
    <table class="table table-bordered">
        <caption>
            <h4 class="p-t-md">
                {{ title }}
            </h4>
        </caption>
        <thead>
        <tr>
            <th scope="col">
                Название супа
            </th>
            <th scope="col">
                Количество, литров
            </th>
        </tr>
        </thead>
        <tbody class="tbody" v-if="Object.keys(JSON.parse(taskList)).length">
            <tr v-for="(item, index) in JSON.parse(taskList)">
                <th>
                    {{ index }}
                </th>
                <td>
                    {{ calcSum(index) }}
                </td>
            </tr>
        </tbody>
        <tbody class="tbody" v-else>
            <tr>
                <td colspan="2">
                    пусто
                </td>
            </tr>
        </tbody>
    </table>
</template>

<script>
    export default {
        props: ['taskList', 'title'],
        methods: {
            calcSum(index) {
                var target = JSON.parse(this.taskList)[index];
                var result = 0;
                for (var k in target) {
                    if (typeof target[k] !== 'function') {
                        result += (parseInt(k) * target[k]);
                    }
                }
                return result / 1000;
            }
        }
    }
</script>

<style scoped>
.tbody tr{
    font-weight: bold;
    color: #9a999e;
}
</style>