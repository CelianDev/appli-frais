<template>
  <div v-if="etat == 'success'">
    <NotificationSuccess />
  </div>
  <div v-if="etat == 'fail'">
    <NotificationFail />
  </div>
</template>

<script setup>
import { usePage } from "@inertiajs/vue3";
import NotificationSuccess from "@/Components/NotificationSuccess.vue";
import NotificationFail from "@/Components/NotificationFail.vue";

const page = usePage();
const notification = page.props.notification ? page.props.notification : null;
// const notification = {
//   titre: "Erreur!",
//   message: "errors errors errors errors errors errors errors",
//   etat: "fail",
// };
const etat = notification.etat ? notification.etat : null;
</script>