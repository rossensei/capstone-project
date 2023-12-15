<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Paginator from '@/Components/Paginator.vue';
import { Head, Link, useForm, router } from '@inertiajs/vue3';
import debounce from 'lodash/debounce';
import { ref, watch } from 'vue';

const props = defineProps({
    properties: Object,
    filters: Object
})

const searchKey = ref(props.filters.search)

watch(searchKey, debounce(() => {
    let params = {
        search: searchKey.value
    }

    Object.keys(params).forEach(key => {
        if(params[key] === undefined || params[key] === '' || params[key] === null) {
            delete params[key]
        }
    })

    router.get('/find-property', params, { preserveState: true, replace: true });
    
}, 300))

const submit = () => {
    router.get('/find-property/search/' + searchKey.value, {
        preserveState: true
    })
}
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <div class="py-4">
            <div class="w-full sm:px-6 lg:px-8">
                <h2 class="font-semibold text-3xl text-gray-700 leading-tight mb-4">Find Property</h2>
                <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only">Search</label>
                <div class="relative">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                        </svg>
                    </div>
                    <input v-model="searchKey" type="search" id="default-search" class="block w-full p-4 ps-10 text-sm text-gray-900 bg-white border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" placeholder="Search property by tag number" autocomplete="off">
                    <button type="button" @click="searchKey = ''" class="absolute right-3 top-1/2 -translate-y-1/2 inline-flex items-center px-4 py-2 text-sm font-medium rounded-md bg-[#4e73df] hover:bg-[#4e72dfc0] text-white">
                        Clear
                    </button>
                </div>

                <!-- <div class="flex items-center space-x-2 space-y-2 flex-wrap">
                    <div v-for="property in properties.data" :key="property.id" class="flex-1 min-w-[300px] bg-white p-4 rounded-md shadow-md">
                      <h2 class="text-lg font-semibold mb-2">{{ property.name }}</h2>
                      <p class="text-gray-600 mb-2">{{ property.description }}</p>
                      <p class="text-gray-600 mb-2">{{ property.office }}</p>
                      <p class="text-gray-600">{{ new Date(property.date_acquired).toLocaleDateString() }}</p>
                    </div>
                
                  </div> -->
                <!-- <h4 class="text-xl text-gray-600 font-semibold">Property</h4> -->
                <div class="mt-4 p-4 bg-white rounded-lg shadow">
                    

                    <div class="relative overflow-x-auto">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        Tag No
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Property Name
                                    </th>
                                    <th scope="col" class="w-[20rem] px-6 py-3">
                                        Description
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Office
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Acquisition Date
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="property in properties.data" :key="property.id" class="bg-white border-b">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        {{ property.tag_no }}
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ property.name }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ property.description }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ property.office }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ new Date(property.date_acquired).toLocaleDateString() }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="flex items-center justify-center mt-5">
                        <Paginator
                        :links="props.properties.links"
                        :first_page_url="props.properties.first_page_url"
                        :last_page_url="props.properties.last_page_url"
                        :prev_page_url="props.properties.prev_page_url"
                        :next_page_url="props.properties.next_page_url"
                        />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
