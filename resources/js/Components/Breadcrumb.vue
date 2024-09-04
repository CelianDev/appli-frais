<template>
  <nav class="flex px-4 pt-10 sm:px-6 lg:px-8 lg:pt-6" aria-label="Breadcrumb">
    <ol role="list" class="flex space-x-4 rounded-md bg-white px-6 shadow">
      <!-- Lien vers la page d'accueil -->
      <li class="flex">
        <div class="flex items-center">
          <Link href="/" class="text-gray-400 hover:text-gray-500">
            <HomeIcon class="h-5 w-5 flex-shrink-0" aria-hidden="true" />
            <span class="sr-only">Home</span>
          </Link>
        </div>
      </li>

      <!-- Autres parties du breadcrumb, toutes cliquables -->
      <li v-for="page in breadcrumb" :key="page.name" class="flex">
        <div class="flex items-center">
          <svg
            class="h-full w-6 flex-shrink-0 text-gray-200"
            viewBox="0 0 24 44"
            preserveAspectRatio="none"
            fill="currentColor"
            aria-hidden="true"
          >
            <path d="M.293 0l22 22-22 22h1.414l22-22-22-22H.293z" />
          </svg>
          <Link
            :href="page.href"
            class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700"
            :aria-current="page.current ? 'page' : undefined"
            >{{ page.name }}</Link
          >
        </div>
      </li>
    </ol>
  </nav>
</template>

<script setup>
import { Link, usePage } from "@inertiajs/vue3"; // Importer `Link` et `usePage`
import { HomeIcon } from "@heroicons/vue/20/solid";

// Récupérer les données du breadcrumb passées par le contrôleur
const page = usePage();
const breadcrumb = page.props.breadcrumb; // Données du breadcrumb envoyées par le contrôleur
</script>
