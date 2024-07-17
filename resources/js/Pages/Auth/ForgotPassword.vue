<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/Form/InputError.vue';
import { Head, useForm } from '@inertiajs/vue3';

defineProps({
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.email'));
};
</script>

<template>
    <GuestLayout>
        <Head title="Forgot Password" />

        <div class="text-center">
            <h1 class="h2">Forgot Password</h1>
            <p class="lead text-start">
                Forgot your password? No problem. Just let us know your email address and we will email you a password
                reset link that will allow you to choose a new one.
            </p>
        </div>

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>

        <div class="mb-3">
            <form @submit.prevent="submit">
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input
                        class="form-control form-control-lg"
                        type="email"
                        id="email"
                        v-model="form.email"
                        required
                        autofocus
                        autocomplete="username"
                        placeholder="Enter your email"
                    />
                    <InputError class="mt-2" :message="form.errors.email" />
                </div>

                <div class="d-grid gap-2 mt-3">
                    <button type="submit" class="btn btn-lg btn-primary" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Email Password Reset Link
                    </button>
                </div>
            </form>
        </div>
    </GuestLayout>
</template>
