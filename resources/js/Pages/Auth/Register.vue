<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/Form/InputError.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>

        <Head title="Register" />

        <div class="text-center">
            <h1 class="h2">Welcome back!</h1>
            <p class="lead">
                Sign up for a new account to continue
            </p>
        </div>

        <div class="mb-3">
            <form @submit.prevent="submit">
                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input class="form-control form-control-lg" type="text" id="name" v-model="form.name" required
                        autofocus autocomplete="name" placeholder="Enter your name" />
                    <InputError class="mt-2" :message="form.errors.name" />
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input class="form-control form-control-lg" type="email" id="email" v-model="form.email" required
                        autocomplete="username" placeholder="Enter your email" />
                    <InputError class="mt-2" :message="form.errors.email" />
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input class="form-control form-control-lg" type="password" id="password" v-model="form.password"
                        required autocomplete="new-password" placeholder="Enter your password" />
                    <InputError class="mt-2" :message="form.errors.password" />
                </div>

                <div class="mb-3">
                    <label class="form-label">Confirm Password</label>
                    <input class="form-control form-control-lg" type="password" id="password_confirmation"
                        v-model="form.password_confirmation" required autocomplete="new-password"
                        placeholder="Confirm your password" />
                    <InputError class="mt-2" :message="form.errors.password_confirmation" />
                </div>

                <div class="d-grid gap-2 mt-3">
                    <button type="submit" class="btn btn-lg btn-primary" :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing">
                        Register
                    </button>
                </div>
            </form>
        </div>

        <div class="text-center mt-3">
            Already registered? <Link :href="route('login')">Sign in</Link>
        </div>
    </GuestLayout>
</template>
