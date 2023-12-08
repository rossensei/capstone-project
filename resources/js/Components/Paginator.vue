<script setup>
import { Link } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import { ChevronDoubleLeftIcon, ChevronDoubleRightIcon, ChevronLeftIcon, ChevronRightIcon } from '@heroicons/vue/24/solid'

const props = defineProps({
    links: Array,
    prev_page_url: String,
    next_page_url: String,
    last_page_url: String,
    first_page_url: String,
})

const filteredLinks = computed(() => props.links.filter(link => link.label !== 'Previous' && link.label !== 'Next'))
</script>

<template>
    <nav class="flex flex-wrap space-x-1">
        <Link v-if="prev_page_url" :href="first_page_url" class="h-10 w-10 rounded-full text-sm flex items-center justify-center hover:bg-gray-100">
            <ChevronDoubleLeftIcon class="w-3 h-3" />
        </Link>
        <span v-else class="h-10 w-10 rounded-full text-sm flex items-center justify-center">
            <ChevronDoubleLeftIcon class="w-3 h-3" />
        </span>

        <Link v-if="prev_page_url" :href="prev_page_url" class="h-10 w-10 rounded-full text-sm flex items-center justify-center hover:bg-gray-100">
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

        <Link v-if="next_page_url" :href="next_page_url" class="h-10 w-10 rounded-full text-sm flex items-center justify-center hover:bg-gray-100">
            <ChevronRightIcon class="w-3 h-3" />
        </Link>
        <span v-else class="h-10 w-10 rounded-full text-sm flex items-center justify-center">
            <ChevronRightIcon class="w-3 h-3" />
        </span>

        <Link v-if="next_page_url" :href="last_page_url" class="h-10 w-10 rounded-full text-sm flex items-center justify-center hover:bg-gray-100">
            <ChevronDoubleRightIcon class="w-3 h-3" />
        </Link>
        <span v-else class="h-10 w-10 rounded-full text-sm flex items-center justify-center">
            <ChevronDoubleRightIcon class="w-3 h-3" />
        </span>
    </nav>
</template>