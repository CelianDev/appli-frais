<template>
  <!-- Main and aside content -->
  <div class="flex flex-row-reverse h-screen bg-slate-100">
    <main class="flex-1 h-full overflow-auto">
      <div class="px-4 py-10 sm:px-6 lg:px-8 lg:py-6">
        <!-- Main area -->
      </div>
    </main>
    <aside
      class="w-1/4 min-w-96 h-full overflow-y-auto hidden xl:block px-4 py-6 sm:px-6 lg:px-8"
    >
      <div class="rounded-lg bg-white shadow px-4 py-5 sm:px-6">
        <!-- Secondary column (hidden on smaller screens) -->
        <CardFrais />
      </div>
    </aside>
  </div>
</template>

<script setup>
import CardFrais from "@/Components/CardFrais.vue";
</script>