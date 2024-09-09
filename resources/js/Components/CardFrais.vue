<template>
  <div
    class="-ml-4 -mt-4 flex flex-wrap items-center justify-between sm:flex-nowrap"
  >
    <div class="flex flex-col w-full">
      <div class="flex flex-row justify-between items-center">
        <div class="ml-4 mt-4">
          <h3 class="text-base font-semibold leading-6 text-gray-900">Frais</h3>
        </div>
        <div class="ml-4 mt-4 flex-shrink-0">
          <Link
            :href="
              route('frais.create', {
                mois: currentmois,
                idVisiteur: idVisiteur,
              })
            "
            class="relative inline-flex items-center rounded-md gap-x-1.5 bg-sky-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-sky-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-sky-600"
          >
            <PlusCircleIcon class="h-4 w-4 md:h-5 md:w-5" aria-hidden="true" />
            <div class="hidden md:block">Ajouter</div>
          </Link>
        </div>
      </div>
    </div>
  </div>
  <div class="border-b mt-5 mb-2 border-gray-200">
    <p class="my-2 text-sm text-gray-500">Liste de frais récents</p>
  </div>
  <div>
    <ul role="list" class="divide-y divide-white/5">
      <li
        v-for="fraisItem in recentFrais"
        :key="fraisItem.id"
        class="relative flex items-center space-x-4 py-3 hover:cursor-pointer"
      >
        <Link
          :href="
            route('fiche-frais.show', {
              mois: fraisItem.mois,
              idVisiteur: page.props.auth.user.id,
            })
          "
          method="get"
          as="button"
          class="cursor-pointer w-full h-full"
        >
          <span
            class="pointer-events-none absolute right-0 top-5 text-gray-300 group-hover:text-gray-400"
            aria-hidden="true"
          >
            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
              <path
                d="M20 4h1a1 1 0 00-1-1v1zm-1 12a1 1 0 102 0h-2zM8 3a1 1 0 000 2V3zM3.293 19.293a1 1 0 101.414 1.414l-1.414-1.414zM19 4v12h2V4h-2zm1-1H8v2h12V3zm-.707.293l-16 16 1.414 1.414 16-16-1.414-1.414z"
              ></path>
            </svg>
          </span>
          <div class="min-w-0 flex-auto">
            <div class="flex items-center gap-x-3">
              <div
                :class="[fraisItem.statusClass, 'flex-none rounded-full p-1']"
              >
                <div class="h-2 w-2 rounded-full bg-current" />
              </div>
              <h2
                style="width: 13rem"
                class="min-w-0 truncate text-start text-sm font-semibold leading-6 text-gray-900"
              >
                <span class="truncate">{{ fraisItem.libelle }}</span>
              </h2>
            </div>
            <div
              class="mt-3 flex items-center gap-x-2.5 text-xs leading-5 text-gray-400"
            >
              <span class="whitespace-nowrap">{{ fraisItem.montant }} €</span>
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
        </Link>
      </li>
    </ul>
  </div>
</template>

<script setup>
import { usePage } from "@inertiajs/vue3";
import { Link } from "@inertiajs/vue3";
import moment from "moment";
import "moment/dist/locale/fr";

import { PlusCircleIcon } from "@heroicons/vue/24/solid";

// Récupérer les frais depuis les props passées par Inertia
const page = usePage();
const idVisiteur = page.props.auth.user.id;
const currentmois = moment().format("YYYY-MM");
const fraisHorsForfait = page.props.fraisHorsForfait;
const fraisForfait = page.props.fraisForfait;
moment.locale("fr");

// Traiter les frais hors forfait
fraisHorsForfait.forEach((f) => {
  f.type = "hors forfait";
  f.formattedDate = moment(f.date, "YYYY-MM-DD").format("DD/MM/YYYY"); // Date formatée pour l'affichage
  f.mois = moment(f.date, "YYYY-MM-DD").format("YYYY-MM"); // Extraire le mois du frais
});

// Traiter les frais forfaitisés
fraisForfait.forEach((f) => {
  f.type = "forfaitisé";

  // Utilise `parseFloat` pour convertir `montant` en nombre et éviter les erreurs
  const montantForfait = f.type_frais_forfait
    ? parseFloat(f.type_frais_forfait.montant)
    : 0;

  // Si `montantForfait` est NaN (si le montant n'est pas un nombre valide), on le remplace par 0
  f.montant = !isNaN(montantForfait)
    ? (f.quantite * montantForfait).toFixed(2)
    : "Montant invalide"; // Gérer les cas où le montant est invalide

  f.libelle = f.type_frais_forfait
    ? `${f.type_frais_forfait.libelle} (${f.quantite})`
    : `Forfait inconnu (${f.quantite})`; // Libellé du type de frais et quantité
  f.formattedDate = moment(f.date, "YYYY-MM-DD").format("DD/MM/YYYY"); // Date formatée pour l'affichage
  f.mois = moment(f.date, "YYYY-MM-DD").format("YYYY-MM"); // Extraire le mois du frais
});

// Couleurs associées aux états des frais (hors forfait et forfaitisés)
const statusColors = {
  validé: "text-green-400 bg-green-400/10",
  "en attente": "text-orange-400 bg-orange-400/10",
  refusé: "text-rose-400 bg-rose-400/10",
};

// Ajouter la classe CSS correspondant à l'état de chaque frais hors forfait
const computedFraisHorsForfait = fraisHorsForfait.map((f) => ({
  ...f,
  statusClass: statusColors[f.etat] || "text-gray-400 bg-gray-400/10",
}));

// Ajouter la classe pour les frais forfaitisés
const computedFraisForfait = fraisForfait.map((f) => ({
  ...f,
  statusClass: statusColors[f.etat] || "text-gray-400 bg-gray-400/10", // Utilisation de la colonne `etat` pour la couleur
}));

// Fusionner les frais hors forfait et forfaitisés
const combinedFrais = [...computedFraisHorsForfait, ...computedFraisForfait];

// Trier les frais par la date de l'événement (champ `date`) du plus récent au moins récent
const recentFrais = combinedFrais
  .sort((a, b) =>
    moment(b.date, "YYYY-MM-DD").diff(moment(a.date, "YYYY-MM-DD"))
  ) // Tri en utilisant moment pour la comparaison des dates
  .slice(0, 8); // Ne garder que les 7 derniers
</script>
