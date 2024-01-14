<script setup>
import { Link } from '@inertiajs/inertia-vue3';
import { ref } from 'vue';

const newTitle = ref("");
const newContent = ref("");

</script>

<template>
  InertiaTest 
  <br>
  <a href="/">aタグ</a>
  <br>
  <Link href="/">リンク経由</Link>
  <br>
  <Link :href="route('inertia.index')">名前付きルート</Link>
  <br>
  <Link :href="route('inertia.show', { id: 20 })">parametr</Link>

  <div class="mt-8"></div>
  <input type="text" name="newTitle" v-model="newTitle">
  <br>
  <input type="text" name="newTitle" v-model="newContent">
  <br>
  <Link as="button" :href="route('inertia.store')" method="post"
   :data="{
    title: newTitle,
    content: newContent
   }" >
   保存テスト</Link>
</template>