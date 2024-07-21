<template>
  <layout>
    <div>
      <Head title="Dashboard" />
      <h1 class="mb-8 text-3xl font-bold">Dashboard</h1>
      <p class="mb-8 leading-normal">Bonjour {{ auth.user.name }}</p>
    </div>
  </layout>
</template>

<script setup>
import { Head } from "@inertiajs/vue3";
import Layout from "@/Components/Layout.vue";

defineProps({ auth: Object });
</script>
