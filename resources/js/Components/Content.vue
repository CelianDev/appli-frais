<template>
  <!-- Vous pouvez afficher ou masquer cette section dynamiquement -->
  <div v-if="content == 'dashboard'">
    <Dashboard />
  </div>
  <div v-if="content == 'fraisDetails'">
    <FraisDetail />
  </div>
</template>

<script setup>
import Dashboard from "@/Components/Dashboard.vue";
import FraisDetail from "@/Components/FraisDetail.vue";
import { usePage } from "@inertiajs/vue3";
import { ref } from "vue";

// Utilisation de usePage pour accéder à la route actuelle
const page = usePage();
console.log(page.props.content);
const content = page.props.content;
</script>