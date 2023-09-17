<script setup>
import { router } from '@inertiajs/vue3';

const prop = defineProps({
    user: Object
})

const toggleActive = () => {
    router.visit('/users/toggle-active/' + prop.user.id, {
        method: 'POST',
        preserveScroll: true
    });
}
</script>

<template>
    <section>
        <h2 class="text-lg font-medium text-gray-900 flex items-center">User Account Control &nbsp;
            <span>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" />
                  </svg>                  
            </span>
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            You can deactivate this user if no longer part of the organization. You can reactivate it anytime.
        </p>

        <div class="mt-6">
            <button v-if="user.active" @click="toggleActive" class="px-4 py-1.5 rounded-md text-sm flex items-center text-white bg-red-600 hover:bg-red-500 shadow-md">Deactivate this user</button>
            <button v-else @click="toggleActive" class="px-4 py-1.5 rounded-md text-sm flex items-center text-white bg-green-600 hover:bg-green-500 shadow-md">Reactivate this user</button>
        </div>
    </section>
</template>