<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import { onMounted, reactive, ref, computed } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import InputError from '@/Components/InputError.vue';
import dayjs from 'dayjs'


onMounted(() => {
  props.items.forEach((item)=> {
    itemList.value.push({
      id: item.id,
      name: item.name,
      price: item.price,
      quantity: item.quantity
    })
  })
});

const props = defineProps({
  'items' : Array,
  'order' : Array,
  errors: Object
})

const itemList = ref([]);
const quantity = [ "0", "1", "2", "3", "4", "5", "6", "7", "8", "9"];

const form = reactive({
  id: props.order[0].id,
  date: dayjs(props.order[0].created_at).format("YYYY-MM-DD"),
  customer_id: props.order[0].customer_id,
  status: props.order[0].status,
  items: []
});

const totalPrice = computed(() => {
  let total = 0;
  itemList.value.forEach((item) => {
    total += item.price * item.quantity
  })
  return total;
})

const storeItem = () => {
  Inertia.post('/items', form)
}

const updatePurchase = (id) => {
  itemList.value.forEach((item) => {
    if(item.quantity > 0) {
      form.items.push({
        id: item.id,
        quantity: item.quantity
      })
    }
  })
  Inertia.put(route('purchases.update', { purchase: id }) ,form)
}

</script>

<template>
    <Head title="編集画面" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">編集画面</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                      <form @submit.prevent="updatePurchase(form.id)">
                      <section class="text-gray-600 body-font relative">
                        <div class="container px-5 py-8 mx-auto">
                          <div class="lg:w-1/2 md:w-2/3 mx-auto">
                            <div class="flex flex-wrap -m-2">
                              <div class="p-2 w-full">
                                <div class="relative">
                                  <label for="date" class="leading-7 text-sm text-gray-600">日付</label>
                                  <input disabled :value="form.date" type="date" id="date" name="date" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                  <InputError :message="props.errors.date"></inputError>
                                </div>
                              </div>
                              <div class="p-2 w-full">
                                <div class="relative">
                                  <label for="customer" class="leading-7 text-sm text-gray-600">会員名</label>
                                  <input disabled :value="props.order[0].customer_name" type="text" id="customer" name="customer" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                  <InputError :message="props.errors.date"></inputError>
                                </div>
                              </div>
                              <div class="lg:w-2/3 w-full mx-auto overflow-auto">
                                  <table class="table-auto w-full text-left whitespace-no-wrap my-8">
                                    <thead>
                                        <tr>
                                            <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">id</th>
                                            <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">商品名</th>
                                            <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">価格</th>
                                            <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">数量</th>
                                            <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">合計</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      <tr v-for="item in itemList" :key="item.id"> 
                                            <td class="border-t-2 border-b-2 border-gray-200 px-4 py-3">
                                                <Link 
                                                    class="text-blue-400"
                                                    :href="route('items.show', {item:item.id})">
                                                    {{ item.id }}
                                                </Link>
                                            </td>
                                            <td class="border-t-2 border-b-2 border-gray-200 px-4 py-3">{{ item.name }}</td>
                                            <td class="border-t-2 border-b-2 border-gray-200 px-4 py-3">{{ item.price }}</td>
                                            <td class="border-t-2 border-b-2 border-gray-200 px-4 py-3">
                                              <select name="quantity" v-model="item.quantity">
                                                <option v-for="q in quantity" :key="q" :value="q">{{ q }}</option>
                                              </select>
                                            </td>
                                            <td class="border-t-2 border-b-2 border-gray-200 px-4 py-3">{{ item.price * item.quantity }}</td>
                                        </tr>
                                    </tbody>
                                  </table>
                                </div>
                              <div class="p-2 w-full">
                                <div class="">
                                  合計：{{ totalPrice }}円
                                </div>
                              </div>
                              <div class="p-2 w-full">
                                <button class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">更新する</button>
                              </div>
                            
                            </div>
                          </div>
                        </div>
                      </section>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
