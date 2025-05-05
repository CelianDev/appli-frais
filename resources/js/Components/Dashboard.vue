<template>
  <!-- Main and aside content -->
  <div class="bg-slate-100 py-8">
    <div class="flex flex-row-reverse gap-4 px-8">
      <main class="flex-1 overflow-visible space-y-4">
        <!-- Main area -->
        
      </main>
      <aside
        class="w-1/4 min-w-96 rounded-lg bg-white shadow overflow-y-auto hidden 2xl:block"
      >
        <div id="fiche_frais" class="px-4 py-5 sm:px-6">
          <!-- Secondary column (hidden on smaller screens) -->
          <CardFrais />
        </div>
      </aside>
    </div>
  </div>
</template>

<script setup>
import CardFrais from "@/Components/CardFrais.vue";
</script>
