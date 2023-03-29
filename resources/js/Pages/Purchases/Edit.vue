<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, router } from "@inertiajs/vue3";
import { reactive, onMounted, ref } from "vue";
import BreezeValidationErrors from "@/Components/ValidationErrors.vue";
import { computed } from "@vue/reactivity";
import dayjs from "dayjs";

const props = defineProps({
    items: Array,
    order: Array,
});

onMounted(() => {
    props.items.forEach((item) => {
        itemList.value.push({
            id: item.id,
            name: item.name,
            price: item.price,
            quantity: item.quantity,
        });
    });
});

const itemList = ref([]);

const form = reactive({
    date: dayjs(props.order[0].created_at).format('YYYY-MM-DD'),
    customer_id: props.order[0].customer_id,
    status: props.order[0].status,
    items: [],
});

const quantity = ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9"];

const totalPrice = computed(() => {
    let total = 0;
    itemList.value.forEach((item) => {
        total += item.price * item.quantity;
    });
    return total;
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

const setCustomerId = id => {
    form.customer_id = id;
}

</script>

<template>
    <Head title="購買履歴 編集画面" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                購買履歴 編集画面
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <!-- <BreezeValidationErrors
                            :errors="errors"
                        ></BreezeValidationErrors> -->
                        <section class="text-gray-600 body-font">
                            <form @submit.prevent="storePurchase">
                                <div class="container px-5 py-8 mx-auto">
                                    <div class="lg:w-1/2 md:w-2/3 mx-auto">
                                        <div class="-m-2">
                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label
                                                        for="date"
                                                        class="leading-7 text-sm text-gray-600"
                                                        >日付</label
                                                    >
                                                    <input
                                                    disabled
                                                        type="date"
                                                        name="date"
                                                        :value="form.date"
                                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                                                    />
                                                </div>
                                            </div>
                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label
                                                    for="customer"
                                                    class="leading-7 text-sm text-gray-600"
                                                    >会員名</label
                                                    >
                                                    <div id="customer" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                        {{ props.order[0].customer_name }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label
                                                        for="price"
                                                        class="leading-7 text-sm text-gray-600"
                                                        >購入情報</label
                                                    >
                                                    <table class="table-auto w-full text-left whitespace-no-wrap">
                                                        <thead>
                                                            <tr>
                                                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">ID</th>
                                                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">商品名</th>
                                                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">金額</th>
                                                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">数量</th>
                                                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">小計</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr
                                                                v-for="item in itemList"
                                                            >
                                                                <td class="border-b-2 border-gray-200 px-4 py-3">
                                                                    {{
                                                                        item.id
                                                                    }}
                                                                </td>
                                                                <td class="border-b-2 border-gray-200 px-4 py-3">
                                                                    {{
                                                                        item.name
                                                                    }}
                                                                </td>
                                                                <td class="border-b-2 border-gray-200 px-4 py-3">
                                                                    {{
                                                                        item.price
                                                                    }}
                                                                </td>
                                                                <td class="border-b-2 border-gray-200 px-4 py-3">
                                                                    <select
                                                                        name="quantity"
                                                                        v-model="
                                                                            item.quantity
                                                                        "
                                                                    >
                                                                        <option
                                                                            v-for="q in quantity"
                                                                            :value="
                                                                                q
                                                                            "
                                                                        >
                                                                            {{
                                                                                q
                                                                            }}
                                                                        </option>
                                                                    </select>
                                                                </td>
                                                                <td class="border-b-2 border-gray-200 px-4 py-3">
                                                                    {{
                                                                        item.price *
                                                                        item.quantity
                                                                    }}
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>

                                                </div>
                                            </div>
                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label
                                                    for="totalPrice"
                                                    class="leading-7 text-sm text-gray-600"
                                                    >合計金額</label
                                                    >
                                                    <div id="totalPrice" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                    {{ totalPrice }}円<br />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label
                                                    for="status"
                                                    class="leading-7 text-sm text-gray-600"
                                                    >ステータス</label
                                                    >
                                                    <input type="radio" v-model="form.status" id="status" name="status" value="1" class="">未キャンセル
                                                    <input type="radio" v-model="form.status" id="status" name="status" value="0" class="">キャンセルする
                                                </div>
                                            </div>
                                            <div class="p-2 w-full">
                                                <button
                                                    class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg"
                                                >
                                                    登録する
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
    </AuthenticatedLayout>
</template>
