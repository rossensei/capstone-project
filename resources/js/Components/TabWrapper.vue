<script setup>
import { useSlots, ref, provide } from 'vue';

const slots = useSlots();
const tabTitles = ref(slots.default().map((tab) => tab.props.title))
const selectedTitle = ref(tabTitles.value[0])

provide('title', selectedTitle);
</script>
<template>
    <div class="md:flex">
        <ul class="w-80 flex-column space-y space-y-4 text-sm font-medium text-gray-500 md:me-4 mb-4 md:mb-0">
            <li v-for="title in tabTitles" :key="title">
                <a href="#" class="inline-flex items-center px-4 py-3 hover:bg-gray-100 w-full rounded-md" @click="selectedTitle = title">
                    {{ title }}
                </a>
            </li>
        </ul>
        <div class="p-6 bg-gray-50 text-medium text-gray-500 rounded-lg w-full">
            <slot />
        </div>
    </div>
</template>