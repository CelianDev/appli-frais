<template>
  <div class="flex flex-row-reverse bg-slate-100">
    <main class="flex-1 justify-center h-full overflow-visible">
      <div class="px-4 w-full sm:px-6 lg:px-8 mx-auto">
        <div class="rounded-lg bg-white shadow px-4 py-5 sm:px-6">
          <div class="flex justify-between items-center">
            <div class="flex flex-row">
              <h3 class="text-base font-semibold leading-6 text-gray-900">
                Note de frais
              </h3>
              <h3 class="text-base mx-2 font-semibold leading-6 text-gray-900">
                -
              </h3>
              <h3 class="text-base font-semibold leading-6 text-gray-900">
                {{ moisFicheFrais }}
              </h3>
            </div>
          </div>

          <div class="border-b mt-5 mb-2 border-gray-200">
            <p class="my-2 text-sm text-gray-500">
              Liste des frais enregistrés
            </p>
          </div>

          <div>
            <ul role="list" class="divide-y divide-white/5">
              <li
                v-for="fraisItem in combinedFrais"
                :key="fraisItem.id"
                class="relative space-x-4 py-3 hover:cursor-pointer"
              >
                <div
                  class="flex items-center justify-between gap-x-3 sm:gap-x-0"
                >
                  <div class="min-w-0 flex-auto">
                    <div class="flex items-center gap-x-3">
                      <div
                        :class="[
                          fraisItem.statusClass,
                          'flex-none rounded-full p-1',
                        ]"
                      >
                        <div class="h-2 w-2 rounded-full bg-current" />
                      </div>
                      <h2
                        class="min-w-0 truncate text-start text-sm font-semibold leading-6 text-gray-900"
                      >
                        <span class="truncate">{{ fraisItem.libelle }}</span>
                      </h2>
                    </div>
                    <div
                      class="mt-3 flex items-center gap-x-2.5 text-xs leading-5 text-gray-400"
                    >
                      <span class="whitespace-nowrap"
                        >{{ fraisItem.montant }} €</span
                      >
                      <svg
                        viewBox="0 0 2 2"
                        class="h-0.5 w-0.5 flex-none fill-gray-300"
                      >
                        <circle cx="1" cy="1" r="1" />
                      </svg>
                      <p class="truncate">{{ fraisItem.formattedDate }}</p>
                      <svg
                        viewBox="0 0 2 2"
                        class="h-0.5 w-0.5 flex-none fill-gray-300"
                      >
                        <circle cx="1" cy="1" r="1" />
                      </svg>
                      <p class="whitespace-nowrap">{{ fraisItem.type }}</p>
                    </div>
                  </div>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>

<script setup>
import { usePage, Link } from "@inertiajs/vue3";
import moment from "moment";
import "moment/dist/locale/fr"; // Import French locale

import { PencilIcon, PlusCircleIcon, TrashIcon } from "@heroicons/vue/24/solid";

// Récupérer les frais depuis les props passées par Inertia
const page = usePage();
const fraisHorsForfait = page.props.fraisHorsForfait;
const fraisForfait = page.props.fraisForfait;
const ficheFrais = page.props.ficheFrais;

// Configurer moment pour utiliser la locale française
moment.locale("fr");

// Formater le mois de la fiche de frais
const moisFicheFrais = moment(ficheFrais.mois, "YYYY-MM").format("MMMM YYYY");

// Traiter les frais hors forfait
fraisHorsForfait.forEach((f) => {
  f.type = "hors forfait";
  f.formattedDate = moment(f.date, "YYYY-MM-DD").format("DD/MM/YYYY"); // Date formatée pour l'affichage
});

// Traiter les frais forfaitisés
fraisForfait.forEach((f) => {
  f.type = "forfaitisé";
  const montantForfait = f.type_frais_forfait
    ? parseFloat(f.type_frais_forfait.montant)
    : 0;
  f.montant = (f.quantite * montantForfait).toFixed(2);
  f.libelle = f.type_frais_forfait
    ? `${f.type_frais_forfait.libelle} (${f.quantite})`
    : `Type de forfait manquant (${f.quantite})`;
  f.formattedDate = moment(f.date, "YYYY-MM-DD").format("DD/MM/YYYY");
});

// Couleurs associées aux états des frais
const statusColors = {
  validé: "text-green-400 bg-green-400/10",
  "en attente": "text-orange-400 bg-orange-400/10",
  refusé: "text-rose-400 bg-rose-400/10",
};

// Ajouter la classe CSS correspondant à l'état de chaque frais
const computedFraisHorsForfait = fraisHorsForfait.map((f) => ({
  ...f,
  statusClass: statusColors[f.etat] || "text-gray-400 bg-gray-400/10",
}));

const computedFraisForfait = fraisForfait.map((f) => ({
  ...f,
  statusClass: statusColors[f.etat] || "text-gray-400 bg-gray-400/10",
}));

// Fusionner les deux types de frais
const combinedFrais = [...computedFraisHorsForfait, ...computedFraisForfait];

// console.log(combinedFrais); // Vérifier la fusion dans la console

// Trier les frais par la date (du plus récent au moins récent)
const recentFrais = combinedFrais.sort((a, b) =>
  moment(b.date, "YYYY-MM-DD").diff(moment(a.date, "YYYY-MM-DD"))
);
</script>
