
<template>
  <AppLayout title="Home">
    <template #content>
      <div class="row mb-2 mb-xl-3">

      </div>


      <div class="row">
        <div class="col-12 col-sm-6 col-xxl-4 d-flex">
          <div class="card flex-fill">
            <div class="card-body p-4 d-flex align-items-center justify-content-between">
              <div>
                <h4 class="card-title">Welcome Back, <br><br> {{ userName }}</h4>

              </div>
              <img src="../../../src/img/illustrations/customer-support.png" alt="Customer Support"
                class="img-fluid illustration-img">
            </div>
          </div>
        </div>


        <div class="col-12 col-sm-6 col-xxl-4 d-flex">
          <div class="card flex-fill">
            <div class="card-body py-4 d-flex align-items-center justify-content-between">
              <div>
                <h3 class="mb-2">{{ productsCount }}</h3>
                <p class="mb-2">Total Products</p>
              </div>
              <div class="d-inline-block ms-3">
                <div class="stat">
                  <i class="bi bi-bag-check text-success"></i>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-12 col-sm-6 col-xxl-4 d-flex">
          <div class="card flex-fill">
            <div class="card-body py-4 d-flex align-items-center justify-content-between">
              <div>
                <h3 class="mb-2">{{ ordersCount }}</h3>
                <p class="mb-2">Pending Orders</p>
              </div>
              <div class="d-inline-block ms-3">
                <div class="stat">
                  <i class="bi bi-cart2 text-danger"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Products Table -->
      <div class="row mb-4">
        <div class="col">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Latest Products</h5>
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Stock</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(product, index) in limitedProducts" :key="index">
                    <td>{{ product.name }}</td>
                    <td>{{ product.price }}</td>
                    <td>{{ product.stock }}</td>
                  </tr>
                </tbody>
              </table>
              <a href="/productspage" class="btn btn-primary mt-3 float-end">See More Products</a>
            </div>
          </div>
        </div>
      </div>

      <!-- Orders Table -->
      <div class="row">
        <div class="col">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Latest Orders</h5>
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>Order ID</th>
                    <th>User Name</th>
                    <th>Total</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(order, index) in limitedOrders" :key="index">
                    <td>{{ order.id }}</td>
                    <td>{{ userName }}</td>
                    <td>{{ order.total_price }}</td>
                  </tr>
                </tbody>
              </table>
              <a href="/orderspage" class="btn btn-primary mt-3 float-end">See More Orders</a>
            </div>
          </div>
        </div>
      </div>
    </template>
  </AppLayout>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import AppLayout from '@/Layouts/AppLayout.vue';

const userName = ref('');
const users = ref([]);
const productsCount = ref(0);
const ordersCount = ref(0);
const limitedProducts = ref([]);
const limitedOrders = ref([]);

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



    const productsResponse = await axios.get('/api/products');
    productsCount.value = productsResponse.data.length;
    limitedProducts.value = productsResponse.data.slice(0, 3); // Limit to 3 products

    const ordersResponse = await axios.get('/api/orders');
    ordersCount.value = ordersResponse.data.length;
    limitedOrders.value = ordersResponse.data.slice(0, 3); // Limit to 3 orders
  } catch (error) {
    console.error('Error fetching data:', error);
  }
});

</script>
