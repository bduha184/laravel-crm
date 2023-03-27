<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, router } from "@inertiajs/vue3";
import { reactive, onMounted, ref} from "vue";
import BreezeValidationErrors from "@/Components/ValidationErrors.vue";
import { getToday } from "@/common";
import { computed } from "@vue/reactivity";

const props = defineProps({
    customers: Array,
    items: Array,
});

const itemList = ref([]);

onMounted(() => {
    form.date = getToday();
    props.items.forEach((item) => {
        itemList.value.push({
            id: item.id,
            name: item.name,
            price: item.price,
            quantity: 0,
        });
    });
});

const totalPrice = computed(() => {
    let total = 0;
    itemList.value.forEach((item) => {
        total += item.price * item.quantity;
    });
    return total;
});

const quantity = ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9"];

const form = reactive({
    date: null,
    customer_id: null,
    status: true,
    items: [],
});

const storePurchase = () => {
    itemList.value.forEach((item) => {
        if (item.quantity > 0) {
            form.items.push({
                id: item.id,
                quantity: item.quantity,
            });
        }
    });

    router.post(route("purchases.store"), form);
};
</script>

<template>
    <form @submit.prevent="storePurchase">
        日付:<br />
        <input type="date" name="date" v-model="form.date" /><br />
        会員名：<br />
        <select name="customer" v-model="form.customer_id">
            <option
                v-for="customer in customers"
                :key="customer.id"
                :value="customer.id"
            >
                {{ customer.id }}:{{ customer.name }}
            </option>
        </select>
        購入情報：<br />

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>>商品名</th>
                    <th>金額</th>
                    <th>数量</th>
                    <th>小計</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="item in itemList">
                    <td>{{ item.id }}</td>
                    <td>{{ item.name }}</td>
                    <td>{{ item.price }}</td>
                    <td>
                        <select name="quantity" v-model="item.quantity">
                            <option v-for="q in quantity" :value="q">
                                {{ q }}
                            </option>
                        </select>
                    </td>
                    <td>
                        {{ item.price * item.quantity }}
                    </td>
                </tr>
            </tbody>
        </table>

        合計金額： {{ totalPrice }}円<br>

        <button>登録する</button>
    </form>

    <!-- <Head title="購入画面" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                購入画面
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <BreezeValidationErrors
                            :errors="errors"
                        ></BreezeValidationErrors>
                        <section class="text-gray-600 body-font relative">
                            <form @submit.prevent="storeItem">
                                <div class="container px-5 py-8 mx-auto">
                                    <div class="lg:w-1/2 md:w-2/3 mx-auto">
                                        <div class="-m-2">
                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label
                                                        for="name"
                                                        class="leading-7 text-sm text-gray-600"
                                                        >商品名</label
                                                    >
                                                    <input
                                                        type="text"
                                                        id="name"
                                                        name="name"
                                                        v-model="form.name"
                                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                                                    />
                                                </div>
                                            </div>
                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label
                                                        for="memo"
                                                        class="leading-7 text-sm text-gray-600"
                                                        >メモ</label
                                                    >
                                                    <textarea
                                                        id="memo"
                                                        name="memo"
                                                        v-model="form.memo"
                                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out"
                                                    ></textarea>
                                                </div>
                                            </div>
                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label
                                                        for="price"
                                                        class="leading-7 text-sm text-gray-600"
                                                        >商品価格</label
                                                    >
                                                    <input
                                                        type="number"
                                                        id="price"
                                                        name="price"
                                                        v-model="form.price"
                                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                                                    />
                                                </div>
                                            </div>
                                            <div class="p-2 w-full">
                                                <button
                                                    class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg"
                                                >
                                                    商品登録
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout> -->
</template>
