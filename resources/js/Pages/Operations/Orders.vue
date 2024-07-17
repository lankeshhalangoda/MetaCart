<template>
    <AppLayout title="Orders">
        <template #content>
            <div class="row mb-3">
                <div class="col-auto ms-auto">
                    <button class="btn btn-primary" @click="openCreateModal">
                        <i class="bi bi-plus"></i> Create New Order
                    </button>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>User Name</th>
                            <th>Product</th>
                            <th>Final Total</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="order in orders" :key="order.id">
                            <td>{{ order.id }}</td>
                            <td>{{ getUserFullName(order.user_id) }}</td>
                            <td>
                                <template v-for="(item, index) in order.order_items" :key="index">
                                    <div>
                                        <strong>{{ item.product.name }}</strong><br>
                                        Quantity: {{ item.quantity }}<br>
                                        Total Price: {{ item.quantity * item.product.price }}
                                    </div>
                                    <br v-if="index < order.order_items.length - 1">
                                </template>
                            </td>
                            <td>{{ getOrderTotal(order) }}</td>
                            <td>
                                <button class="btn btn-sm btn-primary" @click="openEditModal(order)">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" @click="deleteOrder(order.id)">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="modal fade" id="createOrderModal" tabindex="-1" aria-labelledby="createOrderModalLabel"
                aria-hidden="true" ref="createOrderModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="createOrderModalLabel">Create New Order</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form @submit.prevent="createOrder">
                                <div class="mb-3">
                                    <label for="userId" class="form-label">User</label>
                                    <select id="userId" class="form-select" v-model="newOrder.user_id" required>
                                        <option v-for="user in users" :key="user.id" :value="user.id">{{
                                            getUserFullName(user.id) }}
                                        </option>
                                    </select>
                                </div>
                                <div v-for="(item, index) in newOrderItems" :key="index" class="mb-3">
                                    <label :for="'productId-' + index" class="form-label">Product {{ index + 1
                                        }}</label>
                                    <select :id="'productId-' + index" class="form-select" v-model="item.product_id"
                                        required>
                                        <option v-for="product in products" :key="product.id" :value="product.id">{{
                                            product.name }}
                                        </option>
                                    </select>
                                    <div class="input-group mt-2">
                                        <span class="input-group-text">Quantity</span>
                                        <input type="number" class="form-control" v-model.number="item.quantity"
                                            required>
                                        <button class="btn btn-danger" type="button"
                                            @click="removeProduct(index)">Remove</button>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <button class="btn btn-info" type="button" @click="addProduct">Add More
                                        Products</button>
                                </div>
                                <button type="submit" class="btn btn-primary float-end">Create</button>
                            </form>
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
import Swal from 'sweetalert2';
import AppLayout from '@/Layouts/AppLayout.vue';

const orders = ref([]);
const users = ref([]);
const products = ref([]);
const newOrder = ref({
    user_id: null,
    total_price: null
});
const newOrderItems = ref([{ product_id: null, quantity: null }]);

onMounted(() => {
    fetchOrders();
    fetchUsers();
    fetchProducts();
});

const fetchOrders = () => {
    axios.get('/api/orders')
        .then(response => {
            orders.value = response.data;
        })
        .catch(error => {
            console.error('Error fetching orders:', error);
        });
};


const fetchUsers = () => {
    axios.get('/users-with-roles')
        .then(response => {
            users.value = response.data;
        })
        .catch(error => {
            console.error('Error fetching users:', error);
        });
};

const fetchProducts = () => {
    axios.get('/api/products')
        .then(response => {
            products.value = response.data;
        })
        .catch(error => {
            console.error('Error fetching products:', error);
        });
};


const createOrder = () => {
    const invalidOrderItems = newOrderItems.value.filter(item => {
        const product = products.value.find(p => p.id === item.product_id);
        return product && item.quantity > product.stock;
    });

    if (invalidOrderItems.length > 0) {
        const remainingStock = invalidOrderItems.map(item => {
            const product = products.value.find(p => p.id === item.product_id);
            return product ? product.stock : 'Unknown';
        }).join(', ');

        showAlert(`Only ${remainingStock} item(s) left.`, 'error');
        return;
    }

    const orderItems = newOrderItems.value.map(item => ({
        product_id: item.product_id,
        quantity: item.quantity,
        total_price: item.quantity * products.value.find(p => p.id === item.product_id)?.price || 0
    }));

    const orderData = {
        user_id: newOrder.value.user_id,
        total_price: newOrder.value.total_price,
        order_items: orderItems
    };

    axios.post('/api/orders', orderData)
        .then(response => {
            response.data.order_items.forEach(item => {
                const product = products.value.find(p => p.id === item.product_id);
                if (product) {
                    product.stock -= item.quantity;
                }
            });

            orders.value.push(response.data);
            newOrder.value = {
                user_id: null,
                total_price: null
            };
            newOrderItems.value = [{ product_id: null, quantity: null }];
            bootstrap.Modal.getInstance(document.getElementById('createOrderModal')).hide();
            showAlert('Order created successfully', 'success');
        })
        .catch(error => {
            console.error('Error creating order:', error);
            showAlert('Error creating order', 'error');
        });
};

const showAlert = (message, type) => {
    Swal.fire({
        icon: type,
        title: message,
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 1500,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer);
            toast.addEventListener('mouseleave', Swal.resumeTimer);
        }
    });
};

const openCreateModal = () => {
    bootstrap.Modal.getOrCreateInstance(document.getElementById('createOrderModal')).show();
};

const openEditModal = (order) => {
    Swal.fire({
        icon: 'info',
        title: 'Edit Order',
        text: 'Editing orders is not allowed',
    });
};

const deleteOrder = (orderId) => {
    Swal.fire({
        icon: 'info',
        title: 'Delete Order',
        text: 'Deleting orders is not allowed',
    });
};

const addProduct = () => {
    newOrderItems.value.push({ product_id: null, quantity: null });
};

const removeProduct = (index) => {
    newOrderItems.value.splice(index, 1);
};

const getUserFullName = (userId) => {
    const user = users.value.find(u => u.id === userId);
    return user ? user.name : 'Unknown User';
};

const getOrderTotal = (order) => {
    let orderTotal = 0;
    order.order_items.forEach(item => {
        orderTotal += item.quantity * item.product.price;
    });
    return orderTotal;
};
</script>
