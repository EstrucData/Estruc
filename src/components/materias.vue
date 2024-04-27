<template>
    <div class="materias-container">
      <h1>Selecciona tus materias</h1>
      <p>Marca las materias que has cursado hasta ahora:</p>
      <div class="materias-list">
        <label v-for="materia in materias" :key="materia.id">
          <input type="checkbox" v-model="materia.cursada">
          {{ materia.nombre }}
        </label>
      </div>
      <button @click="calcularMateriasFaltantes">Calcular materias faltantes</button>
      <button @click="consultarPlan">Consultar plan de estudio</button>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        materias: [
          { id: 1, nombre: 'PIMAT', cursada: false },
          { id: 2, nombre: 'ALGORITMOS DE PROGRAMACION', cursada: false },
        ],
      };
    },
    methods: {
      calcularMateriasFaltantes() {
      },
      consultarPlan() {
        this.$router.push('/plan'); 
      },
    },
  };
  </script>
  
  <style>
.materias-container {
  max-width: 600px;
  margin: 0 auto;
  padding: 20px;
  text-align: center;
}

.materias-list {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 10px;
  margin-top: 20px;
}

label {
  display: block;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
  cursor: pointer;
}

label:hover {
  background-color: #f0f0f0;
}

input[type="checkbox"] {
  margin-right: 10px;
}

button {
  padding: 10px 20px;
  margin-top: 20px;
  background-color: #ff5900;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  margin-left: 10px;
  margin-right: 10px;
}

button:hover {
  background-color: #ff5900;
}

h1 {
  font-size: 28px;
  margin-bottom: 20px;
}

p {
  font-size: 16px;
  margin-bottom: 20px;
}
</style>

  