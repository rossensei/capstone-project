<script setup>
import { XMarkIcon, InformationCircleIcon, CheckCircleIcon, ExclamationTriangleIcon } from '@heroicons/vue/20/solid';
import { usePage } from '@inertiajs/vue3';
import { computed, ref, watch } from 'vue';

const show = ref(true);

const page = usePage();
const flash = computed(() => page.props.flash);

watch(() => flash, () => {
    show.value = true;

}, {
    deep: true,
})

const closeAlert = () => {
    show.value = false;

    // if(page.props.flash.success) {
    //     page.props.flash.success = null;
    // }

    // if(page.props.flash.error) {
    //     page.props.flash.error = null;
    // }
}

// BUG IN THE TITLE PROP NEEDS TO BE FIXED

const title = computed(() => {
    if(flash.success) {
        return 'Success';
    } else {
        return 'Error';
    }
})

</script>

<template>

    <transition leave-active-class="duration-300" leave-to-class="opacity-0">
        <div v-show="(flash.success || flash.error) && show" class="flex p-4 rounded-md space-x-3" :class="[flash.success ? 'bg-green-100' : 'bg-red-100']">
            <div class="shrink-0">
                <CheckCircleIcon v-if="flash.success" class="w-6 h-6 text-green-500" />
                <ExclamationTriangleIcon v-else class="w-6 h-6 text-red-500" />
            </div>
            <div class="flex-1">
                <h2 class="font-medium" :class="[flash.success ? 'text-green-900' : 'text-red-900']">{{ title }}</h2>
                <div class="text-sm" :class="[flash.success ? 'text-green-800' : 'text-red-800']">
                    {{ flash.success || flash.error }}
                </div>
            </div>
            <div class="shrink-0">
                <button @click="closeAlert" class="p-0.5 rounded-md" :class="[flash.success ? 'text-green-900 hover:bg-green-200' : 'text-red-900 hover:bg-red-200']">
                    <XMarkIcon class="w-6 h-6" />
                </button>
            </div>
        </div>
    </transition>
</template>
