<script setup>
import { router } from '@inertiajs/vue3'

    defineProps({
        id:String,
        blog: Array
    })
    const deleteConfirm = id => {
router.delete(`/inertia/${id}`,{
    onBefore:()=> confirm('本当に削除しますか？')
})
    }
</script>

<template>
    {{ id }}<br>
    {{ blog.title }}
    <button @click="deleteConfirm(blog.id)">削除</button>
</template>
