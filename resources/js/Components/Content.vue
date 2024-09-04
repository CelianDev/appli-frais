<template>
  <Breadcrumb />
  <!-- Vous pouvez afficher ou masquer cette section dynamiquement -->
  <div v-if="content == 'dashboard'">
    <Dashboard />
  </div>
  <div v-if="content == 'fraisDetails'">
    <FraisDetail />
  </div>
  <div v-if="content == 'ficheFrais'">
    <FicheFrais />
  </div>
</template>

<script setup>
import Dashboard from "@/Components/Dashboard.vue";
import FraisDetail from "@/Components/FraisDetail.vue";
import FicheFrais from "@/Components/FicheFrais.vue";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import { usePage } from "@inertiajs/vue3";
import { ref } from "vue";

// Utilisation de usePage pour accéder à la route actuelle
const page = usePage();
console.log(page.props.content);
const content = page.props.content;
// const content = "ficheFrais";
</script>