<script setup>
import { Link, router } from '@inertiajs/vue3';
import { computed, ref, watch } from 'vue';
import { ChevronDoubleLeftIcon, ChevronDoubleRightIcon, ChevronLeftIcon, ChevronRightIcon } from '@heroicons/vue/24/solid'

const props = defineProps({
    data: Object,
    perPage: String,
})

const filteredLinks = computed(() => props.data.links.filter(link => link.label !== 'Previous' && link.label !== 'Next'))

const perPage = computed(() => props.perPage);
// const setPerPage = (event) => {
//     router.get(router.page.url, {
//         perPage: event.target.value
//     }, {
//         preserveState: true,
//     })
//     // console.log(router.page.url)
// }

// const perPage = ref(null)

// watch(perPage, () => {

// })

const emits = defineEmits(['update-per-page']);

const updatePerPage = (ev) => {
    emits('update-per-page', ev.target.value)
}
</script>

<template>
    <div class="flex items-start">
        <div class="text-center">
            <nav class="flex flex-wrap space-x-1">
                <Link v-if="props.data.prev_page_url" :href="props.data.first_page_url" class="h-10 w-10 rounded-full text-sm flex items-center justify-center hover:bg-gray-100">
                    <ChevronDoubleLeftIcon class="w-3 h-3" />
                </Link>
                <span v-else class="h-10 w-10 rounded-full text-sm flex items-center justify-center">
                    <ChevronDoubleLeftIcon class="w-3 h-3" />
                </span>
        
                <Link v-if="props.data.prev_page_url" :href="props.data.prev_page_url" class="h-10 w-10 rounded-full text-sm flex items-center justify-center hover:bg-gray-100">
                    <ChevronLeftIcon class="w-3 h-3" />
                </Link>
                <span v-else class="h-10 w-10 rounded-full text-sm flex items-center justify-center">
                    <ChevronLeftIcon class="w-3 h-3" />
                </span>
        
                <template v-for="link in filteredLinks" :key="link.label">
                    <Link v-if="link.url" :href="link.url"
                    class="h-10 w-10 rounded-full text-sm flex items-center justify-center"
                    :class="[ link.active ? 'bg-blue-50 text-blue-500 font-medium' : 'hover:bg-gray-100' ]"
                    >
                    {{ link.label }}
                    </Link>
                    <span v-else class="h-10 w-10 rounded-full text-sm flex items-center justify-center hover:bg-gray-100">
                        {{ link.label }}
                    </span>
                </template>
        
                <Link v-if="props.data.next_page_url" :href="props.data.next_page_url" class="h-10 w-10 rounded-full text-sm flex items-center justify-center hover:bg-gray-100">
                    <ChevronRightIcon class="w-3 h-3" />
                </Link>
                <span v-else class="h-10 w-10 rounded-full text-sm flex items-center justify-center">
                    <ChevronRightIcon class="w-3 h-3" />
                </span>
        
                <Link v-if="props.data.next_page_url" :href="props.data.last_page_url" class="h-10 w-10 rounded-full text-sm flex items-center justify-center hover:bg-gray-100">
                    <ChevronDoubleRightIcon class="w-3 h-3" />
                </Link>
                <span v-else class="h-10 w-10 rounded-full text-sm flex items-center justify-center">
                    <ChevronDoubleRightIcon class="w-3 h-3" />
                </span>
            </nav>
    
            <span class="text-sm text-gray-600 mt-4">Showing {{ props.data.from || 0 }} to {{ props.data.to || 0 }} records of {{ props.data.total }}</span>
        </div>
    
        <div>
            <select id="per-page" @change="updatePerPage($event)" class="ml-2 text-sm rounded-md border-gray-300">
                <option value="" :selected="perPage == ''">5</option>
                <option value="10" :selected="perPage == 10">10</option>
                <option value="15" :selected="perPage == 15">15</option>
                <option value="20" :selected="perPage == 20">20</option>
                <option value="25" :selected="perPage == 25">25</option>
            </select>
        </div>
    </div>
</template>