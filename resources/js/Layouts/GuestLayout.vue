<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
import { ref, onMounted, onBeforeUnmount, computed} from 'vue';


const screenWidth = ref(window.innerWidth);

const isSmallScreen = computed(() => {
    return screenWidth.value <= 768;
});

const handleResize = () => {
    screenWidth.value = window.innerWidth;
}

onMounted(() => {
    window.addEventListener('resize', handleResize)
})

onBeforeUnmount(() => {
    window.removeEventListener('resize', handleResize)
})
</script>

<template>
<div class="flex justify-center items-center min-h-screen bg-[#7a94e0]">

    <div class="z-20 flex max-w-7xl mx-auto shadow-md rounded-lg h-[40rem]">
        <div class="w-1/2 bg-[#4e73df] rounded-l-lg">
            <div class="p-12">
                <img src="../Components/images/data-report.png" alt="" class="w-[22rem] mx-auto">
                <h4 class="text-xl font-semibold text-white">Mater Dei College</h4>
                <h1 class="text-4xl font-bold text-white">Inventory Management System</h1>
            </div>
        </div>
        <div class="w-1/2 bg-white flex items-center rounded-r-lg relative">
            <img src="../Components/images/mdc-logo.png" alt="mdc-logo" class="w-[8rem] absolute top-9 left-1/2 -translate-x-1/2">
            <div class="p-12 w-full">
                <h4 class="text-2xl font-bold text-gray-600 mb-2">Sign in to your account</h4>
                <div v-if="$page.props.flash.success" class="p-4 text-sm text-green-600 bg-green-100 rounded-lg mb-3">{{ $page.props.flash.success }}</div>
                <slot />
            </div>
        </div>
    </div>
    <div class="area" >
        <ul class="circles">
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
        </ul>
    </div>
</div>
</template>

<style scoped>

.area{
    position: absolute;
    background: #7a94e0;  
    background: -webkit-linear-gradient(to left, #8f94fb, #4e54c8);  
    width: 100%;
    height:100vh;
    
   
}

.circles{
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    overflow: hidden;
}

.circles li{
    position: absolute;
    display: block;
    list-style: none;
    width: 20px;
    height: 20px;
    background: rgba(255, 255, 255, 0.2);
    animation: animate 25s linear infinite;
    bottom: -150px;
    
}

.circles li:nth-child(1){
    left: 25%;
    width: 80px;
    height: 80px;
    animation-delay: 0s;
}


.circles li:nth-child(2){
    left: 10%;
    width: 20px;
    height: 20px;
    animation-delay: 2s;
    animation-duration: 12s;
}

.circles li:nth-child(3){
    left: 70%;
    width: 20px;
    height: 20px;
    animation-delay: 4s;
}

.circles li:nth-child(4){
    left: 40%;
    width: 60px;
    height: 60px;
    animation-delay: 0s;
    animation-duration: 18s;
}

.circles li:nth-child(5){
    left: 65%;
    width: 20px;
    height: 20px;
    animation-delay: 0s;
}

.circles li:nth-child(6){
    left: 75%;
    width: 110px;
    height: 110px;
    animation-delay: 3s;
}

.circles li:nth-child(7){
    left: 35%;
    width: 150px;
    height: 150px;
    animation-delay: 7s;
}

.circles li:nth-child(8){
    left: 50%;
    width: 25px;
    height: 25px;
    animation-delay: 15s;
    animation-duration: 45s;
}

.circles li:nth-child(9){
    left: 20%;
    width: 15px;
    height: 15px;
    animation-delay: 2s;
    animation-duration: 35s;
}

.circles li:nth-child(10){
    left: 85%;
    width: 150px;
    height: 150px;
    animation-delay: 0s;
    animation-duration: 11s;
}



@keyframes animate {

    0%{
        transform: translateY(0) rotate(0deg);
        opacity: 1;
        border-radius: 0;
    }

    100%{
        transform: translateY(-1000px) rotate(720deg);
        opacity: 0;
        border-radius: 50%;
    }

}
/*

.animation-delay-1000 {
    animation-delay: 2s;
}

.animation-delay-2000 {
    animation-delay: 2s;
}

.animation-delay-3000 {
    animation-delay: 2s;
}

.animation-delay-5000 {
    animation-delay: 5s;
}

.animate-blob {
    animation-name: blob;
    animation-duration: 7s;
    animation-iteration-count: infinite;
}

@keyframes blob {
    0% { transform: translate(0px, 0px) scale(1)  }
    33% { transform: translate(-30px, -50px) scale(1.1) }
    66% { transform: translate(-20px, 20px) scale(0.9) }
    100% { transform: translate(0px, 0px) scale(1)  }
}
*/
</style>
