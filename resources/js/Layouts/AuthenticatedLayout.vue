<script setup>
import { ref, onMounted, onBeforeUnmount, watch } from 'vue';
import { ChartPieIcon, UserGroupIcon, BuildingOfficeIcon, CubeIcon, Square3Stack3DIcon, ChevronUpIcon, DocumentTextIcon } from '@heroicons/vue/24/solid';
import {
    Disclosure,
    DisclosureButton,
    DisclosurePanel,
  } from '@headlessui/vue'
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import GlobalSearchComponent from '@/Components/GlobalSearchComponent.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link, usePage } from '@inertiajs/vue3';

const showingNavigationDropdown = ref(false);

let isCollapsed = ref(localStorage.getItem("isCollapsed") === "true");
const hidden = ref(false);

const props = defineProps({
    flash: Object,
})

const collapseSidebar = () => {
    
    isCollapsed.value = !isCollapsed.value;
    localStorage.setItem("isCollapsed", isCollapsed.value);
}

const clearLocalStorage = () => {
    localStorage.clear();
}

const getScreenWidth = () => {
    return window.innerWidth;
}

const screenWidth = ref(getScreenWidth())

const handleResize = () => {
    screenWidth.value = getScreenWidth();

    if(screenWidth.value <= 768) {
        isCollapsed.value = true;
    }
    else {
        isCollapsed.value = false;
    }
}

onMounted(() => {
    window.addEventListener('resize', handleResize)
})

onBeforeUnmount(() => {
    window.removeEventListener('resize', handleResize);
})

const currentRoute = ref(window.location.pathname);

const isActive = (route) => {
    return currentRoute.value === route;
};

const openPurchaseDropdown = ref(false);

const handlePurchaseDropdown = () => {
    openPurchaseDropdown.value = !openPurchaseDropdown.value;
}


</script>

<template>
    <div>
        <div class="flex items-start min-h-screen bg-gray-50">
            <nav class="hidden sm:block sticky top-0 z-10 bg-[#4e73df] min-h-screen duration-300 lg:w-64 w-16">
                <div class="relative p-4">
                    <div class="flex mb-4" :class="[ !isCollapsed ? 'justify-between items-center' : 'justify-center']">
                        <!-- Logo branding -->
                        <Link :href="route('dashboard')" class="w-full flex items-center space-x-2">
                            <img src="../Components/images/mdc-logo.png" alt="mdc-logo" class="w-10">
                            <h1 v-show="!isCollapsed" class="text-md text-white font-semibold text-center">MDC-IMS</h1>
                        </Link>
    
                    </div>
                    <span class="absolute -right-8 top-5 bg-gray-400 bg-opacity-75 text-gray-50 rounded-lg p-1.5 text-center text-sm cursor-pointer peer" @click="collapseSidebar">
                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-[15px] h-[15px] duration-75" :class="[ isCollapsed ? 'rotate-180 peer-hover:translate-x-2' : 'rotate-0 peer-hover:-translate-x-2']">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18.75 19.5l-7.5-7.5 7.5-7.5m-6 15L5.25 12l7.5-7.5" />
                          </svg>                     
                    </span> 
    
                    <span class="text-[10px] mb-2 text-gray-200 select-none font-bold uppercase" :class="[ isCollapsed ? 'mt-24 text-center' : '']">Menu</span>
                    <ul class="space-y-2" :class="[ isCollapsed ? 'flex flex-col' : '']">
                        <li>
                            <NavLink :href="route('dashboard')" :active="route().current('dashboard')" class="inline-flex items-center">
                                <ChartPieIcon class="w-5 h-5" />
                                <span class="ml-2" v-show="!isCollapsed">Dashboard</span>
                            </NavLink>
                        </li>
                        <!-- <li>
                            <a href="#" class="flex justify-between w-full px-2 py-2 items-center text-sm leading-5 rounded-md hover:bg-[#7290e8] text-gray-200 transition duration-150 ease-in-out" @click="handlePurchaseDropdown">
                                <div class="inline-flex items-center">
                                    <DocumentTextIcon class="w-5 h-5" />
                                    <span class="flex-1 ml-2" v-show="!isCollapsed">Purchases</span>
                                </div>
                                
                                <ChevronUpIcon class="w-3 h-3" :class="{ 'rotate-180' : openPurchaseDropdown }" />
                            </a>
                            <div v-if="openPurchaseDropdown">
                                <ul class="w-full space-y-2 font-medium">
                                    <li>
                                        <NavLink href="/new-purchased-item" :active="isActive('/new-purchased-item')" class="flex items-center pl-10">New Item</NavLink>
                                    </li>
                                    <li>
                                        <NavLink href="/new-purchased-property" :active="isActive('/new-purchased-property')" class="flex items-center pl-10">New Property</NavLink>
                                    </li>
                                </ul>
                            </div>
                        </li> -->
                        <li>
                            <NavLink :href="route('department.index')" :active="route().current('department.index')" class="flex items-center">
                                <BuildingOfficeIcon class="w-5 h-5" />
                                <span class="ml-2" v-show="!isCollapsed">Departments</span>
                            </NavLink>
                        </li>
                        <li>
                            <NavLink :href="route('users.index')" :active="route().current('users.index')" class="inline-flex items-center">
                                <UserGroupIcon class="w-5 h-5" />
                                <span class="ml-2" v-show="!isCollapsed">Users</span>
                            </NavLink>
                        </li>
                        <li>
                            <NavLink :href="route('item.index')" :active="route().current('item.index')" class="flex items-center">
                                <CubeIcon class="w-5 h-5" />
                                <span class="ml-2" v-show="!isCollapsed">Items</span>
                            </NavLink>
                        </li>
                        <li>
                            <NavLink :href="route('property.index')" :active="route().current('property.index')" class="flex items-center">
                                <Square3Stack3DIcon class="w-5 h-5" />
                                <span class="ml-2" v-show="!isCollapsed">Properties</span>
                            </NavLink>
                        </li>
                    </ul>
                </div>
            </nav>
            <div class="flex-1 min-h-screen overflow-hidden">
                <div class="w-full p-4">
                    <div class="flex justify-between items-center">
                        <!-- Search -->
                        <GlobalSearchComponent />
                        
                        <div class="ml-3 relative">
                            <Dropdown align="right" width="48">
                                <template #trigger>
                                    <span class="inline-flex rounded-md">
                                        <button
                                            type="button"
                                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 hover:text-gray-700 focus:outline-none transition ease-in-out duration-150"
                                        >
                                            <!-- {{ $page.props.auth.user.name }} -->
                                            
                                            <img v-if="$page.props.auth.user.profile_photo" :src="$page.props.auth.user.profile_photo_url" class="ml-2 h-7 w-7 rounded-full" alt="">
                                            <img v-else src="../Components/images/user-icon.png" class="ml-2 h-7 w-7 rounded-full" alt="">
                                        </button>
                                    </span>
                                </template>

                                <template #content>
                                    <span class="block w-full px-4 py-2 leading-5 text-sm font-medium border-b text-gray-600 text-center">{{ $page.props.auth.user.name }}</span>
                                    <DropdownLink :href="route('profile.edit')"> Profile </DropdownLink>
                                    <DropdownLink :href="route('logout')" method="post" as="button" @click="clearLocalStorage">
                                        Log Out
                                    </DropdownLink>
                                </template>
                            </Dropdown>
                        </div>
                    </div>
                    
                </div>
                  
                <main>
                    <slot />
                </main>
            </div>
        </div>
    </div>
</template>