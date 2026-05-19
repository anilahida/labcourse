<template>
    <nav class="bg-white shadow-md rounded-lg p-4 mb-6 flex gap-4">
        <button 
            @click="$emit('change-page', 'clients')" 
            :class="['px-4 py-2 font-semibold rounded-md transition-colors', currentPage === 'clients' ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100']">
            Menaxhimi i Klientëve
        </button>
        <button 
            @click="$emit('change-page', 'orders')" 
            :class="['px-4 py-2 font-semibold rounded-md transition-colors', currentPage === 'orders' ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100']">
            Menaxhimi i Porosive
        </button>
    </nav>
</template>

<script>
export default {
    props: ['currentPage']
}
</script>