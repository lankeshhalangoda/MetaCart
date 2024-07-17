<template>
    <nav :class="[{ 'collapsed': !isSidebarOpen }, 'sidebar']" id="sidebar">
        <div class="sidebar-content js-simplebar">
            <a class='sidebar-brand' href='/'>
                <i class="bi bi-stack align-middle"></i>
                <span class="align-middle ms-2">ASSESMENT</span>
            </a>

            <ul class="sidebar-nav">
                <li :class="['sidebar-item', { 'active': activeItem === 'dashboard' }]">
                    <Link class='sidebar-link' href='/' @click="setActiveItem('dashboard')">
                        <i class="bi bi-speedometer align-middle"></i><span class="align-middle">Dashboard</span>
                    </Link>
                </li>

                <li :class="['sidebar-item', { 'active': activeItem === 'products' }]">
                    <a class='sidebar-link' href='/productspage' @click="setActiveItem('products')">
                        <i class="bi bi-box align-middle"></i><span class="align-middle">Products</span>
                    </a>
                </li>

                <li :class="['sidebar-item', { 'active': activeItem === 'orders' }]">
                    <a class='sidebar-link' href='/orderspage' @click="setActiveItem('orders')">
                        <i class="bi bi-grid align-middle"></i><span class="align-middle">Orders</span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</template>

<script setup>
import { ref, watch, onMounted, onUnmounted } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    isSidebarOpen: Boolean
});


watch(() => props.isSidebarOpen, (newVal) => {
    isSidebarOpen.value = newVal;
});

const isSidebarOpen = ref(props.isSidebarOpen);
const activeItem = ref(localStorage.getItem('activeItem') || 'dashboard');

watch(() => props.isSidebarOpen, (newVal) => {
    isSidebarOpen.value = newVal;
});

const setActiveItem = (item) => {
    activeItem.value = item;
    localStorage.setItem('activeItem', item);
};

onUnmounted(() => {
    localStorage.removeItem('activeItem');
});
</script>

<style scoped>
.sidebar-item.active {
    background-color: #f0f0f0;
}
</style>
