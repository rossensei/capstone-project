<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <!-- <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
       

        <div
            class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg"
        >
            <slot />
        </div>
    </div> -->

    <div class="min-h-screen w-full relative overflow-hidden z-10">
        <img src="../Components/images/mdc-background.jpg" alt="mdc-background" class="object-cover z-0 w-full h-full fixed">

        <div class="z-20 absolute top-0 min-h-screen w-full bg-gradient-to-t bg-black opacity-40"></div>
        <div class="z-30 absolute top-0 h-full w-full">
            <div class="flex justify-center items-center w-full h-full">
                <Transition name="slide-up">
                    <div class="lg:w-1/3 sm:w-1/4 flex flex-col mx-auto bg-white p-6 rounded-lg">
                        <!-- text here -->
                        
                        <img src="../Components/images/mdc-logo.png" alt="" class="w-32 mx-auto mb-3">
                        <h1 class="text-2xl uppercase font-bold font-sans text-center text-gray-500 mb-4">wELCOME BACK!</h1>
        
                        <slot />
                    </div>
                </Transition>
            </div>
        </div>
    </div>
</template>

<style scoped>
/**
.slide-up-enter-active,
.slide-up-leave-active {
  transition: all 0.25s ease-out;
}

.slide-up-enter-from {
  opacity: 0;
  transform: translateY(30px);
}

.slide-up-leave-to {
  opacity: 0;
  transform: translateY(-30px);
}
*/
</style>
