<template>
  <nav
    class="flex px-4 py-6 sm:px-6 lg:px-8 lg:py-6 bg-slate-100"
    aria-label="Breadcrumb"
  >
    <ol role="list" class="px-4 sm:px-0 flex rounded-md bg-white shadow">
      <!-- Lien vers la page d'accueil -->
      <li class="flex">
        <div class="flex items-center">
          <Link
            href="/"
            class="px-0 sm:px-6 w-full h-full flex flex-row items-center text-sm font-medium text-gray-400 hover:text-gray-500"
          >
            <HomeIcon class="h-5 w-5 flex-shrink-0" aria-hidden="true" />
            <!-- <span class="sr-only">Home</span> -->
          </Link>
        </div>
      </li>

      <!-- Autres parties du breadcrumb, toutes cliquables -->
      <li v-for="page in breadcrumb" :key="page.name" class="flex">
        <div class="flex items-center flex-row">
          <Link
            :href="page.href"
            :class="[
              page.current
                ? 'text-sky-500'
                : 'text-gray-500 hover:text-gray-700',
              'w-full flex flex-row items-center text-sm font-medium',
            ]"
            :aria-current="page.current ? 'page' : undefined"
          >
            <svg
              class="h-full w-6 flex-shrink-0 text-gray-200"
              viewBox="0 0 24 44"
              preserveAspectRatio="none"
              fill="currentColor"
              aria-hidden="true"
            >
              <path d="M.293 0l22 22-22 22h1.414l22-22-22-22H.293z" />
            </svg>
            <div class="ps-2 px-0 sm:px-6">
              {{ page.name }}
            </div>
          </Link>
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
