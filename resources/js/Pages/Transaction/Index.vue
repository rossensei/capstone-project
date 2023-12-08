<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Breadcrumb from '@/Components/Breadcrumb.vue';
import { Head, Link } from '@inertiajs/vue3';
import { ref } from 'vue';


</script>
<template>
    <Head title="Transactions" />

    <AuthenticatedLayout>
        <div class="py-6">
            <div class="w-full sm:px-6 lg:px-8">
                <h2 class="font-semibold text-3xl text-gray-700 leading-tight mb-4">Transactions</h2>
                <div class="overflow-hidden shadow-sm sm:rounded-lg">
                    
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>