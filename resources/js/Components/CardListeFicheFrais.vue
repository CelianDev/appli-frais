<template>
  <!-- Main and aside content -->
  <div class="flex flex-row">
    <main class="flex-1 justify-center h-full overflow-visible">
      <div class="">
        <!-- Main area -->
        <div class="">
          <div
            class="-ml-4 -mt-4 flex flex-wrap items-center justify-between sm:flex-nowrap"
          >
            <div class="flex flex-col w-full">
              <div class="flex flex-row justify-between items-center">
                <div class="flex flex-row ml-4 mt-4">
                  <h3 class="text-sm font-normal leading-6 text-gray-700">
                    Note de frais
                  </h3>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div>
          <ul role="list" class="divide-y divide-white/5 mt-3">
            <!-- Boucle sur la liste des fiches de frais -->
            <li
              v-for="ficheFrais in filteredFicheFrais"
              :key="ficheFrais.id"
              class="overflow-hidden rounded-md bg-white cursor-pointer"
            >
              <!-- Utiliser le composant Link pour rediriger -->
              <Link
                :href="
                  route('fiche-frais.show', {
                    mois: ficheFrais.mois,
                    idVisiteur: idVisiteur,
                  })
                "
                class="flex items-center justify-between py-2 gap-x-3 sm:gap-x-0"
              >
                <div class="min-w-0 flex-auto">
                  <div class="flex items-center gap-x-3">
                    <div
                      :class="[
                        ficheFrais.statusClass,
                        'flex-none rounded-full p-1',
                      ]"
                    >
                      <div class="h-2 w-2 rounded-full bg-current" />
                    </div>
                    <h2
                      class="text-sm capitalize font-semibold leading-6 text-gray-900"
                    >
                      {{ ficheFrais.formattedDate }}
                      <span class="px-3">-</span>
                      {{ ficheFrais.montantTotal }} €
                    </h2>
                  </div>
                </div>
                <span
                  class="pointer-events-none right-0 top-5 text-gray-300 group-hover:text-gray-400"
                  aria-hidden="true"
                  ><svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                    <path
                      d="M20 4h1a1 1 0 00-1-1v1zm-1 12a1 1 0 102 0h-2zM8 3a1 1 0 000 2V3zM3.293 19.293a1 1 0 101.414 1.414l-1.414-1.414zM19 4v12h2V4h-2zm1-1H8v2h12V3zm-.707.293l-16 16 1.414 1.414 16-16-1.414-1.414z"
                    ></path></svg
                ></span>
              </Link>
            </li>
          </ul>
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

// Récupérer les données passées par Inertia
const page = usePage();
const idVisiteur = page.props.auth.user.id;
const props = page.props;
const listeFicheFrais = props.listeFicheFrais;

// Configurer moment pour utiliser la locale française
moment.locale("fr");

// Couleurs associées aux états des frais
const statusColors = {
  false: "text-sky-400 bg-sky-400/10", // Non clôturé
  true: "text-gray-400 bg-gray-400/10", // Clôturé
};

// Obtenir le mois et l'année actuels
const currentMonth = moment().format("YYYY-MM");

// Filtrer les fiches de frais qui ont au moins un frais hors forfait ou qui sont dans le mois actuel
const filteredFicheFrais = listeFicheFrais
  .filter((f) => {
    const ficheMonth = moment(f.mois, "YYYY-MM").format("YYYY-MM");

    // Inclure les fiches qui ont des frais hors forfait, des frais forfaitisés, ou celles du mois en cours
    return (
      (Array.isArray(f.frais_hors_forfait) &&
        f.frais_hors_forfait.length > 0) ||
      (Array.isArray(f.frais_forfait) && f.frais_forfait.length > 0) ||
      ficheMonth === currentMonth
    );
  })
  .map((f) => {
    // Ajouter la classe CSS correspondant à l'état de chaque fiche de frais
    f.statusClass = statusColors[f.cloture] || "text-gray-400 bg-gray-400/10";

    // Calcul du montant total des frais hors forfait et forfaitisés validés
    f.montantTotal = 0;

    // Calcul des frais hors forfait (seuls ceux validés ou en attente sont comptabilisés)
    if (Array.isArray(f.frais_hors_forfait)) {
      f.montantTotal += f.frais_hors_forfait.reduce((total, frais) => {
        if (frais.etat === "validé" || frais.etat === "en attente") {
          return total + parseFloat(frais.montant);
        }
        return total;
      }, 0);
    }

    // Calcul des frais forfaitisés (seuls ceux validés ou en attente sont comptabilisés)
    if (Array.isArray(f.frais_forfait)) {
      f.montantTotal += f.frais_forfait.reduce((total, frais) => {
        if (frais.etat === "validé" || frais.etat === "en attente") {
          const montantForfait = frais.type_frais_forfait
            ? parseFloat(frais.type_frais_forfait.montant) * frais.quantite
            : 0;
          return total + montantForfait;
        }
        return total;
      }, 0);
    }

    // Formater le montant total avec deux décimales
    f.montantTotal = f.montantTotal.toFixed(2);

    // Formater la date
    f.formattedDate = moment(f.mois, "YYYY-MM").format("MMMM YYYY");

    return f;
  })
  .filter((f) => f.montantTotal > 0) // Ne conserver que les fiches avec un montant non nul
  .sort((a, b) => moment(b.mois).diff(moment(a.mois))) // Inverser l'ordre des fiches après les transformations
  .slice(0, 7); // Limiter la liste à 7 fiches de frais
</script>
