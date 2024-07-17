<template>
    <nav class="navbar navbar-expand navbar-bg bg-primary">
        <a class="sidebar-toggle" @click="$emit('toggle-sidebar')">
            <i class="hamburger align-self-center"></i>
        </a>

        <div class="navbar-collapse collapse">
            <ul class="navbar-nav navbar-align">
                <li class="nav-item dropdown">
                    <a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
                        <i class="align-middle" data-lucide="settings"></i>
                    </a>

                    <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">
                        <span>{{ userName }} &nbsp;</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end">

                        <Link class="dropdown-item" method="post" href="/logout" as="button">Sign out</Link>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</template>


<script setup>
import { Link } from "@inertiajs/vue3";
import { ref, onMounted } from 'vue';
import axios from 'axios';

const emit = defineEmits(["toggle-sidebar"]);
const userName = ref('');
const users = ref([]);

onMounted(async () => {
  try {
    const usernameResponse = await axios.get('/users-with-roles');
    const userData = usernameResponse.data;

    if (userData && userData.length > 0) {
      users.value = userData;
      userName.value = userData[0].name;
    } else {
      console.error('No user data found');
    }

  } catch (error) {
    console.error('Error fetching data:', error);
  }
});

</script>
