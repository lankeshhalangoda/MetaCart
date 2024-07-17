<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/Form/InputError.vue';
import { Head, useForm } from '@inertiajs/vue3';

const form = useForm({
    password: '',
});

const submit = () => {
    form.post(route('password.confirm'), {
        onFinish: () => form.reset(),
    });
};
</script>

<template>
    <GuestLayout>

        <Head title="Confirm Password" />

        <div class="text-center">
            <h1 class="h2">Confirm Password</h1>
            <p class="lead">
                This is a secure area of the application. Please confirm your password before continuing.
            </p>
        </div>

        <div class="mb-3">
            <form @submit.prevent="submit">
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input class="form-control form-control-lg" type="password" id="password" v-model="form.password"
                        required autocomplete="current-password" autofocus placeholder="Enter your password" />
                    <InputError class="mt-2" :message="form.errors.password" />
                </div>

                <div class="d-grid gap-2 mt-3">
                    <button type="submit" class="btn btn-lg btn-primary" :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing">
                        Confirm
                    </button>
                </div>
            </form>
        </div>
    </GuestLayout>
</template>
