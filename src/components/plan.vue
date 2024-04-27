<template>
    <div class="plan-container">
      <h1>Plan de Estudios Ideal</h1>
      <p>A continuación tienes el plan de estudios recomendado para tu carrera:</p>
      <img src="@/assets/plan_TI.png" alt="Plan de estudios" />
      <button @click="goBack">Regresar</button>
    </div>
  </template>
  
  <script>
  export default {
    methods: {
      goBack() {
        this.$router.go(-1);
      },
    },
  };
  </script>
  
  <style scoped>

  .plan-container {
    text-align: center;
    margin-top: 20px;
  }
  </style>
  
  