<template>
  <div
    class="sm:col-span-3 md:flex md:flex-row md:gap-y-0 gap-y-3 gap-x-3 mt-4"
  >
    <!-- Champ Libelle -->
    <div class="w-full">
      <label
        for="libelle"
        class="block text-sm font-medium leading-6 text-gray-900"
      >
        Libelle
      </label>
      <div class="mt-2">
        <input
          type="text"
          name="libelle"
          id="libelle"
          maxlength="64"
          v-model="localLibelle"
          @input="handleLibelleInput"
          class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-sky-600 sm:text-sm sm:leading-6"
          placeholder="Réservation de salle"
        />
      </div>
    </div>

    <!-- Champ Montant -->
    <div class="w-full mt-4 md:mt-0">
      <label
        for="price"
        class="block text-sm font-medium leading-6 text-gray-900"
      >
        Montant
      </label>
      <div class="relative mt-2 rounded-md shadow-sm">
        <div
          class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3"
        >
          <span class="text-gray-500 sm:text-sm">€</span>
        </div>
        <input
          type="number"
          name="price"
          id="price"
          v-model="localPrice"
          :max="9999"
          step="0.01"
          @input="handlePriceInput"
          placeholder="XX.XX"
          class="block w-full rounded-md border-0 py-1.5 pl-7 pr-12 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-sky-600 sm:text-sm sm:leading-6"
        />
        <div
          class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3"
        >
          <span class="text-gray-500 sm:text-sm" id="price-currency">EUR</span>
        </div>
      </div>
    </div>
  </div>

  <!-- Gestion des fichiers justificatifs -->
  <div class="col-span-full mt-4">
    <label
      for="justificatifs"
      class="block text-sm font-medium leading-6 text-gray-900"
    >
      Justificatifs
    </label>
    <div
      class="mt-2 flex justify-center rounded-lg border border-dashed border-gray-900/25 px-6 py-10"
    >
      <div class="text-center">
        <PhotoIcon class="mx-auto h-12 w-12 text-gray-300" aria-hidden="true" />
        <div class="mt-4 flex text-sm leading-6 text-gray-600 justify-center">
          <label
            for="file-upload"
            class="relative cursor-pointer rounded-md bg-white font-semibold text-sky-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-sky-600 focus-within:ring-offset-2 hover:text-sky-500"
          >
            <div class="flex flex-col justify-center">
              <div class="flex flex-row justify-center">
                <span>Télécharger des fichiers</span>
                <p class="pl-1 text-gray-600">ou glisser-déposer</p>
              </div>
              <p class="text-xs leading-5 text-gray-600 text-center">
                PNG, JPG, GIF, PDF jusqu'à 10MB - Maximum 5 fichiers
              </p>
            </div>
            <input
              id="file-upload"
              name="file-upload"
              type="file"
              class="sr-only"
              multiple
              @change="handleFileUpload"
            />
          </label>
        </div>
        <div v-if="fileNames.length" class="mt-4">
          <p class="text-sm text-gray-600">Fichiers sélectionnés :</p>
          <ul>
            <li
              v-for="(name, index) in fileNames"
              :key="index"
              class="text-sm text-gray-600"
            >
              {{ name }}
            </li>
          </ul>
        </div>
        <div v-if="errorMessage" class="mt-2 text-sm text-red-600">
          {{ errorMessage }}
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, watch, defineEmits, defineProps } from "vue";
import { PhotoIcon } from "@heroicons/vue/24/solid";

// Déclaration des props
const props = defineProps({
  libelle: {
    type: String,
    required: true,
  },
  price: {
    type: [Number, String], // Accepter les nombres et les chaînes
    required: true,
  },
});

// Émettre des événements vers le parent
const emit = defineEmits(["update:libelle", "update:price", "files-selected"]);

// Variables locales pour gérer les champs du formulaire
const localLibelle = ref(props.libelle);
const localPrice = ref(parseFloat(props.price)); // Convertir en nombre si nécessaire

// Surveiller les props pour mettre à jour les champs si elles changent
watch(
  () => props.libelle,
  (newValue) => {
    localLibelle.value = newValue;
  }
);

watch(
  () => props.price,
  (newValue) => {
    localPrice.value = parseFloat(newValue); // Convertir en nombre si c'est une chaîne
  }
);

// Gérer l'entrée du libellé et émettre l'événement au parent
const handleLibelleInput = () => {
  emit("update:libelle", localLibelle.value);
};

// Gérer l'entrée du prix et émettre l'événement au parent
const handlePriceInput = () => {
  emit("update:price", localPrice.value);
};

// Gestion des fichiers justificatifs
const files = ref([]);
const fileNames = ref([]);
const errorMessage = ref("");

const handleFileUpload = (event) => {
  const selectedFiles = Array.from(event.target.files);
  errorMessage.value = "";

  if (selectedFiles.length > 5) {
    errorMessage.value =
      "Vous ne pouvez sélectionner que 5 fichiers au maximum.";
    return;
  }

  fileNames.value = [];
  files.value = [];

  const allowedTypes = [
    "image/png",
    "image/jpeg",
    "image/gif",
    "application/pdf",
  ];
  const maxSizeInMB = 10;

  selectedFiles.forEach((file) => {
    if (!allowedTypes.includes(file.type)) {
      errorMessage.value = "Certains fichiers ont un type non supporté.";
    } else if (file.size > maxSizeInMB * 1024 * 1024) {
      errorMessage.value = `Le fichier ${file.name} dépasse la taille maximale de ${maxSizeInMB}MB.`;
    } else {
      files.value.push(file);
      fileNames.value.push(file.name);
    }
  });

  if (!errorMessage.value) {
    emit("files-selected", files.value); // Émettre les fichiers validés vers le parent
  }
};
</script>
