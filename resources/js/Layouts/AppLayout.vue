<script setup>
import NavLink from '@/Components/NavLink.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import { ChartPieIcon, UserGroupIcon, BuildingOfficeIcon, CubeIcon, Square3Stack3DIcon, ChevronUpIcon, DocumentTextIcon } from '@heroicons/vue/24/solid';
import { Disclosure, DisclosureButton, DisclosurePanel, } from '@headlessui/vue'
import { Link } from "@inertiajs/vue3";
import { ref, watch } from "vue";

const currentRoute = ref(window.location.pathname);

const isActive = (route) => {
    return currentRoute.value === route;
};

const navItems = [
    { href: '/dashboard', active: isActive('/dashboard'), label: 'Dashboard', children: [], icon: ChartPieIcon },
    { href: '#', active: false, label: 'Purchases', children: [
        { href: '/new-purchased-item', active: isActive('/new-purchased-item'), label: 'New Item', children: [], icon: null },
        { href: '/new-purchased-property', active: isActive('/new-purchased-property'), label: 'New Property', children: [], icon: null }
    ], icon: DocumentTextIcon },
    { href: '/departments', active: isActive('/departments'), label: 'Departments', children: [], icon: BuildingOfficeIcon },
    { href: '/users', active: isActive('/users'), label: 'Manage Users', children: [], icon: UserGroupIcon },
    { href: '/items', active: isActive('/items'), label: 'Items', children: [], icon: CubeIcon },
    { href: '/properties', active: isActive('/properties'), label: 'Properties', children: [], icon: Square3Stack3DIcon },
];


</script>

<template>
    <div>
        <div class="flex items-start min-h-screen bg-gray-100">
            <div class="hidden sm:block sticky top-0 z-10 bg-[#4e73df] min-h-screen border-r duration-300 py-4 w-16 lg:w-64">
                <div class="px-4 mb-4">
                    <Link :href="route('dashboard')" class="w-full flex items-center space-x-2">
                        <img src="../Components/images/mdc-logo.png" alt="mdc-logo" class="w-[40px]">
                        <span class="text-lg text-white font-semibold text-center">MDC-IMS</span>
                    </Link>
                </div>

                <nav class="px-4">
                    <span class="text-[10px] mb-2 text-gray-200 select-none font-bold uppercase mt-24 text-center">Menu</span>
                    <ul class="space-y-2 text-sm">
                        <li v-for="(item, index) in navItems" :key="index">
                            <Link 
                            v-if="!item.children.length"
                            :href="item.href" 
                            class="px-3 py-2 inline-flex items-center text-gray-200 hover:bg-[#7290e8] w-full rounded-md"
                            :class="{ 'text-white font-medium' : item.active }"
                            >
                                <Component v-if="item.icon" :is="item.icon" class="w-5 h-5 mr-2" />
                                <span>{{ item.label }}</span>
                            </Link>

                            <Disclosure v-else v-slot="{ open }">
                                <DisclosureButton class="px-3 py-2 inline-flex items-center text-gray-200 hover:bg-[#7290e8] w-full rounded-md text-left">
                                        <Component v-if="item.icon" :is="item.icon" class="w-5 h-5 mr-2" />
                                        <span class="flex-1">{{ item.label }}</span>
                                        <ChevronUpIcon
                                            :class="open ? 'rotate-180 transform' : ''"
                                            class="h-3 w-3 shrink-0"
                                        />
                                </DisclosureButton>
                                <!-- <transition
                                    enter-active-class="transition duration-100 ease-out"
                                    enter-from-class="transform scale-95 opacity-0"
                                    enter-to-class="transform scale-100 opacity-100"
                                    leave-active-class="transition duration-75 ease-out"
                                    leave-from-class="transform scale-100 opacity-100"
                                    leave-to-class="transform scale-95 opacity-0"
                                > -->
                                    <DisclosurePanel>
                                        <div>
                                            <ul class="space-y-2 text-sm">
                                                <li v-for="(child, index) in item.children" :key="index">
                                                    <Link 
                                                    :href="child.href"
                                                    :class="{ 'text-white font-medium' : child.active }" 
                                                    class="p-10 pr-4 py-2 inline-flex items-center text-gray-200 hover:bg-[#7290e8] w-full rounded-md">{{ child.label }}</Link>
                                                </li>
                                            </ul>
                                        </div>
                                    </DisclosurePanel>
                                <!-- </transition> -->
                              </Disclosure>
                        </li>
                    </ul>
                </nav>
            </div>
            <div class="flex-1 min-h-screen overflow-hidden">
                <div class="w-full bg-white p-2 shadow">
                    <div class="flex justify-end items-center">
                        <!-- Search -->
                        <!-- <GlobalSearchComponent /> -->
                        
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
                                    <DropdownLink :href="route('logout')" method="post" as="button">
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