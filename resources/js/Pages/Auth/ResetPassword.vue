<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/Form/InputError.vue';
import { Head, useForm } from '@inertiajs/vue3';

const props = defineProps({
    email: {
        type: String,
        required: true,
    },
    token: {
        type: String,
        required: true,
    },
});

const form = useForm({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('password.store'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Reset Password" />

        <div class="text-center">
            <h1 class="h2">Reset Password</h1>
            <p class="lead">
                Enter your email and new password to reset your password
            </p>
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

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input
                        class="form-control form-control-lg"
                        type="password"
                        id="password"
                        v-model="form.password"
                        required
                        autocomplete="new-password"
                        placeholder="Enter your new password"
                    />
                    <InputError class="mt-2" :message="form.errors.password" />
                </div>

                <div class="mb-3">
                    <label class="form-label">Confirm Password</label>
                    <input
                        class="form-control form-control-lg"
                        type="password"
                        id="password_confirmation"
                        v-model="form.password_confirmation"
                        required
                        autocomplete="new-password"
                        placeholder="Confirm your new password"
                    />
                    <InputError class="mt-2" :message="form.errors.password_confirmation" />
                </div>

                <div class="d-grid gap-2 mt-3">
                    <button type="submit" class="btn btn-lg btn-primary" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Reset Password
                    </button>
                </div>
            </form>
        </div>
    </GuestLayout>
</template>
