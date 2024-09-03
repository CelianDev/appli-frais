<template>
  <div>
    <h1>Détails du Frais</h1>
    <p><strong>Libellé :</strong> {{ frais.libelle }}</p>
    <p><strong>Montant :</strong> {{ frais.montant }} €</p>
    <p><strong>Date :</strong> {{ frais.date }}</p>
    <p><strong>État :</strong> {{ frais.etat }}</p>
    <!-- Ajouter d'autres détails nécessaires ici -->
  </div>
</template>

<script setup>
import { usePage } from "@inertiajs/vue3";

// Récupérer le frais passé par Inertia
const page = usePage();
const frais = page.props.fraisDetails;
</script> 
