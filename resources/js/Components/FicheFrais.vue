<template>
  <!-- Main and aside content -->
  <div class="flex flex-row-reverse h-screen bg-slate-100">
    <main class="flex-1 justify-center h-full overflow-auto">
      <div class="px-4 py-10 w-full sm:px-6 lg:px-8 lg:py-6 mx-auto">
        <!-- Main area -->
        <div class="rounded-lg bg-white shadow px-4 py-5 sm:px-6">
          <div
            class="-ml-4 -mt-4 flex flex-wrap items-center justify-between sm:flex-nowrap"
          >
            <div class="flex flex-col w-full">
              <div class="flex flex-row justify-between items-center">
                <div class="flex flex-row ml-4 mt-4">
                  <h3 class="text-base font-semibold leading-6 text-gray-900">
                    Note de frais
                  </h3>
                  <h3
                    class="text-base mx-2 font-semibold leading-6 text-gray-900"
                  >
                    -
                  </h3>
                  <h3 class="text-base font-semibold leading-6 text-gray-900">
                    {{ moisFicheFrais }}
                  </h3>
                </div>
                <!-- Badge "Clôturé" visible si la fiche est clôturée -->
                <div v-if="ficheFrais.cloture" class="ml-4 mt-4">
                  <span
                    class="inline-flex items-center rounded-md bg-gray-100 px-3 py-1 text-sm font-semibold text-gray-500 ring-1 ring-inset ring-gray-500/10"
                  >
                    Clôturé
                  </span>
                </div>
                <!-- Bouton ajouter visible uniquement si fiche non clôturée -->
                <div v-else class="ml-4 mt-4 flex-shrink-0">
                  <button
                    type="button"
                    class="relative inline-flex items-center rounded-md gap-x-1.5 bg-sky-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-sky-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-sky-600"
                  >
                    <PlusCircleIcon
                      class="h-4 w-4 md:h-5 w-5"
                      aria-hidden="true"
                    />
                    <div class="hidden md:block">Ajouter un frais</div>
                  </button>
                </div>
              </div>
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
                v-for="fraisItem in recentFrais"
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
                  <!-- Boutons modifier/supprimer visibles uniquement si fiche non clôturée -->
                  <div
                    class="flex flex-col gap-y-1.5 md:gap-y-0 md:gap-x-1.5 md:flex-row"
                    v-if="!ficheFrais.cloture"
                  >
                    <button
                      type="button"
                      class="inline-flex items-center gap-x-1.5 rounded-md bg-amber-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-amber-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-amber-600"
                    >
                      <PencilIcon class="-ml-0.5 h-4 w-4" aria-hidden="true" />
                      <div class="hidden md:block">Modifier</div>
                    </button>
                    <button
                      type="button"
                      class="inline-flex items-center gap-x-1.5 rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600"
                    >
                      <TrashIcon class="-ml-0.5 h-4 w-4" aria-hidden="true" />
                      <div class="hidden md:block">Supprimer</div>
                    </button>
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
import { usePage } from "@inertiajs/vue3";
import { Link } from "@inertiajs/vue3";
import moment from "moment";
import "moment/dist/locale/fr"; // Import French locale

import {
  PencilIcon,
  PlusCircleIcon,
  TrashIcon,
  CheckCircleIcon,
} from "@heroicons/vue/24/solid";

// Récupérer les frais depuis les props passées par Inertia
const page = usePage();
const fraisHorsForfait = page.props.fraisHorsForfait;
const ficheFrais = page.props.ficheFrais;

// Configurer moment pour utiliser la locale française
moment.locale("fr");

// Formater le mois de la fiche de frais
const moisFicheFrais = moment(ficheFrais.mois, "YYYY-MM").format("MMMM YYYY");

// Ne pas modifier directement `f.date`, ajouter `formattedDate` pour l'affichage
fraisHorsForfait.forEach((f) => {
  f.type = "hors forfait";
  f.formattedDate = moment(f.date, "YYYY-MM-DD").format("DD/MM/YYYY"); // Date formatée pour l'affichage
});

// Couleurs associées aux états des frais
const statusColors = {
  validé: "text-green-400 bg-green-400/10",
  "en attente": "text-orange-400 bg-orange-400/10",
  refusé: "text-rose-400 bg-rose-400/10",
};

// Ajouter la classe CSS correspondant à l'état de chaque frais
const computedFrais = fraisHorsForfait.map((f) => ({
  ...f,
  statusClass: statusColors[f.etat] || "text-gray-400 bg-gray-400/10",
}));

// Trier les frais par la date (du plus récent au moins récent) en utilisant moment
const recentFrais = computedFrais
  .sort((a, b) =>
    moment(b.date, "YYYY-MM-DD").diff(moment(a.date, "YYYY-MM-DD"))
  ) // Tri basé sur les dates réelles des événements
  .slice(0, 3); // Ne garder que les 3 derniers
</script>
