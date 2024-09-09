<template>
  <div class="card flex flex-col">
    <h3 class="text-base font-semibold leading-6 text-gray-900">
      Tableau de bord
    </h3>
    <div class="flex flex-row space-x-3 mt-1.5">
      <!-- Dates dynamiques pour le mois en cours et celui de l'année précédente -->
      <h4 class="text-sm font-normal leading-6 text-gray-700">
        {{ lastYearMonth }}
      </h4>
      <h4 class="text-sm font-normal leading-6 text-gray-700">-</h4>
      <h4 class="text-sm font-normal leading-6 text-gray-700">
        {{ currentYearMonth }}
      </h4>
    </div>
    <StackedBarFraisMonthly />
  </div>
</template>

<script setup>
import moment from "moment"; // Importer moment.js
import StackedBarFraisMonthly from "@/Components/StackedBarFraisMonthly.vue";

// Récupérer les dates dynamiques pour le mois en cours et celui de l'année précédente
const currentYearMonth = moment().format("MMMM YYYY"); // Mois et année en cours
const lastYearMonth = moment().subtract(1, "year").format("MMMM YYYY"); // Mois de l'année précédente
</script>

