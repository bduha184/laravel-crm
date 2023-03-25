<script setup>
import FlashMessage from "@/Components/FlashMessage.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head,Link} from "@inertiajs/vue3";
// import { onMounted } from "vue";
import Pagination from "@/Components/Pagination.vue";

defineProps({
    customers:Object
})

// onMounted(()=>{
//     console.log(props.customers)
// })


</script>

<template>

    <ul>
        <li v-for="customer in customers.data" :key="customer.data">
            {{ customer.id }}
            {{ customer.name }}
        </li>
    </ul>
    <Pagination :links="customers.links"></Pagination>

</template>
