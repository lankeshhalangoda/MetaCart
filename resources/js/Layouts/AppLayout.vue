<script setup>
import { ref } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import Footer from '@/Components/Footer.vue';
import Navbar from '@/Components/Navbar.vue';
import Sidebar from '@/Components/Sidebar.vue';


const isSidebarOpen = ref(true);

const toggleSidebar = () => {
    isSidebarOpen.value = !isSidebarOpen.value;
};

defineProps({
    title: String,
});
</script>

<template>

    <Head :title="title ? title : 'KOT'">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </Head>

    <div class="wrapper">
        <Sidebar :isSidebarOpen="isSidebarOpen" />
        <div class="main">
            <Navbar @toggle-sidebar="toggleSidebar" />

            <main class="content">
                <div class="container-fluid p-0">

                    <slot name="content" />
                </div>
            </main>

            <Footer />
        </div>
    </div>

</template>
