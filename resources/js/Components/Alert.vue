<script setup>
import { XMarkIcon, InformationCircleIcon, CheckCircleIcon, ExclamationTriangleIcon } from '@heroicons/vue/20/solid';
import { router, usePage } from '@inertiajs/vue3';
import { computed, onBeforeMount, onUnmounted, ref, watch } from 'vue';

const showError = ref(false);
const showSuccess = ref(false);

const page = usePage();

const flash = computed(() => {
    for(let key in page.props.flash) {
        if(page.props.flash.hasOwnProperty(key) && page.props.flash[key] === null) {
            delete page.props.flash[key]
        }
    }

    return page.props.flash;
});

const message = ref('')

watch(flash, () => {
    // console.log(newVal)
    if(Object.keys(flash.value).length !== 0) {
        if(flash.value.hasOwnProperty('success')) {
            showSuccess.value = true;
        } else {
            showError.value = true;
        }
    } else {
        showSuccess.value = false;
        showError.value = false;
    }
})
// watch(() => flash, () => {
//     if(flash.value.error || flash.value.success) {
//         if(flash.value.error) {
//             show.value = true;
//         }
//         if(flash.value.success) {
//             show.value = true;
//         }
//     }
// }, {
//     deep: true,
// })

const closeAlert = () => {
    showSuccess.value = false;
    showError.value = false;
}

const title = computed(() => {
    if(flash.value.error || flash.value.success){
        if(flash.value.error) {
            return 'Error';
        }
        if(flash.value.success) {
            return 'Success';
        }
    }
})

onBeforeMount(() => {
    /* NOTE: show prop is initially false, so normally it won't be updated to true
     * if you're redirected back to the index page from the edit/create page. When that happens,
     * this component will be mounted again and resets the value back to its default. 
     * With onBeforeMount hook, before this component will be mounted again, and this code below executes,
     * checking the flash object if it contains a message and sets the show prop to true.
     */
    // if(Object.keys(flash.value).length !== 0){
    //     // if(page.props.flash.error) {
    //     //     show.value = true;
    //     //     console.log('there is an error')
    //     // }
    //     // if(page.props.flash.success) {
    //     //     show.value = true;
    //     //     console.log('there is a success')
    //     // }
    //     show.value = true;
    // }

    if(Object.keys(flash.value).length !== 0) {
        if(flash.value.hasOwnProperty('success')) {
            showSuccess.value = true;
        } else {
            showError.value = true;
        }
    } else {
        showSuccess.value = false;
        showError.value = false;
    }
})

onUnmounted(() => closeAlert())

</script>

<template>
    <!-- <transition leave-active-class="duration-300" leave-to-class="opacity-0">
        <div v-show="show" class="flex p-4 rounded-md space-x-3" :class="[flash.hasOwnProperty('success') ? 'bg-green-100' : 'bg-red-100']">
            <div class="shrink-0">
                <CheckCircleIcon v-if="flash.hasOwnProperty('success')" class="w-6 h-6 text-green-500" />
                <ExclamationTriangleIcon v-else class="w-6 h-6 text-red-500" />
            </div>
            <div class="flex-1">
                <h2 class="font-medium" :class="[flash.hasOwnProperty('success') ? 'text-green-900' : 'text-red-900']">{{ title }}</h2>
                <div class="text-sm" :class="[flash.hasOwnProperty('success') ? 'text-green-800' : 'text-red-800']">
                    {{ flash.success || flash.error }}
                </div>
            </div>
            <div class="shrink-0">
                <button @click="closeAlert" class="p-0.5 rounded-md" :class="[flash.hasOwnProperty('success') ? 'text-green-900 hover:bg-green-200' : 'text-red-900 hover:bg-red-200']">
                    <XMarkIcon class="w-6 h-6" />
                </button>
            </div>
        </div>
    </transition> -->
    <transition leave-active-class="duration-300" leave-to-class="opacity-0">
        <div v-show="showSuccess" class="flex p-4 rounded-md space-x-3 bg-green-100">
            <div class="shrink-0">
                <CheckCircleIcon class="w-6 h-6 text-green-500" />
            </div>
            <div class="flex-1">
                <h2 class="font-medium text-green-900">{{ title }}</h2>
                <div class="text-sm text-green-800">
                    {{ flash.success }}
                </div>
            </div>
            <div class="shrink-0">
                <button @click="closeAlert" class="p-0.5 rounded-md text-green-900 hover:bg-green-200">
                    <XMarkIcon class="w-6 h-6" />
                </button>
            </div>
        </div>
    </transition>

    <transition leave-active-class="duration-300" leave-to-class="opacity-0">
        <div v-show="showError" class="flex p-4 rounded-md space-x-3 bg-red-100">
            <div class="shrink-0">
                <ExclamationTriangleIcon class="w-6 h-6 text-red-500" />
            </div>
            <div class="flex-1">
                <h2 class="font-medium text-red-900">{{ title }}</h2>
                <div class="text-sm text-red-800">
                    {{ flash.error }}
                </div>
            </div>
            <div class="shrink-0">
                <button @click="closeAlert" class="p-0.5 rounded-md text-red-900 hover:bg-red-200">
                    <XMarkIcon class="w-6 h-6" />
                </button>
            </div>
        </div>
    </transition>
</template>
