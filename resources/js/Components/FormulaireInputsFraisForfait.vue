<template>
  <div class="sm:col-span-3 flex flex-row gap-x-3">
    <!-- Champ Quantité -->
    <div class="w-1/3">
      <label
        for="quantiteFrais"
        class="block text-sm font-medium leading-6 text-gray-900"
      >
        Quantité
      </label>
      <div class="mt-2">
        <input
          v-model="localQuantite"
          type="number"
          name="quantiteFrais"
          id="quantiteFrais"
          class="block w-full rounded-md border-0 py-1.5 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-sky-600 sm:text-sm sm:leading-6"
          placeholder="12 (repas midi)"
          min="1"
          max="99"
          @input="handleInput"
        />
      </div>
    </div>

    <!-- Champ Montant Total -->
    <div class="w-2/3">
      <label
        for="price"
        class="block text-sm font-medium leading-6 text-gray-900"
      >
        Montant total
      </label>
      <div class="relative mt-2 rounded-md shadow-sm">
        <div
          class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3"
        >
          <span class="text-gray-500 sm:text-sm">€</span>
        </div>
        <input
          readonly
          type="text"
          name="price"
          id="price"
          class="block w-full rounded-md border-0 py-1.5 pl-7 pr-12 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-sky-600 sm:text-sm sm:leading-6"
          :value="montantTotal"
        />
        <div
          class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3"
        >
          <span class="text-gray-500 sm:text-sm" id="price-currency">EUR</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, watch, defineEmits } from "vue";
import { usePage } from "@inertiajs/vue3";

const page = usePage();
// Émettre les événements
const emit = defineEmits(["update:modelValue"]);

// Déclaration des props
const props = defineProps({
  montantFrais: {
    type: Number,
    required: true,
    default: 0, // Ajout d'une valeur par défaut pour éviter que le montant soit NaN
  },
  modelValue: Number, // Représente la quantité reçue du parent
});

// Variables pour la quantité et le montant total
const localQuantite = ref(props.modelValue || 1); // Utilisation de la quantité reçue ou valeur par défaut
const montantTotal = ref(
  (localQuantite.value * parseFloat(props.montantFrais)).toFixed(2)
);

// Observer les changements dans la quantité ou le montant des frais pour mettre à jour le montant total
watch([localQuantite, () => props.montantFrais], () => {
  const frais = parseFloat(props.montantFrais);
  montantTotal.value = (localQuantite.value * frais).toFixed(2);
});

// Gérer l'entrée de la quantité
const handleInput = (event) => {
  let value = parseInt(event.target.value, 10);
  if (isNaN(value) || value < 1) {
    value = 1;
  } else if (value > 99) {
    value = 99;
  }
  localQuantite.value = value;
  emit("update:modelValue", localQuantite.value); // Mise à jour de la valeur dans le parent
};

if (page.props.frais) {
  // Si c'est un frais forfait
  if (page.props.frais.type_frais_forfait_id) {
    localQuantite.value = page.props.frais.quantite;
  }
}
</script>
