<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { onMounted, reactive } from 'vue';
import { getToday } from '@/common'
import axios from 'axios';
import Chart from '@/Components/Chart.vue';
import ResultTable from '@/Components/ResultTable.vue';

onMounted(() => {
  form.startDate = getToday();
  form.endDate = getToday();
});

const form = reactive({
  startDate: null,
  endDate: null,
  type: 'perDay'
});

const data = reactive({})

const getData = async () => {
  try {
    await axios.get('/api/analysis', {
      params: {
        startDate: form.startDate,
        endDate: form.endDate,
        type: form.type
      }
    })
    .then((res) => {
      //配列の値が入る。
      data.data = res.data.data;
      data.labels = res.data.labels;
      data.totals = res.data.totals;
      data.type = res.data.type
    });
  } catch (e) {
    console.log(e.message);    
  }
}



</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                  <form @submit.prevent="getData">
                    分析方法<br>
                    <input type="radio" v-model="form.type" value="perDay" checked><span class="mr-2">日別</span>
                    <input type="radio" v-model="form.type" value="perMonth"><span class="mr-2">月別</span>
                    <input type="radio" v-model="form.type" value="perYear"><span class="mr-2">年別</span>
                    <input type="radio" v-model="form.type" value="decile"><span class="mr-2">でしる</span>
                    <br>
                    <br>
                    開始:<input type="date" name='startDate' v-model="form.startDate" class="w-2/3 bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                    <br>
                    終了:<input type="date" name='endDate' v-model="form.endDate" class="w-2/3 bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                    <br>
                    <button class=" text-white bg-indigo-500 border-0 py-2 px-8 mt-10 focus:outline-none hover:bg-indigo-600 rounded text-lg">分析</button>
                  </form>

                  <div v-show="data.data">
                    <Chart :data="data"/>
                  </div>

                  <div v-show="data.data">
                    <ResultTable :data="data"/>
                  </div>
                  
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
