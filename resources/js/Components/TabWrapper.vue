<script setup>
import { useSlots, ref, provide } from 'vue';

const slots = useSlots();
const tabTitles = ref(slots.default().map((tab) => tab.props.title))
const selectedTitle = ref(tabTitles.value[0])

provide('title', selectedTitle);
</script>
<template>
    <div class="flex">
        <ul class="flex-column space-y space-y-4 text-sm font-medium text-gray-500">
            <li v-for="title in tabTitles" :key="title" class="me-2">
                <a href="#" 
                class="inline-flex items-center px-4 py-3 w-full border-r-4 rounded-t-sm" 
                :class="[ title === selectedTitle ? 'border-blue-600 text-blue-600 bg-blue-50' : 'hover:text-gray-600 hover:border-gray-300' ]"
                @click="selectedTitle = title">
                    {{ title }}
                </a>
            </li>
        </ul>
        <div class="bg-gray-50 text-medium text-gray-500 rounded-lg flex-1">
            <slot />
        </div>
    </div>
</template>