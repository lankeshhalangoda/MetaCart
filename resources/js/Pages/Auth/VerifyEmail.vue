<script setup>
import { computed } from 'vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    status: {
        type: String,
    },
});

const form = useForm({});

const submit = () => {
    form.post(route('verification.send'));
};

const verificationLinkSent = computed(() => props.status === 'verification-link-sent');
</script>

<template>
    <GuestLayout>

        <Head title="Email Verification" />

        <div class="text-center">
            <h1 class="h2">Email Verification</h1>
            <p class="lead text-start">
                Thanks for signing up! Before getting started, could you verify your email address by clicking on the
                link
                we just emailed to you? If you didn't receive the email, we will gladly send you another.
            </p>
        </div>

        <div class="mb-4 font-medium text-sm text-green-600" v-if="verificationLinkSent">
            A new verification link has been sent to the email address you provided during registration.
        </div>

        <div class="mb-3">
            <form @submit.prevent="submit">
                <div class="d-grid gap-2 mt-3">
                    <button type="submit" class="btn btn-lg btn-primary" :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing">
                        Resend Verification Email
                    </button>
                </div>

                <div class="d-grid gap-2 mt-3">
                    <Link :href="route('logout')" method="post" as="button"
                        class="btn btn-link text-sm text-gray-600 hover:text-gray-900">
                    Log Out
                    </Link>
                </div>
            </form>
        </div>
    </GuestLayout>
</template>
