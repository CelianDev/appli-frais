<template>
  <layout>
    <div>
      <Head title="Dashboard" />
      <h1 class="mb-8 text-3xl font-bold">Dashboard</h1>
      <p class="mb-8 leading-normal">Bonjour {{ auth.user.name }}</p>
      <Link
        href="logout"
        method="post"
        as="button"
        class="inline-flex h-12 items-center justify-center rounded-md bg-neutral-950 px-6 font-medium text-neutral-50 transition active:scale-110"
      >
        Click me
      </Link>
    </div>
  </layout>
</template>

<script setup>
import { Head } from "@inertiajs/vue3";
import { Link } from "@inertiajs/vue3";
import { router } from "@inertiajs/vue3";
import Layout from "@/Components/Layout.vue";

const logout = () => {
  Inertia.post(route("logout"));
};

defineProps({ auth: Object });
</script>
