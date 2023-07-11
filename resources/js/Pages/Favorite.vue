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
            const res = await fetch(
                "http://localhost/api/quotes/favorite/list"
            );
            const data = await res.json();
            this.quotesList = data?.data;
        },
        async deleteFavorite(quotes) {
            const requestOptions = {
                method: "DELETE",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ quote: quotes }),
            };

            fetch(
                "http://localhost/api/quotes/favorite/delete/" + quotes,
                requestOptions
            )
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
                Favorites
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <ul v-for="quotes in quotesList">
                    <li>
                        <div
                            class="bg-white overflow-hidden shadow-sm sm:rounded-lg"
                        >
                            <div class="p-6 bg-white border-b border-gray-200">
                                <p>
                                    <span>{{ quotes.quote }} </span>
                                    <svg
                                        @click="deleteFavorite(quotes.id)"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke-width="1.5"
                                        stroke="currentColor"
                                        class="w-6 h-6"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"
                                        />
                                    </svg>
                                </p>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
