<template>
  <!-- Sidebar -->
  <SideBar :auth="auth" />
  <h1 class="text-lg font-semibold text-gray-900">
    Bienvenue, {{ auth?.user?.name || "Invité" }}
  </h1>
  <!-- Main Content Area -->
</template>

<script setup>
import SideBar from "@/Components/SideBar.vue";
// import PageHeading from "@/Components/PageHeading.vue";
defineProps({
  auth: Object,
});
</script>
