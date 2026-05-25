<template>
    <div class="d-flex" style="min-height: 100vh; background-color: #F8F0E5;">
        <div class="sidebar text-white p-3" style="width: 250px; background-color: #8B0000;">
            <h4 class="mb-4">BiblioManager</h4>
            <ul class="nav flex-column">
                <li class="nav-item mb-2">
                    <router-link to="/admin/dashboard" class="nav-link text-white">Dashboard</router-link>
                </li>
                <li class="nav-item mb-2">
                    <router-link to="/admin/books" class="nav-link text-white">Librat</router-link>
                </li>
                <li class="nav-item mb-2">
                    <router-link to="/admin/orders" class="nav-link text-white">Porositë</router-link>
                </li>
                <li class="nav-item mb-2">
                    <router-link to="/admin/clients" class="nav-link text-white">Klientët</router-link>
                </li>
            </ul>
        </div>

        <div class="flex-grow-1 p-4">
            <router-view></router-view> 
        </div>
    </div>
</template>