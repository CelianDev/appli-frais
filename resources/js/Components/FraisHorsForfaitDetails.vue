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
                  Formulaire d'enregistrement de frais
                </h3>
              </div>
              <div class="sm:col-span-3 px-6 py-5 bg-white rounded-md shadow">
                <SelectTypeFrais @type-selected="handleTypeSelection" />
                <FormulaireInputsFraisForfait
                  v-if="isFraisForfait"
                  :montantFrais="selectedMontantFrais"
                  v-model="quantite"
                />
                <!-- Affiche les inputs pour frais hors forfait -->
                <FormulaireInputsFraisHorsForfait
                  v-if="isFraisHorsForfait"
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
import { ref } from "vue";
import { router } from "@inertiajs/vue3";
import { usePage } from "@inertiajs/vue3";
import CardFicheFrais from "@/Components/CardFicheFrais.vue";
import SelectTypeFrais from "@/Components/SelectTypeFrais.vue";
import FormulaireInputsFraisForfait from "@/Components/FormulaireInputsFraisForfait.vue";
import FormulaireInputsFraisHorsForfait from "@/Components/FormulaireInputsFraisHorsForfait.vue";
import SubmitButtonFormulaireFrais from "@/Components/SubmitButtonFormulaireFrais.vue";

// Récupérer les données dynamiques depuis page.props
const page = usePage();
const mois = page.props.ficheFrais.mois; // Récupérer le mois depuis les props
const idVisiteur = page.props.auth.user.id;

// Variables pour déterminer quel formulaire afficher
const isFraisForfait = ref(false);
const isFraisHorsForfait = ref(false);
const selectedMontantFrais = ref(0);
const selectedTypeFrais = ref({});
const quantite = ref(1); // Quantité saisie par l'utilisateur
const files = ref([]); // Variable pour stocker les fichiers sélectionnés

// Fonction pour gérer le type sélectionné
const handleTypeSelection = (selectedType) => {
  if (selectedType.libelle === "Hors forfait") {
    isFraisForfait.value = false;
    isFraisHorsForfait.value = true;
  } else {
    isFraisForfait.value = true;
    isFraisHorsForfait.value = false;
    selectedMontantFrais.value = parseFloat(selectedType.montant);
    selectedTypeFrais.value = selectedType; // On sauvegarde le type de frais sélectionné
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
    // Si le frais est hors forfait
    routeName = "frais-hors-forfait.store";
    const formData = new FormData();

    console.log("Libelle:", libelle.value); // Ajoute ce log pour vérifier la valeur de libelle
    console.log("Montant:", price.value); // Ajoute ce log pour vérifier la valeur de price

    formData.append("libelle", libelle.value);
    formData.append("montant", price.value);

    // Ajouter les fichiers sélectionnés au FormData
    files.value.forEach((file, index) => {
      formData.append(`justificatifs[${index}]`, file);
    });

    data = formData;
  } else {
    // Si le frais est forfaitaire
    routeName = "frais.store";
    data = {
      type_frais_forfait_id: selectedTypeFrais.value.id, // ID du type de frais sélectionné
      quantite: quantite.value, // Quantité saisie par l'utilisateur
    };
  }

  console.log("Données à envoyer :", data);
  console.log("Mois :", mois);
  console.log("ID Visiteur :", idVisiteur);

  // Utilisation de la route en fonction du type de frais
  router.post(route(routeName, { mois: mois, idVisiteur: idVisiteur }), data, {
    preserveScroll: true, // Conserve la position du scroll si nécessaire
    onSuccess: () => {
      // console.log("Frais enregistré avec succès !");
      // Redirection vers la fiche frais après succès
      router.visit(
        route("fiche-frais.show", { mois: mois, idVisiteur: idVisiteur }),
        {
          preserveScroll: true,
          replace: true, // Remplace l'historique
          data: {
            notification: {
              titre: "Frais ajouté avec succès !",
              message: "Votre frais a été enregistré.",
              etat: "success",
            },
          },
        }
      );
    },
    onError: (errors) => {
      console.error("Une erreur est survenue :", errors);
      // Reste sur la même page avec les erreurs
      router.visit(
        route("frais.create", { mois: mois, idVisiteur: idVisiteur }),
        {
          preserveScroll: true,
          replace: true,
          data: {
            notification: {
              titre: "Erreur lors de l'enregistrement",
              message: errors,
              etat: "fail",
            },
          },
        }
      );
    },
  });
};
</script>

