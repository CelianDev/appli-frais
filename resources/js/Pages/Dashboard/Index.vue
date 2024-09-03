<template>
  <Layout :auth="auth" />
</template>

<script setup>
import { Head } from "@inertiajs/vue3";
import { Link } from "@inertiajs/vue3";
import { router } from "@inertiajs/vue3";
import Layout from "@/Components/Layout.vue";

defineProps({ auth: Object });
</script>
