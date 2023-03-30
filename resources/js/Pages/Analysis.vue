<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, router } from "@inertiajs/vue3";
import { onMounted, reactive } from "vue";
import { getToday } from "@/common";

onMounted(() => {
    form.startDate = getToday();
    form.endDate = getToday();
});

const form = reactive({
    startDate:null,
    endDate:null,
    type: "perDay",
});

const getData = async () => {
    try {
        await axios.get("/api/analysis/", {
                params: {
                    startDate: form.startDate,
                    endDate: form.endDate,
                    type: form.type,
                },
            })
            .then((res) => {
                // data.value = res.data
                console.log(res.data)
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
                            From:
                            <input
                                type="date"
                                name="startDate"
                                v-model="form.startDate"
                            />
                            to:
                            <input
                                type="date"
                                name="endDate"
                                v-model="form.endDate"
                            /><br />
                            <button
                                class="flex mx-auto my-4 text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg"
                            >
                                分析する
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
