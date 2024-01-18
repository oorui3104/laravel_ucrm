<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { reactive } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import InputError from '@/Components/InputError.vue';
import { Core as YubinBangoCore } from "yubinbango-core2";

defineProps({
  errors: Object
});

const form = reactive({
  name: null, 
  kana: null, 
  tel: null,
  email: null, 
  postcode: null, 
  address: null, 
  birthday: null, 
  gender: null, 
  memo: null
});

const storeCustomer = () => {
  Inertia.post('/customers', form)
}

const fetchAddress = () => {
  new YubinBangoCore(String(form.postcode), (value) => {
    form.address = value.region + value.locality + value.street
  })
}

</script>

<template>
    <Head title="顧客登録" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">顧客登録</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                      <form @submit.prevent="storeCustomer">
                      <section class="text-gray-600 body-font relative">
                        <div class="container px-5 py-8 mx-auto">
                          <div class="lg:w-1/2 md:w-2/3 mx-auto">
                            <div class="flex flex-wrap -m-2">
                              <div class="p-2 w-full">
                                <div class="relative">
                                  <label for="name" class="leading-7 text-sm text-gray-600">顧客名</label>
                                  <input v-model="form.name" type="text" id="name" name="name" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                  <InputError :message="errors.name"></inputError>
                                </div>
                              </div>
                              <div class="p-2 w-full">
                                <div class="relative">
                                  <label for="kana" class="leading-7 text-sm text-gray-600">かな</label>
                                  <input v-model="form.kana" type="text" id="kana" name="kana" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                  <InputError :message="errors.kana"></inputError>
                                </div>
                              </div>
                              <div class="p-2 w-full">
                                <div class="relative">
                                  <label for="tel" class="leading-7 text-sm text-gray-600">電話</label>
                                  <input v-model="form.tel" type="tel" id="tel" name="tel" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                  <InputError :message="errors.tel"></inputError>
                                </div>
                              </div>
                              <div class="p-2 w-full">
                                <div class="relative">
                                  <label for="email" class="leading-7 text-sm text-gray-600">メール</label>
                                  <input v-model="form.email" type="email" id="email" name="email" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                  <InputError :message="errors.email"></inputError>
                                </div>
                              </div>
                              <div class="p-2 w-full">
                                <div class="relative">
                                  <label for="postcode" class="leading-7 text-sm text-gray-600">郵便番号</label>
                                  <input v-model="form.postcode" type="number" id="postcode" name="postcode" @change="fetchAddress" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                  <InputError :message="errors.postcode"></inputError>
                                </div>
                              </div>
                              <div class="p-2 w-full">
                                <div class="relative">
                                  <label for="address" class="leading-7 text-sm text-gray-600">住所</label>
                                  <input v-model="form.address" type="text" id="address" name="address" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                  <InputError :message="errors.address"></inputError>
                                </div>
                              </div>
                              <div class="p-2 w-full">
                                <div class="relative">
                                  <label for="birthday" class="leading-7 text-sm text-gray-600">誕生日</label>
                                  <input v-model="form.birthday" type="date" id="birthday" name="birthday" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                  <InputError :message="errors.birthday"></inputError>
                                </div>
                              </div>
                              <div class="p-2 w-full">
                                <div class="relative">
                                  <label for="memo" class="leading-7 text-sm text-gray-600">メモ</label>
                                  <textarea v-model="form.memo" id="memo" name="memo" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out"></textarea>
                                  <InputError :message="errors.memo"></inputError>
                                </div>
                              </div>
                              <div class="p-2 w-full">
                                <div class="relative">
                                  <label for="gender" class="leading-7 text-sm text-gray-600">性別</label>
                                  <input value="0" v-model="form.gender" type="radio" id="gender" name="gender" class="">
                                  <label for="gender" class="leading-7 text-sm text-gray-600">男性</label>
                                  <input value="1" v-model="form.gender" type="radio" id="gender" name="gender" class="">
                                  <label for="gender" class="leading-7 text-sm text-gray-600">女性</label>
                                  <input value="2" v-model="form.gender" type="radio" id="gender" name="gender" class="">
                                  <label for="gender" class="leading-7 text-sm text-gray-600">その他</label>
                                  <InputError :message="errors.price"></inputError>
                                </div> 
                              </div>
                              <div class="p-2 w-full">
                                <button class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">顧客登録</button>
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
