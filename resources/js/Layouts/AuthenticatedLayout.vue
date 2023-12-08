<script setup>
import { ref, onMounted, onBeforeUnmount, watch } from 'vue';
import { ChartPieIcon, UserGroupIcon, BuildingOfficeIcon, CubeIcon, 
    Square3Stack3DIcon, ChevronLeftIcon, DocumentTextIcon, UserIcon, 
    ArrowRightOnRectangleIcon, SquaresPlusIcon, CurrencyPoundIcon, RectangleStackIcon,
    UserCircleIcon
} from '@heroicons/vue/24/solid';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import GlobalSearchComponent from '@/Components/GlobalSearchComponent.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link, usePage } from '@inertiajs/vue3';
import { Menu, MenuButton, MenuItems, MenuItem } from '@headlessui/vue'

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

const currentUrl = ref(window.location.pathname);
</script>

<template>
    <div>
        <div class="flex items-start min-h-screen bg-gray-50">
            <nav class="hidden sm:block sticky top-0 z-10 bg-[#4e73df] min-h-screen duration-300" :class="[ isCollapsed ? 'w-16' : 'w-64']">
                <div class="relative min-h-screen p-4">
                    <div id="trigger" 
                    :class="[isCollapsed ? 'rotate-0' : 'rotate-180']"
                    class="absolute -right-8 top-1/2 -translate-y-1/2 opacity-[0.25] hover:opacity-[1] transition-transform" @click="collapseSidebar">
                        <button>
                            <div class="flex h-[72px] w-8 items-center justify-center ">
                                <div v-if="!isCollapsed" class="flex flex-col-reverse items-center h-6 w-6">
                                    <div id="icon-upper-portion" class="-mt-1 h-3 w-1 rounded-full bg-[#343541] ease-in-out duration-200"></div>
                                    <div id="icon-lower-portion" class="-mb-1 h-3 w-1 rounded-full bg-[#343541] ease-in-out duration-200"></div>
                                </div>
                                <div v-else class="flex flex-col-reverse items-center h-6 w-6">
                                    <div id="icon-upper-portion" class="-mt-1 h-3 w-1 rounded-full bg-[#343541] ease-in-out duration-200"></div>
                                    <div id="icon-lower-portion" class="-mb-1 h-3 w-1 rounded-full bg-[#343541] ease-in-out duration-200"></div>
                                </div>
                            </div>
                        </button>
                    </div>
    

                    <div class="flex mb-4" :class="[ !isCollapsed ? 'justify-between items-center' : 'justify-center']">
                        <!-- Logo branding -->
                        <Link :href="route('dashboard')" class="w-full flex items-center space-x-2">
                            <img src="../Components/images/mdc-logo.png" alt="mdc-logo" class="w-10">
                            <h1 v-show="!isCollapsed" class="text-md text-white font-semibold text-center">MDC-IMS</h1>
                        </Link>
    
                    </div>

    
                    <span class="text-[10px] mb-2 text-gray-200 select-none font-bold uppercase" :class="[ isCollapsed ? 'mt-24 text-center' : '']">Menu</span>
                    <ul class="space-y-2" :class="[ isCollapsed ? 'flex flex-col' : '']">
                        <li>
                            <NavLink :href="route('dashboard')" :active="route().current('dashboard')" class="inline-flex items-center">
                                <ChartPieIcon class="w-5 h-5" />
                                <span class="ml-2" v-show="!isCollapsed">Dashboard</span>
                            </NavLink>
                        </li>
                        <li>
                            <NavLink href="/admin/purchases" :active="currentUrl === '/admin/purchases'" class="flex items-center">
                                <DocumentTextIcon class="w-5 h-5" />    
                                <span class="ml-2" v-show="!isCollapsed">Purchases</span>
                            </NavLink>
                        </li>
                        <li>
                            <NavLink href="/admin/categories" :active="currentUrl === '/admin/categories'" class="flex items-center">
                                <SquaresPlusIcon class="w-5 h-5 -rotate-90" />    
                                <span class="ml-2" v-show="!isCollapsed">Categories</span>
                            </NavLink>
                        </li>
                        <li>
                            <NavLink href="/admin/units" :active="currentUrl === '/admin/units'" class="flex items-center">
                                <CurrencyPoundIcon class="w-5 h-5" />    
                                <span class="ml-2" v-show="!isCollapsed">Units</span>
                            </NavLink>
                        </li>
                        <li>
                            <NavLink :href="route('office.index')" :active="route().current('office.index')" class="flex items-center">
                                <BuildingOfficeIcon class="w-5 h-5" />
                                <span class="ml-2" v-show="!isCollapsed">Offices</span>
                            </NavLink>
                        </li>
                        <li>
                            <NavLink href="/admin/personnels" :active="currentUrl === '/admin/personnels'" class="flex items-center">
                                <UserCircleIcon class="w-5 h-5" />
                                <span class="ml-2" v-show="!isCollapsed">Personnels</span>
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
                            <NavLink href="/admin/transactions" :active="currentUrl === '/admin/transactions'" class="flex items-center">
                                <RectangleStackIcon class="w-5 h-5" />    
                                <span class="ml-2" v-show="!isCollapsed">Transactions</span>
                            </NavLink>
                        </li>
                        <!-- <li>
                            <NavLink :href="route('property.index')" :active="route().current('property.index')" class="flex items-center">
                                <Square3Stack3DIcon class="w-5 h-5" />
                                <span class="ml-2" v-show="!isCollapsed">Properties</span>
                            </NavLink>
                        </li> -->
                    </ul>
                </div>
            </nav>
            <div class="relative flex-1 min-h-screen overflow-hidden">
                <div class="w-full p-4">
                    <div class="flex justify-end">
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
                                            {{ $page.props.auth.user.name }}
                                            
                                            <img v-if="$page.props.auth.user.profile_photo" :src="$page.props.auth.user.profile_photo_url" class="ml-2 h-7 w-7 rounded-full" alt="">
                                            <img v-else src="../Components/images/user-icon.png" class="ml-2 h-7 w-7 rounded-full" alt="">
                                        </button>
                                    </span>
                                </template>

                                <template #content>
                                    <DropdownLink :href="route('profile.edit')" class="inline-flex items-center"> 
                                        <UserIcon class="w-4 h-4 mr-2" />  Profile 
                                    </DropdownLink>
                                    <DropdownLink :href="route('logout')" method="post" as="button" @click="clearLocalStorage" class="inline-flex items-center">
                                        <ArrowRightOnRectangleIcon class="w-4 h-4 mr-2" />
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

<style scoped>

#icon-upper-portion {
    transform: translateY(0.15rem) rotate(0deg) translateZ(0px);
}

#trigger:hover #icon-upper-portion {
    transform: translateY(0.15rem) rotate(15deg) translateZ(0px);
}

#icon-lower-portion {
    transform: translateY(-0.15rem) rotate(0deg) translateZ(0px);
}

#trigger:hover #icon-lower-portion {
    transform: translateY(-0.15rem) rotate(-15deg) translateZ(0px);
}
</style>