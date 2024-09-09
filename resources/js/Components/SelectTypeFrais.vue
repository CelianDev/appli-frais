  <template>
  <Listbox as="div" v-model="selected">
    <ListboxLabel class="block text-sm font-medium leading-6 text-gray-900">
      Type de frais
    </ListboxLabel>
    <div class="relative mt-2">
      <ListboxButton
        class="relative w-full cursor-default rounded-md bg-white py-1.5 pl-3 pr-10 text-left text-gray-900 shadow ring-1 ring-inset ring-gray-300 focus:outline-none focus:ring-2 focus:ring-sky-500 sm:text-sm sm:leading-6"
      >
        <span class="inline-flex w-full truncate items-center">
          <span class="truncate">{{ selected.libelle }}</span>
          <span v-if="selected.formattedMontant" class="px-3">-</span>
          <span class="truncate items-center text-gray-500">{{
            selected.formattedMontant
          }}</span>
        </span>
        <span
          class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2"
        >
          <ChevronUpDownIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
        </span>
      </ListboxButton>

      <transition
        leave-active-class="transition ease-in duration-100"
        leave-from-class="opacity-100"
        leave-to-class="opacity-0"
      >
        <ListboxOptions
          class="absolute z-10 mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm"
        >
          <ListboxOption
            as="template"
            v-for="typeFrais in typesFrais.filter(
              (type) => type.libelle !== defaultOption.libelle
            )"
            :key="typeFrais.libelle"
            :value="typeFrais"
            v-slot="{ active, selected }"
          >
            <li
              :class="[
                active ? 'bg-sky-600 text-white' : 'text-gray-900',
                'relative cursor-default select-none py-2 pl-3 pr-9',
              ]"
            >
              <div class="flex">
                <span
                  :class="[
                    selected ? 'font-semibold' : 'font-normal',
                    'truncate',
                  ]"
                  >{{ typeFrais.libelle }}</span
                >
                <span
                  v-if="typeFrais.formattedMontant"
                  :class="[
                    selected ? 'font-semibold' : 'font-normal',
                    'truncate',
                    'px-3',
                  ]"
                  >-</span
                >
                <span
                  :class="[
                    active ? 'text-sky-200' : 'text-gray-500',
                    'truncate',
                  ]"
                  >{{ typeFrais.formattedMontant }}</span
                >
              </div>
              <span
                v-if="selected"
                :class="[
                  active ? 'text-white' : 'text-sky-600',
                  'absolute inset-y-0 right-0 flex items-center pr-4',
                ]"
              >
                <CheckIcon class="h-5 w-5" aria-hidden="true" />
              </span>
            </li>
          </ListboxOption>
        </ListboxOptions>
      </transition>
    </div>
  </Listbox>
</template>

  <script setup>
import { ref, watch } from "vue";
import { usePage } from "@inertiajs/vue3";
import {
  Listbox,
  ListboxButton,
  ListboxLabel,
  ListboxOption,
  ListboxOptions,
} from "@headlessui/vue";
import { CheckIcon, ChevronUpDownIcon } from "@heroicons/vue/20/solid";

// Émettre un événement vers le parent
const emit = defineEmits(["type-selected"]);

const page = usePage();
const typesFrais = page.props.typesFrais;
const frais = page.props.frais;

typesFrais.forEach((f) => {
  f.formattedMontant = parseFloat(f.montant).toLocaleString("fr-FR", {
    style: "currency",
    currency: "EUR",
    minimumFractionDigits: 2,
    maximumFractionDigits: 2,
  });
});

// Option par défaut qui ne sera pas dans la liste des options sélectionnables
const defaultOption = {
  libelle: "Sélectionner un type de frais",
  formattedMontant: "",
};

// Ajouter une option "Hors forfait"
typesFrais.push({
  libelle: "Hors forfait",
  formattedMontant: "",
});

// L'option sélectionnée de base est l'option par défaut
const selected = ref(defaultOption);

// Surveiller les changements et émettre l'événement avec l'objet complet
watch(selected, () => {
  emit("type-selected", selected.value); // On envoie l'objet sélectionné
});

if (page.props.frais) {
  // Si c'est un frais forfait
  selected.value = typesFrais.find(
    (type) => type.id === frais.type_frais_forfait_id
  );
}
</script>
