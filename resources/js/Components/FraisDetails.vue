<template>
  <div class="">
    <div class="mx-auto px-4 sm:px-6 lg:px-8">
      <form @submit.prevent="submitFrais" class="min-h-full">
        <div class="space-y-12">
          <div class="flex flex-col md:flex-row min-h-full">
            <!-- Formulaire (occupant 2/3 de l'espace sur les grands écrans) -->
            <div class="flex-1 max-w-2xl flex flex-col gap-4">
              <div class="sm:col-span-3 px-6 py-2 bg-white rounded-md shadow">
                <h3 class="text-base font-semibold leading-6 text-gray-900">
                  {{ fraisLibelle }}
                  <!-- Affiche le type et libellé -->
                </h3>
              </div>

              <div class="sm:col-span-3 px-6 py-5 bg-white rounded-md shadow">
                <SelectTypeFrais
                  @type-selected="handleTypeSelection"
                  :selected="fraisTypeSelected"
                />

                <!-- Affiche le formulaire pour frais forfait -->
                <FormulaireInputsFraisForfait
                  v-if="isFraisForfait"
                  class="mt-4"
                  :montantFrais="selectedMontantFrais"
                  v-model="quantite"
                />

                <!-- Affiche le formulaire pour frais hors forfait -->
                <FormulaireInputsFraisHorsForfait
                  v-if="isFraisHorsForfait"
                  v-model:libelle="libelle"
                  v-model:price="montant"
                  @files-selected="handleFiles"
                />
              </div>
              <SubmitButtonFormulaireFrais />
            </div>

            <!-- Section qui contient CardFicheFrais (sera cachée sur mobile, visible sur grand écran) -->
            <div class="hidden md:flex md:min-w-1/3 md:h-full">
              <CardFicheFrais class="w-full h-full" />
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { router } from "@inertiajs/vue3";
import { usePage } from "@inertiajs/vue3";
import CardFicheFrais from "@/Components/CardFicheFrais.vue";
import SelectTypeFrais from "@/Components/SelectTypeFrais.vue";
import FormulaireInputsFraisForfait from "@/Components/FormulaireInputsFraisForfait.vue";
import FormulaireInputsFraisHorsForfait from "@/Components/FormulaireInputsFraisHorsForfait.vue";
import SubmitButtonFormulaireFrais from "@/Components/SubmitButtonFormulaireFrais.vue";

// Récupérer les données dynamiques depuis page.props
const page = usePage();
const frais = page.props.frais; // Récupérer les frais depuis les props
console.log(frais);
const mois = page.props.ficheFrais.mois; // Récupérer le mois depuis les props
const idVisiteur = page.props.auth.user.id;
const typesFrais = page.props.typesFrais; // Récupérer les types de frais depuis les props
var montantFrais = 0;
var libelleFrais = "";

// Variables pour déterminer quel formulaire afficher
const isFraisForfait = ref(false);
const isFraisHorsForfait = ref(false);
const selectedMontantFrais = ref(0);
const selectedTypeFrais = ref({});
const quantite = ref(1); // Quantité saisie par l'utilisateur
const libelle = ref(""); // Libellé pour frais hors forfait
const montant = ref(0); // Montant pour frais hors forfait
const files = ref([]); // Fichiers pour frais hors forfait

console.log("libelle:", libelle.value);
console.log("montant:", montant.value);

// Détection du type de frais (forfait ou hors forfait)
const fraisType = ref("");
const fraisLibelle = ref("");

// Pré-remplir les champs en fonction du type de frais reçu
const fraisTypeSelected = ref(null);

onMounted(() => {
  // Si c'est un frais forfait
  if (frais.type_frais_forfait_id) {
    console.log("Frais forfaitaire");
    typesFrais.forEach((element) => {
      if (element.id === frais.type_frais_forfait_id) {
        montantFrais = parseFloat(element.montant);
        libelleFrais = element.libelle;
      }
    });
    isFraisForfait.value = true;
    fraisType.value = "";
    fraisLibelle.value = libelleFrais;
    selectedMontantFrais.value = montantFrais;
    quantite.value = frais.quantite;
    fraisTypeSelected.value = {
      id: frais.type_frais_forfait_id,
      libelle: fraisLibelle.value,
    };
  }
  // Si c'est un frais hors forfait
  if (frais.libelle && frais.montant) {
    isFraisHorsForfait.value = true;
    fraisLibelle.value = frais.libelle;
    libelle.value = frais.libelle; // Remplir le libellé avec les données
    montant.value = frais.montant; // Remplir le montant avec les données
  }
});

// Fonction pour gérer la sélection du type de frais
const handleTypeSelection = (selectedType) => {
  if (selectedType.libelle === "Hors forfait") {
    isFraisForfait.value = false;
    isFraisHorsForfait.value = true;
  } else {
    isFraisForfait.value = true;
    isFraisHorsForfait.value = false;
    selectedMontantFrais.value = parseFloat(selectedType.montant);
    selectedTypeFrais.value = selectedType; // Sauvegarder le type de frais sélectionné
  }
};

// Fonction pour gérer les fichiers sélectionnés
const handleFiles = (selectedFiles) => {
  files.value = selectedFiles; // Stocker les fichiers sélectionnés
};

// Soumission du formulaire
const submitFrais = () => {
  let routeName;
  let data;

  if (isFraisHorsForfait.value) {
    console.log("Libelle:", libelle.value);
    console.log("Montant:", montant.value);
    // Soumettre un frais hors forfait
    routeName = "frais-hors-forfait.update";
    data = {
      libelle: libelle.value,
      montant: montant.value,
      justificatifs: files.value,
    };
  } else {
    // Soumettre un frais forfaitaire
    routeName = "frais.update";
    data = {
      type_frais_forfait_id: selectedTypeFrais.value.id,
      quantite: quantite.value,
    };
  }

  // Envoyer les données via Inertia
  router.put(
    route(routeName, {
      mois: mois,
      idVisiteur: idVisiteur,
      id: frais.id,
    }),
    data,
    {
      preserveScroll: true,
      onSuccess: () => {
        router.visit(
          route("fiche-frais.show", {
            mois: mois,
            idVisiteur: idVisiteur,
            id: frais.id,
          }),
          {
            preserveScroll: true,
            replace: true,
            data: {
              notification: {
                titre: "Frais modifié avec succès !",
                message: "Le frais a été modifié avec succès.",
                etat: "success",
              },
            },
          }
        );
      },
      onError: (errors) => {
        console.error("Erreur :", errors);
        router.visit(window.location.href, {
          preserveScroll: true,
          data: {
            notification: {
              titre: "Erreur!",
              message: errors,
              etat: "fail",
            },
          },
          replace: true,
        });
      },
    }
  );
};
</script>
