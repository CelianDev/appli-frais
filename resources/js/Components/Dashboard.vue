<template>
  <!-- Main and aside content -->
  <div class="bg-slate-100 py-8">
    <div class="flex flex-row-reverse gap-4 px-8">
      <main class="flex-1 overflow-visible space-y-4">
        <!-- Main area -->
        <div id="stats" class="flex flex-col">
          <div
            class="flex-1 px-4 py-5 sm:px-6 lg:px-8 lg:py-6 overflow-visible rounded-lg bg-white shadow"
          >
            <CardStats />
          </div>
        </div>
        <div class="flex flex-row gap-x-4">
          <div
            class="flex-none px-4 py-5 sm:px-6 lg:px-8 lg:py-6 overflow-visible rounded-lg bg-white shadow"
          >
            <DoughnutFraisAnnuel />
          </div>
          <div
            class="flex-1 px-4 py-5 sm:px-6 lg:px-8 lg:py-6 overflow-visible rounded-lg bg-white shadow"
          >
            <CardListeFicheFrais />
          </div>
        </div>
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
import CardStats from "@/Components/CardStats.vue";
import DoughnutFraisAnnuel from "@/Components/DoughnutFraisAnnuel.vue";
import StackedBarFraisMonthly from "@/Components/StackedBarFraisMonthly.vue";
import CardListeFicheFrais from "@/Components/CardListeFicheFrais.vue";
</script>
