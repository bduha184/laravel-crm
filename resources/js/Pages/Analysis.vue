<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, router } from "@inertiajs/vue3";
import { onMounted, reactive } from "vue";
import { getToday } from "@/common";
import Chart from "@/Components/Chart.vue";
import ResultTable from "@/Components/ResultTable.vue";

onMounted(() => {
    form.startDate = getToday();
    form.endDate = getToday();
});

const form = reactive({
    startDate: null,
    endDate: null,
    type: null,
});

const data = reactive({});

const getData = async () => {
    try {
        await axios
            .get("/api/analysis/", {
                params: {
                    startDate: form.startDate,
                    endDate: form.endDate,
                    type: form.type,
                },
            })
            .then((res) => {
                data.data = res.data.data
                data.labels = res.data.labels
                data.totals = res.data.totals
                data.type = res.data.type
            });
    } catch (e) {
        console.log(e.message);
    }
};
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <form @submit.prevent="getData">
                            分析方法<br />
                            <input
                                type="radio"
                                v-model="form.type"
                                value="perDay"
                                checked
                            />
                            <span class="mr-4">日別</span>
                            <input
                                type="radio"
                                v-model="form.type"
                                value="perMonth"
                            />
                            <span class="mr-4">月別</span>
                            <input
                                type="radio"
                                v-model="form.type"
                                value="perYear"
                            />
                            <span class="mr-4">年別</span>
                            <input
                                type="radio"
                                v-model="form.type"
                                value="decile"
                            />
                            <span class="mr-4">デシル分析</span>
                            <br />
                            From:<input
                                type="date"
                                name="startDate"
                                v-model="form.startDate"
                            />
                            to:<input
                                type="date"
                                name="endDate"
                                v-model="form.endDate"
                            />
                            <br />
                            <button
                                class="flex mx-auto my-4 text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg"
                            >
                                分析する
                            </button>
                        </form>
                        <div v-if="data.data">
                            <Chart :data="data" />
                            <ResultTable :data="data"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
