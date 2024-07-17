<script setup>
import Checkbox from '@/Components/Form/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/Form/InputError.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <GuestLayout>

        <Head title="Log in" />

        <div class="text-center">
            <h1 class="h2">Welcome to Parallax E-Commerce Platform!</h1>
            <p class="lead">
                Sign in to your account to continue
            </p>
        </div>

        <div class="mb-3">

            <form @submit.prevent="submit">
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input class="form-control form-control-lg" type="email" name="email" id="email"
                        v-model="form.email" required autofocus autocomplete="username"
                        placeholder="Enter your email" />
                    <InputError class="mt-2" :message="form.errors.email" />
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input class="form-control form-control-lg" type="password" name="password" id="password"
                        v-model="form.password" required autocomplete="current-password"
                        placeholder="Enter your password" />
                    <small>
                        <Link href="/forgot-password">Forgot your password?</Link>
                    </small>
                </div>
                <div>
                    <div class="form-check align-items-center">
                        <Checkbox class="form-check-input" type="checkbox" name="remember"
                            v-model:checked="form.remember" checked />
                        <label class="form-check-label text-small" for="customControlInline">Remember me</label>
                    </div>
                </div>
                <div class="d-grid gap-2 mt-3">
                    <button type="submit" class='btn btn-lg btn-primary'>Sign in</button>
                </div>
            </form>
        </div>

        <div class="text-center">
            Don't have an account? <Link href='/register'>Sign up</Link>
        </div>
    </GuestLayout>
</template>
