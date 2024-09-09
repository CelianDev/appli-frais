<template>
  <!-- Vous pouvez afficher ou masquer ces sections dynamiquement -->
  <div v-if="notification">
    <Notification />
  </div>
  <div v-if="content != 'dashboard'">
    <Breadcrumb />
  </div>
  <div v-if="content == 'dashboard'">
    <Dashboard />
  </div>
  <div v-if="content == 'fraisDetails'">
    <FraisDetails />
  </div>
  <div v-if="content == 'ficheFrais'">
    <FicheFrais />
  </div>
  <div v-if="content == 'listeFicheFrais'">
    <ListeFicheFrais />
  </div>
  <div v-if="content == 'formulaireFrais'">
    <FormulaireFrais class="h-full" />
  </div>
</template>

<script setup>
import Notification from "@/Components/Notification.vue";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import Dashboard from "@/Components/Dashboard.vue";
import FraisDetails from "@/Components/FraisDetails.vue";
import FicheFrais from "@/Components/FicheFrais.vue";
import ListeFicheFrais from "@/Components/ListeFicheFrais.vue";
import FormulaireFrais from "@/Components/FormulaireFrais.vue";
import { usePage } from "@inertiajs/vue3";
import { ref } from "vue";

// Utilisation de usePage pour accéder à la route actuelle
const page = usePage();
// console.log(page.props.content);
const content = page.props.content;
const notification = page.props.notification ? page.props.notification : null;
// const notification = {
//   titre: "Erreur!",
//   message: "errors errors errors errors errors errors errors",
//   etat: "fail",
// };
// console.log("Notification:", notification);
// console.log("Notification.etat:", notification.etat);
</script>