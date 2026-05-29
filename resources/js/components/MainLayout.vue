<template>
  <div class="d-flex" style="min-height: 100vh; background-color: #F8F0E5;">
    
    <aside style="width: 250px; background-color: #8B0000;" class="p-4">
      <h4 class="text-white mb-4">Libraria Ime</h4>
      <div class="nav flex-column gap-2">
        <button @click="$emit('change-page', 'orders')" class="btn text-white text-start w-100 border-0">Porositë</button>
        <button @click="$emit('change-page', 'books')" class="btn text-white text-start w-100 border-0">Librat</button>
        <button @click="$emit('change-page', 'clients')" class="btn text-white text-start w-100 border-0">Klientët</button>
      </div>
    </aside>

    <main class="flex-grow-1 p-4">
      <slot />
    </main>
  </div>
</template>

<script>
export default {
  data() {
    return { currentTab: 'orders' }
  }
}
</script>