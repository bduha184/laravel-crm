<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
Inertiaテス<br>
<a href="/">aたぐ</a><br>

<Link href="/">Link</Link>
<Link :href="route('inertia.index')">名前つきルート確認</Link><br>
<Link :href="route('inertia.show',{id:1})">ルートパラメータテスト</Link>
</template>
