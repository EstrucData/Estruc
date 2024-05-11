<template>
    <div class="inicio">
      <h2>Bienvenido</h2>
      <p>¿Qué te gustaría hacer?</p>
      <button @click="irALogin">Iniciar Sesión</button>
      <button @click="irARegistro">Registrarse</button>
    </div>
  </template>
  
  <script>
  export default {
    methods: {
      irALogin() {
        this.$router.push('/login');
      },
      irARegistro() {
        this.$router.push('/registro');
      }
    }
  };
  </script>
  
  <style scoped>
  /* Estilos opcionales para tu componente */
  .inicio {
    text-align: center;
    margin-top: 50px;
  }
  button {
    margin: 10px;
  }
  </style>
  