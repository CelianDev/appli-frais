<template>
  <h4 class="text-sm font-normal leading-6 text-gray-700 mb-3">
    Récapitulatif annuel
  </h4>
  <div class="flex flex-row items-center justify-evenly">
    <!-- Graphique -->
    <Chart
      type="doughnut"
      :data="chartData"
      :options="chartOptions"
      class="w-[16rem]"
    />
    <!-- Liste des types de frais et leurs montants -->
    <div class="flex flex-col items-start justify-center ml-10">
      <ul>
        <li
          v-for="(montant, index) in Object.entries(totalsByType)"
          :key="index"
          class="mb-2 flex items-center"
        >
          <!-- Vérification si chartData est disponible et contient datasets -->
          <span
            v-if="
              chartData &&
              chartData.datasets &&
              chartData.datasets[0].backgroundColor
            "
            class="inline-block w-3 h-3 mr-2 rounded-full"
            :style="{
              backgroundColor: chartData.datasets[0].backgroundColor[index],
            }"
          ></span>
          <span class="text-sm font-normal leading-6 text-gray-700"
            >{{ montant[1].toFixed(2) }} €</span
          >
        </li>
      </ul>
      <!-- Montant total de tous les frais -->
      <div class="flex flex-row mt-2">
        <span
          class="inline-flex items-center rounded-md bg-sky-100 px-2 py-1 text-lg font-medium text-sky-700"
          >{{ montantTotal.toFixed(2) }} €</span
        >
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import Chart from "primevue/chart";
import { usePage } from "@inertiajs/vue3";
import moment from "moment";
import { chartColors, hoverColors } from "@/chartColors"; // Utiliser les couleurs

// Variables réactives pour les données du graphique et les options
const chartData = ref({ labels: [], datasets: [] });
const chartOptions = ref(null);

// Récupérer les données de la page Inertia
const page = usePage();
const fraisHorsForfait = page.props.fraisHorsForfait;
const fraisForfait = page.props.fraisForfait;

// Calculer les montants totaux par type de frais
const totalsByType = ref({});
const montantTotal = ref(0);

const calculateTotalsByType = () => {
  const totals = {};

  // Ajouter les frais forfait (seulement les validés)
  fraisForfait
    .filter((frais) => frais.etat === "validé" || frais.etat === "en attente")
    .forEach((frais) => {
      const type = frais.type_frais_forfait
        ? frais.type_frais_forfait.libelle
        : "Forfait";
      const montant =
        frais.quantite * parseFloat(frais.type_frais_forfait.montant || 0);
      if (!totals[type]) {
        totals[type] = 0;
      }
      totals[type] += montant;
    });

  // Ajouter les frais hors forfait (seulement les validés)
  fraisHorsForfait
    .filter((frais) => frais.etat === "validé" || frais.etat === "en attente")
    .forEach((frais) => {
      if (!totals["Hors Forfait"]) {
        totals["Hors Forfait"] = 0;
      }
      totals["Hors Forfait"] += parseFloat(frais.montant || 0);
    });

  // Calcul du montant total de tous les frais
  montantTotal.value = Object.values(totals).reduce((acc, val) => acc + val, 0);

  return totals;
};

// Définir les données du graphique
const setChartData = () => {
  const totals = calculateTotalsByType(); // Obtenir les totaux par type de frais
  totalsByType.value = totals; // Mettre à jour les montants par type de frais

  const colorsLength = chartColors.length;

  return {
    labels: Object.keys(totals), // Types de frais (labels)
    datasets: [
      {
        data: Object.values(totals), // Montants totaux (data)
        backgroundColor: Object.keys(totals).map(
          (_, index) => chartColors[index % colorsLength] // Couleurs dynamiques
        ),
        hoverBackgroundColor: Object.keys(totals).map(
          (_, index) => hoverColors[index % colorsLength] // Couleurs au survol dynamiques
        ),
      },
    ],
  };
};

// Définir les options du graphique
const setChartOptions = () => {
  const documentStyle = getComputedStyle(document.documentElement);
  const textColor = documentStyle.getPropertyValue("--p-text-color");

  return {
    plugins: {
      legend: {
        labels: {
          cutout: "60%",
          color: textColor,
        },
      },
    },
  };
};

// Initialiser les données et options du graphique lors du montage du composant
onMounted(() => {
  chartData.value = setChartData();
  chartOptions.value = setChartOptions();
});
</script>
