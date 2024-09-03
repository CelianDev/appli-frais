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
          <button
            type="button"
            class="relative inline-flex items-center rounded-md bg-sky-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-sky-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-sky-600"
          >
            + Ajouter
          </button>
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
          :href="route('frais.show', fraisItem.id)"
          method="get"
          as="button"
          class="cursor-pointer"
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
              <p class="truncate">{{ fraisItem.date }}</p>
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

// Récupérer les frais depuis les props passées par Inertia
const page = usePage();
const fraisHorsForfait = page.props.fraisHorsForfait;
fraisHorsForfait.forEach((f) => {
  f.type = "hors forfait";
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

// Trier les frais par date de création et ne garder que les 8 derniers
const recentFrais = computedFrais
  .sort((a, b) => new Date(b.created_at) - new Date(a.created_at))
  .slice(0, 8);
</script>
