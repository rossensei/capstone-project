<script setup>
import { ExclamationTriangleIcon } from '@heroicons/vue/24/solid';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    officeId: Number,
    property: Object
})

const emit = defineEmits(['close-modal'])

const deleteProperty = () => {
    router.delete('/admin/offices/' + props.officeId + '/inventory/'+ props.property.id, {
        onFinish: () => emit('close-modal')
    })
}
</script>

<template>
    <div class="w-full p-6">
        <div class="flex space-x-2">
            <div class="shrink-0">
                <ExclamationTriangleIcon class="w-5 h-5 mt-1 text-red-500" />
            </div>
            <div class="flex-1">
                <h2 class="text-lg font-medium text-gray-900">
                    Delete Confirmation
                </h2>

                <p class="mt-1 text-sm text-gray-600">
                    Are you sure you want to remove "{{ property.name }}"? This action cannot be undone.
                </p>
            </div>
        </div>

        <div class="mt-4 flex justify-end">
            <button type="button" @click="$emit('close-modal')"
            class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-medium text-sm text-gray-700 
            shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150"
            > Cancel </button>

            <button
                type="button"
                class="ml-3 inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-medium text-sm text-white hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150"
                @click="deleteProperty"
            >
                Delete
            </button>
        </div>
    </div>
</template>