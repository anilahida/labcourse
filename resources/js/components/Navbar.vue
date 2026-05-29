<template>
    <nav class="bg-white shadow-md rounded-lg p-4 mb-6 flex gap-4">
        <button 
            @click="$emit('change-page', 'clients')"
            :class="['px-4 py-2 font-semibold rounded-md transition-colors', currentPage === 'clients' ? 'bg-blue-500 text-white' : 'text-gray-700 hover:bg-gray-100']">
            Menaxhimi i Klientëve
        </button>

        <button 
            @click="$emit('change-page', 'orders')"
            :class="['px-4 py-2 font-semibold rounded-md transition-colors', currentPage === 'orders' ? 'bg-blue-500 text-white' : 'text-gray-700 hover:bg-gray-100']">
            Porositë
        </button>

        <button 
            @click="$emit('change-page', 'order_details')"
            :class="['px-4 py-2 font-semibold rounded-md transition-colors', currentPage === 'order_details' ? 'bg-blue-500 text-white' : 'text-gray-700 hover:bg-gray-100']">
            Detajet e Porosive
        </button>

        <button 
            @click="$emit('change-page', 'shipments')"
            :class="['px-4 py-2 font-semibold rounded-md transition-colors', currentPage === 'shipments' ? 'bg-blue-500 text-white' : 'text-gray-700 hover:bg-gray-100']">
            Dërgesat
        </button>

        <button 
            @click="$emit('change-page', 'coupons')"
            :class="['px-4 py-2 font-semibold rounded-md transition-colors', currentPage === 'coupons' ? 'bg-blue-500 text-white' : 'text-gray-700 hover:bg-gray-100']">
            Kuponat
        </button>
    </nav>
</template>
<script>
export default {
    props: ['currentPage']
}
</script>