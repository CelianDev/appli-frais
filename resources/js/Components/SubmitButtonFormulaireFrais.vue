<template>
  <div class="flex items-center justify-end gap-x-6">
    <Link
      :href="route('fiche-frais.show', { mois: mois, idVisiteur: idVisiteur })"
      class="text-sm font-semibold leading-6 text-gray-900"
    >
      Annuler
    </Link>
    <button
      type="submit"
      class="rounded-md bg-sky-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-sky-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-sky-600"
    >
      Enregistrer
    </button>
  </div>
</template>

<script setup>
import { usePage, Link } from "@inertiajs/vue3"; // Import Inertia Link et usePage

// Définir les props depuis la page actuelle
const page = usePage();
const mois = page.props.ficheFrais.mois; // Mois de la fiche de frais
const idVisiteur = page.props.auth.user.id;
</script>
