<script setup>
import { Link } from '@inertiajs/vue3';
import {ref} from 'vue';

const newTitle = ref('');
const newContent = ref('');
</script>

<template>
Inertiaテス<br>
<a href="/">aたぐ</a><br>

<Link href="/">Link</Link>
<Link :href="route('inertia.index')">名前つきルート確認</Link><br>
<Link :href="route('inertia.show',{id:1})">ルートパラメータテスト</Link>

<div class="mb-8">
    <input type="text" name="newTitle" v-model="newTitle">{{ newTitle }}<br>
    <input type="text" name="newContent" v-model="newContent">{{ newContent }}<br>
    <Link as="button" method="post" :href="route('inertia.store')"
     :data="{
        title: newTitle,
        content: newContent,
     }">
     DB保存テスト
    </Link>
</div>

</template>
