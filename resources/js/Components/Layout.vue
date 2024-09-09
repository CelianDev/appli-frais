<template>
  <div>
    <TransitionRoot as="template" :show="sidebarOpen">
      <Dialog class="relative z-50 xl:hidden" @close="sidebarOpen = false">
        <TransitionChild
          as="template"
          enter="transition-opacity ease-linear duration-300"
          enter-from="opacity-0"
          enter-to="opacity-100"
          leave="transition-opacity ease-linear duration-300"
          leave-from="opacity-100"
          leave-to="opacity-0"
        >
          <div class="fixed inset-0 bg-gray-900/80" />
        </TransitionChild>

        <div class="fixed inset-0 flex">
          <TransitionChild
            as="template"
            enter="transition ease-in-out duration-300 transform"
            enter-from="-translate-x-full"
            enter-to="translate-x-0"
            leave="transition ease-in-out duration-300 transform"
            leave-from="translate-x-0"
            leave-to="-translate-x-full"
          >
            <DialogPanel class="relative mr-16 flex w-full max-w-xs flex-1">
              <TransitionChild
                as="template"
                enter="ease-in-out duration-300"
                enter-from="opacity-0"
                enter-to="opacity-100"
                leave="ease-in-out duration-300"
                leave-from="opacity-100"
                leave-to="opacity-0"
              >
                <div
                  class="absolute left-full top-0 flex w-16 justify-center pt-5"
                >
                  <button
                    type="button"
                    class="-m-2.5 p-2.5"
                    @click="sidebarOpen = false"
                  >
                    <span class="sr-only">Close sidebar</span>
                    <XMarkIcon class="h-6 w-6 text-white" aria-hidden="true" />
                  </button>
                </div>
              </TransitionChild>
              <div
                class="flex grow flex-col gap-y-5 overflow-y-auto bg-sky-600 px-6 pb-4"
              >
                <div class="flex h-16 shrink-0 items-center">
                  <img
                    class="h-8 w-auto"
                    src="https://tailwindui.com/img/logos/mark.svg?color=white"
                    alt="Your Company"
                  />
                </div>
                <nav class="flex flex-1 flex-col">
                  <ul role="list" class="flex flex-1 flex-col gap-y-7">
                    <li>
                      <ul role="list" class="-mx-2 space-y-1">
                        <li
                          class="p-1"
                          v-for="item in navigation"
                          :key="item.name"
                        >
                          <Link
                            :href="item.href"
                            :class="[
                              item.current
                                ? 'bg-sky-700 text-white'
                                : 'border text-sky-200 hover:bg-sky-700 hover:text-white',
                              'group flex gap-x-3 rounded-md p-2 text-sm font-semibold leading-6',
                            ]"
                          >
                            <component
                              :is="item.icon"
                              :class="[
                                item.current
                                  ? 'text-white'
                                  : 'text-sky-200 group-hover:text-white',
                                'h-6 w-6 shrink-0',
                              ]"
                              aria-hidden="true"
                            />
                            {{ item.name }}
                          </Link>
                        </li>
                      </ul>
                    </li>
                    <!-- <li>
                      <div class="text-xs font-semibold leading-6 text-sky-200">
                        Your teams
                      </div>
                      <ul role="list" class="-mx-2 mt-2 space-y-1">
                        <li v-for="team in teams" :key="team.name">
                          <Link
                            :href="team.href"
                            :class="[
                              team.current
                                ? 'bg-sky-700 text-white'
                                : 'text-sky-200 hover:bg-sky-700 hover:text-white',
                              'group flex gap-x-3 rounded-md p-2 text-sm font-semibold leading-6',
                            ]"
                          >
                            <span
                              class="flex h-6 w-6 shrink-0 items-center justify-center rounded-lg border border-sky-400 bg-sky-500 text-[0.625rem] font-medium text-white"
                              >{{ team.initial }}</span
                            >
                            <span class="truncate">{{ team.name }}</span>
                          </Link>
                        </li>
                      </ul>
                    </li> -->
                    <li class="mt-auto">
                      <Link
                        href="#"
                        class="group -mx-2 flex gap-x-3 rounded-md p-2 text-sm font-semibold leading-6 text-sky-200 hover:bg-sky-700 hover:text-white"
                      >
                        <Cog6ToothIcon
                          class="h-6 w-6 shrink-0 text-sky-200 group-hover:text-white"
                          aria-hidden="true"
                        />
                        Settings
                      </Link>
                    </li>
                  </ul>
                </nav>
              </div>
            </DialogPanel>
          </TransitionChild>
        </div>
      </Dialog>
    </TransitionRoot>

    <!-- Static sidebar for desktop -->
    <div
      class="hidden xl:fixed xl:inset-y-0 xl:z-50 xl:flex xl:w-72 xl:flex-col"
    >
      <div
        class="flex grow flex-col gap-y-5 overflow-y-auto bg-sky-600 px-6 pb-4"
      >
        <div class="flex h-16 shrink-0 items-center">
          <img
            class="h-8 w-auto"
            src="https://tailwindui.com/img/logos/mark.svg?color=white"
            alt="Your Company"
          />
        </div>
        <nav class="flex flex-1 flex-col">
          <ul role="list" class="flex flex-1 flex-col gap-y-7">
            <li>
              <ul role="list" class="-mx-2">
                <li class="p-3" v-for="item in navigation" :key="item.name">
                  <Link
                    :href="item.href"
                    :class="[
                      item.current
                        ? 'bg-sky-700 text-white'
                        : 'border text-sky-200 hover:bg-sky-700 hover:text-white',
                      'group flex gap-x-3 rounded-md p-2 text-sm font-semibold leading-6',
                    ]"
                  >
                    <component
                      :is="item.icon"
                      :class="[
                        item.current
                          ? 'text-white'
                          : 'text-sky-200 group-hover:text-white',
                        'h-6 w-6 shrink-0',
                      ]"
                      aria-hidden="true"
                    />
                    {{ item.name }}
                  </Link>
                </li>
              </ul>
            </li>
            <!-- <li>
              <div class="text-xs font-semibold leading-6 text-sky-200">
                Your teams
              </div>
              <ul role="list" class="-mx-2 mt-2 space-y-1">
                <li v-for="team in teams" :key="team.name">
                  <Link
                    :href="team.href"
                    :class="[
                      team.current
                        ? 'bg-sky-700 text-white'
                        : 'text-sky-200 hover:bg-sky-700 hover:text-white',
                      'group flex gap-x-3 rounded-md p-2 text-sm font-semibold leading-6',
                    ]"
                  >
                    <span
                      class="flex h-6 w-6 shrink-0 items-center justify-center rounded-lg border border-sky-400 bg-sky-500 text-[0.625rem] font-medium text-white"
                      >{{ team.initial }}</span
                    >
                    <span class="truncate">{{ team.name }}</span>
                  </Link>
                </li>
              </ul>
            </li> -->
            <li class="mt-auto">
              <Link
                href="#"
                class="group -mx-2 flex gap-x-3 rounded-md p-2 text-sm font-semibold leading-6 text-sky-200 hover:bg-sky-700 hover:text-white"
              >
                <Cog6ToothIcon
                  class="h-6 w-6 shrink-0 text-sky-200 group-hover:text-white"
                  aria-hidden="true"
                />
                Settings
              </Link>
            </li>
          </ul>
        </nav>
      </div>
    </div>

    <div class="xl:pl-72">
      <div
        class="sticky top-0 z-40 flex h-16 shrink-0 items-center gap-x-4 border-b border-gray-200 bg-white px-4 shadow-sm sm:gap-x-6 sm:px-6 xl:px-8"
      >
        <button
          type="button"
          class="-m-2.5 p-2.5 text-gray-700 xl:hidden"
          @click="sidebarOpen = true"
        >
          <span class="sr-only">Open sidebar</span>
          <Bars3Icon class="h-6 w-6" aria-hidden="true" />
        </button>

        <!-- Separator -->
        <div class="h-6 w-px bg-gray-900/10 xl:hidden" aria-hidden="true" />

        <div
          class="flex flex-1 justify-between items-center gap-x-4 xl:gap-x-6"
        >
          <div>
            <h1 class="text-lg flex font-semibold text-gray-900">
              Bienvenue, {{ auth?.user?.first_name || "Invité" }}
            </h1>
          </div>
          <Menu as="div" class="relative flex self-end">
            <MenuButton class="-m-1.5 flex items-center p-1.5">
              <span class="sr-only">Open user menu</span>
              <img
                class="h-8 w-8 rounded-full bg-gray-50"
                src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                alt=""
              />
              <span class="hidden xl:flex xl:items-center">
                <span
                  class="ml-4 text-sm font-semibold leading-6 text-gray-900"
                  aria-hidden="true"
                  >{{ auth?.user?.first_name || "Invité" }}
                  {{ auth?.user?.name || "Invité" }}</span
                >
                <ChevronDownIcon
                  class="ml-2 h-5 w-5 text-gray-400"
                  aria-hidden="true"
                />
              </span>
            </MenuButton>
            <transition
              enter-active-class="transition ease-out duration-100"
              enter-from-class="transform opacity-0 scale-95"
              enter-to-class="transform opacity-100 scale-100"
              leave-active-class="transition ease-in duration-75"
              leave-from-class="transform opacity-100 scale-100"
              leave-to-class="transform opacity-0 scale-95"
            >
              <MenuItems
                class="absolute right-0 z-10 mt-2.5 w-32 origin-top-right rounded-md bg-white py-2 shadow-lg ring-1 ring-gray-900/5 focus:outline-none"
              >
                <MenuItem
                  v-for="item in userNavigation"
                  :key="item.name"
                  v-slot="{ active }"
                >
                  <Link
                    :href="item.href"
                    :method="item.method"
                    :as="item.as"
                    :class="[
                      active ? 'bg-gray-50' : '',
                      'block px-3 py-1 text-sm leading-6 text-gray-900',
                    ]"
                  >
                    {{ item.name }}
                  </Link>
                </MenuItem>
              </MenuItems>
            </transition>
          </Menu>
        </div>
      </div>
      <!-- Main and aside content -->
      <div
        class="flex-grow bg-slate-100"
        :style="`min-height: calc(100vh - 4rem);`"
      >
        <Content />
      </div>
    </div>
  </div>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
import Content from "@/Components/Content.vue";
const logout = () => {
  Inertia.post(route("logout"));
};

import { ref } from "vue";
import moment from "moment";
import {
  Dialog,
  DialogPanel,
  Menu,
  MenuButton,
  MenuItem,
  MenuItems,
  TransitionChild,
  TransitionRoot,
} from "@headlessui/vue";
import {
  Bars3Icon,
  BellIcon,
  CalendarIcon,
  ChartPieIcon,
  Cog6ToothIcon,
  DocumentDuplicateIcon,
  FolderIcon,
  FolderPlusIcon,
  FolderOpenIcon,
  PencilSquareIcon,
  HomeIcon,
  UsersIcon,
  XMarkIcon,
} from "@heroicons/vue/24/outline";
import { ChevronDownIcon, MagnifyingGlassIcon } from "@heroicons/vue/20/solid";

// Définir les props
const props = defineProps({
  auth: Object,
});

const idVisiteur = props.auth.user.id;
const mois = moment().format("YYYY-MM");

const navigation = [
  {
    name: "Dashboard",
    href: route("dashboard"),
    icon: HomeIcon,
    current: route().current("dashboard"),
  },
  {
    name: "Nouveau Frais",
    href: route("frais.create", { mois, idVisiteur }),
    icon: PencilSquareIcon,
    current: route().current("frais.create"),
  },
  {
    name: "Mes Frais",
    href: route("fiche-frais.index", { idVisiteur }),
    icon: FolderOpenIcon,
    current:
      route().current("fiche-frais.index") ||
      route().current("fiche-frais.show"), // Vérifier les deux séparément
  },
  // { name: "Calendar", href: "#", icon: CalendarIcon, current: false },
  // { name: "Documents", href: "#", icon: DocumentDuplicateIcon, current: false },
  // { name: "Reports", href: "#", icon: ChartPieIcon, current: false },
];

const teams = [
  // { id: 1, name: "Heroicons", href: "#", initial: "H", current: false },
  // { id: 2, name: "Tailwind Labs", href: "#", initial: "T", current: false },
  // { id: 3, name: "Workcation", href: "#", initial: "W", current: false },
];

const userNavigation = [
  { name: "Your profile", href: "#", method: "get", as: "button" },
  { name: "Sign out", href: route("logout"), method: "post", as: "button" },
];

const sidebarOpen = ref(false);
</script>
