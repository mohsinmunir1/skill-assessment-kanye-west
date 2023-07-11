<script>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import BreezeButton from "@/Components/Button.vue";
import { Head } from "@inertiajs/inertia-vue3";

export default {
    components: {
        BreezeAuthenticatedLayout,
        BreezeButton,
    },

    data() {
        return {
            quotesList: [],
        };
    },

    mounted() {
        this.getData();
    },

    methods: {
        async getData() {
            const requestOptions = {
                method: "GET",
                headers: { "Content-Type": "application/json" },
            };

            const res = await fetch("http://localhost/api/v1/quotes", requestOptions);
            const data = await res.json();
            this.quotesList = data?.data;
        },
        async saveFavorite(quotes) {
            const requestOptions = {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ quote: quotes }),
            };

            fetch("http://localhost/api/quotes/favorite", requestOptions)
                .then((response) => response.json())
                .then((data) => (this.postId = data.id));
        },
    },
};
</script>

<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="text-end py-4">
                    <BreezeButton @click="getData" class="ml-4">
                        Refresh
                    </BreezeButton>
                </div>
                <ul v-for="quotes in quotesList">
                    <li>
                        <div
                            class="bg-white overflow-hidden shadow-sm sm:rounded-lg"
                        >
                            <div class="p-6 bg-white border-b border-gray-200">
                                <p class="flex">
                                    <svg
                                        @click="saveFavorite(quotes)"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke-width="1.5"
                                        stroke="currentColor"
                                        class="w-6 h-6 pr-3"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z"
                                        />
                                    </svg>
                                    <span>{{ quotes }} </span>

                                </p>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
