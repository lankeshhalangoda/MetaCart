<template>
    <AppLayout title="Products">
        <template #content>
            <div class="row mb-3">
                <div class="col-auto ms-auto">
                    <button class="btn btn-primary" @click="openCreateModal">
                        <i class="bi bi-plus"></i> Create New Product
                    </button>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-auto">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search by name" v-model="searchTerm"
                            @input="debouncedSearch">
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="product in products" :key="product.id">
                            <td>{{ product.name }}</td>
                            <td>{{ product.description }}</td>
                            <td>{{ product.price }}</td>
                            <td>{{ product.stock }}</td>
                            <td>
                                <button class="btn btn-sm btn-primary" @click="openEditModal(product)">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" @click="confirmDeleteProduct(product.id)">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="modal fade" id="createProductModal" tabindex="-1" aria-labelledby="createProductModalLabel"
                aria-hidden="true" ref="createProductModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="createProductModalLabel">Create New Product</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form @submit.prevent="createProduct">
                                <div class="mb-3">
                                    <label for="productName" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="productName" v-model="newProduct.name"
                                        required>
                                </div>
                                <div class="mb-3">
                                    <label for="productDescription" class="form-label">Description</label>
                                    <textarea class="form-control" id="productDescription"
                                        v-model="newProduct.description" required></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="productPrice" class="form-label">Price</label>
                                    <input type="number" class="form-control" id="productPrice"
                                        v-model.number="newProduct.price" required>
                                </div>
                                <div class="mb-3">
                                    <label for="productStock" class="form-label">Stock</label>
                                    <input type="number" class="form-control" id="productStock"
                                        v-model.number="newProduct.stock" required>
                                </div>
                                <button type="submit" class="btn btn-primary float-end">Create</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel"
                aria-hidden="true" ref="editProductModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editProductModalLabel">Edit Product</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form @submit.prevent="updateProduct">
                                <div class="mb-3">
                                    <label for="editProductName" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="editProductName"
                                        v-model="currentProduct.name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="editProductDescription" class="form-label">Description</label>
                                    <textarea class="form-control" id="editProductDescription"
                                        v-model="currentProduct.description" required></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="editProductPrice" class="form-label">Price</label>
                                    <input type="number" class="form-control" id="editProductPrice"
                                        v-model.number="currentProduct.price" required>
                                </div>
                                <div class="mb-3">
                                    <label for="editProductStock" class="form-label">Stock</label>
                                    <input type="number" class="form-control" id="editProductStock"
                                        v-model.number="currentProduct.stock" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Update</button>
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
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import { debounce } from 'lodash';

const searchTerm = ref('');
const products = ref([]);
const newProduct = ref({
    name: '',
    description: '',
    price: null,
    stock: null
});
const currentProduct = ref({
    id: null,
    name: '',
    description: '',
    price: null,
    stock: null
});

onMounted(() => {
    fetchProducts();
});

const debouncedSearch = debounce(() => {
    axios.get('/search-products', {
        params: {
            search_term: searchTerm.value
        }
    })
        .then(response => {
            products.value = response.data;
        })
        .catch(error => {
            console.error('Error searching products:', error);
        });
}, 10);

const fetchProducts = () => {
    axios.get('/api/products')
        .then(response => {
            products.value = response.data;
        })
        .catch(error => {
            console.error('Error fetching products:', error);
        });
};

const searchProducts = () => {
    axios.get('/search-products', {
        params: {
            search_term: searchTerm.value
        }
    })
        .then(response => {
            products.value = response.data;
        })
        .catch(error => {
            console.error('Error searching products:', error);
        });
};


const createProduct = () => {
    axios.post('/api/products', newProduct.value)
        .then(response => {
            products.value.push(response.data);
            newProduct.value = {
                name: '',
                description: '',
                price: null,
                stock: null
            };
            bootstrap.Modal.getInstance(document.getElementById('createProductModal')).hide();
            showAlert('Product created successfully', 'success');
        })
        .catch(error => {
            console.error('Error creating product:', error);
            showAlert('Error creating product', 'error');
        });
};

const openCreateModal = () => {
    bootstrap.Modal.getOrCreateInstance(document.getElementById('createProductModal')).show();
};

const openEditModal = (product) => {
    currentProduct.value = { ...product };
    bootstrap.Modal.getOrCreateInstance(document.getElementById('editProductModal')).show();
};

const updateProduct = () => {
    axios.put(`/api/products/${currentProduct.value.id}`, currentProduct.value)
        .then(response => {
            const index = products.value.findIndex(p => p.id === currentProduct.value.id);
            if (index !== -1) {
                products.value[index] = response.data;
            }
            currentProduct.value = {
                id: null,
                name: '',
                description: '',
                price: null,
                stock: null
            };
            bootstrap.Modal.getInstance(document.getElementById('editProductModal')).hide();
            showAlert('Product updated successfully', 'success');
        })
        .catch(error => {
            console.error('Error updating product:', error);
            showAlert('Error updating product', 'error');
        });
};

const confirmDeleteProduct = (productId) => {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            deleteProduct(productId);
        }
    });
};

const deleteProduct = (productId) => {
    axios.delete(`/api/products/${productId}`)
        .then(response => {
            products.value = products.value.filter(p => p.id !== productId);
            showAlert('Product deleted successfully', 'success');
        })
        .catch(error => {
            console.error('Error deleting product:', error);
            showAlert('Error deleting product', 'error');
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
</script>

<style scoped>
/* Add your custom styles */
</style>
