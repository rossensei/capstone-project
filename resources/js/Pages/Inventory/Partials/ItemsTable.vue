<script setup>

defineProps({
    items: Array
})
</script>

<template>
    <table class="w-full text-sm text-left text-gray-500">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
            <tr>
                <th scope="col" class="p-4">
                    <div class="flex items-center">
                        <input id="checkbox-all-search" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                        <label for="checkbox-all-search" class="sr-only">checkbox</label>
                    </div>
                </th>
                <th scope="col" class="px-6 py-3">
                    Item
                </th>
                <th scope="col" class="px-6 py-3">
                    Size
                </th>
                <th scope="col" class="px-6 py-3">
                    Category
                </th>
                <th scope="col" class="px-6 py-3">
                    Qty
                </th>
                <th scope="col" class="px-6 py-3">
                    Used
                </th>
                <th scope="col" class="px-6 py-3">
                    Current Stock
                </th>
                <th scope="col" class="px-6 py-3">
                    Expiry Date
                </th>
                <th scope="col" class="px-6 py-3">
                    Action
                </th>
            </tr>
        </thead>
        <tbody>
            <tr class="bg-white border-b hover:bg-gray-50">
                <td class="w-4 p-4">
                    <div class="flex items-center">
                        <input id="checkbox-table-search-1" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                        <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                    </div>
                </td>
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                    Brown Envelope
                </th>
                <td class="px-6 py-4">
                    Long
                </td>
                <td class="px-6 py-4">
                    School Supplies
                </td>
                <td class="px-6 py-4">
                    1336 pcs
                </td>
                <td class="px-6 py-4">
                    160
                </td>
                <td class="px-6 py-4">
                    1176 out of 1336 pcs
                    <div id="progress-bar" class="w-full bg-gray-200 rounded-full h-auto">
                        <div id="percentage" class="bg-green-500 rounded-full h-2" :style="{ 'width': (1176/1336) * 100 + '%' }"></div>
                    </div>
                </td>
                <td class="px-6 py-4">
                    N/A
                </td>
                <td class="flex items-center px-6 py-4 space-x-3">
                    <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                    <a href="#" class="font-medium text-red-600 dark:text-red-500 hover:underline">Remove</a>
                </td>
            </tr>
        </tbody>
    </table>
</template>