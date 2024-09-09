<template>
  <div class="card">
    <Chart
      type="bar"
      :data="chartData"
      :options="chartOptions"
      class="h-[20rem]"
    />
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import Chart from "primevue/chart";
import moment from "moment";
import { usePage } from "@inertiajs/vue3";
import { chartColors, hoverColors } from "@/chartColors"; // Utiliser les couleurs importées

// Initialisation des variables réactives pour les données du graphique et les options
const chartData = ref();
const chartOptions = ref();

// Récupération des données depuis Inertia
const page = usePage();
const fraisForfait = page.props.fraisForfait;
const fraisHorsForfait = page.props.fraisHorsForfait;

// Fonction pour générer les mois de l'année dernière au mois courant
const getLast12Months = () => {
  const months = [];
  for (let i = 12; i >= 0; i--) {
    months.push(moment().subtract(i, "months").format("MMMM YYYY"));
  }
  return months;
};

// Organiser les frais par type et par mois (seulement les validés)
const organizeFraisByTypeAndMonth = () => {
  const months = getLast12Months();
  const totals = {};

  // Initialisation des totaux pour chaque type de frais par mois
  months.forEach((month) => {
    totals[month] = {};
  });

  // Traiter les frais forfait (seulement les validés)
  fraisForfait
    .filter((frais) => frais.etat === "validé" || frais.etat === "en attente")
    .forEach((frais) => {
      const type = frais.type_frais_forfait
        ? frais.type_frais_forfait.libelle.toLowerCase()
        : "forfait";
      const montant =
        frais.quantite * parseFloat(frais.type_frais_forfait.montant || 0);
      const month = moment(frais.date, "YYYY-MM-DD").format("MMMM YYYY");

      if (totals[month]) {
        if (!totals[month][type]) {
          totals[month][type] = 0;
        }
        totals[month][type] += montant;
      }
    });

  // Traiter les frais hors forfait (seulement les validés)
  fraisHorsForfait
    .filter((frais) => frais.etat === "validé" || frais.etat === "en attente")
    .forEach((frais) => {
      const type = "hors forfait";
      const montant = parseFloat(frais.montant || 0);
      const month = moment(frais.date, "YYYY-MM-DD").format("MMMM YYYY");

      if (totals[month]) {
        if (!totals[month][type]) {
          totals[month][type] = 0;
        }
        totals[month][type] += montant;
      }
    });

  return totals;
};

// Préparer les datasets pour le graphique
const setChartData = () => {
  const totalsByTypeAndMonth = organizeFraisByTypeAndMonth();
  const months = getLast12Months();

  // Types de frais (à extraire dynamiquement)
  let allTypes = new Set();
  Object.values(totalsByTypeAndMonth).forEach((monthData) => {
    Object.keys(monthData).forEach((type) => allTypes.add(type));
  });

  // Convertir le Set en tableau et s'assurer que "hors forfait" soit en dernier
  allTypes = Array.from(allTypes).sort((a, b) => {
    if (a === "hors forfait") return 1;
    if (b === "hors forfait") return -1;
    return 0;
  });

  // Générer les datasets par type de frais avec attribution dynamique des couleurs
  let colorIndex = 0; // Utilisé pour attribuer les couleurs dans l'ordre
  const datasets = allTypes.map((type) => {
    const color = chartColors[colorIndex % chartColors.length]; // Couleur principale
    const hoverColor = hoverColors[colorIndex % hoverColors.length]; // Couleur au hover
    colorIndex++; // Incrémenter pour passer à la couleur suivante

    return {
      label: type,
      backgroundColor: color, // Assigner la couleur dynamique
      hoverBackgroundColor: hoverColor, // Couleur au hover
      data: months.map((month) => totalsByTypeAndMonth[month][type] || 0),
    };
  });

  return {
    labels: months, // Les mois comme labels
    datasets, // Les datasets par type de frais avec couleurs dynamiques
  };
};

// Définir les options du graphique
const setChartOptions = () => {
  const documentStyle = getComputedStyle(document.documentElement);
  const textColor = documentStyle.getPropertyValue("--p-text-color");
  const textColorSecondary = documentStyle.getPropertyValue(
    "--p-text-muted-color"
  );
  const surfaceBorder = documentStyle.getPropertyValue(
    "--p-content-border-color"
  );

  return {
    maintainAspectRatio: false,
    aspectRatio: 0.8,
    plugins: {
      tooltips: {
        mode: "index",
        intersect: false,
      },
      legend: {
        labels: {
          color: textColor,
        },
      },
    },
    scales: {
      x: {
        stacked: true,
        ticks: {
          color: textColorSecondary,
        },
        grid: {
          color: surfaceBorder,
        },
      },
      y: {
        stacked: true,
        ticks: {
          color: textColorSecondary,
        },
        grid: {
          color: surfaceBorder,
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
