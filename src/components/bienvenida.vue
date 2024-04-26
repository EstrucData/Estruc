<template>
    <div class="career-and-subjects-container">
      <div v-if="!selectedCareer">
        <h1 class="titulo">Selecciona tu carrera</h1>
        <select v-model="selectedCareer">
          <option value="">Selecciona una carrera</option>
          <option value="Tecnologías de la Información y Negocios Digitales">Tecnologías de la Información y Negocios Digitales</option>
          <option value="Mecatrónica">Mecatrónica</option>
          <option value="Biomedicina">Biomedicina</option>
          <option value="Civil">Civil</option>
        </select>
        <button @click="selectCareer">Continuar</button>
      </div>
      <div v-else>
        <h1 class="titulo">Bienvenido a nuestra plataforma de seguimiento académico</h1>
        <p>Aquí podrás ver tu progreso en la carrera y elegir tus próximas materias.</p>
        <button @click="redirectToSubjects">Seleccionar materias</button>
      </div>
    </div>
  </template>
  
  <script>
  import Swal from 'sweetalert2';

  export default {
    data() {
      return {
        selectedCareer: '', // Almacena la carrera seleccionada por el usuario
      };
    },
    methods: {
      selectCareer() {
        if (this.selectedCareer) {
          // Continúa solo si se ha seleccionado una carrera
          // Puedes realizar otras acciones aquí si es necesario
        } else {
          Swal.fire('Por favor, selecciona una carrera antes de continuar.');
        }
      },
      redirectToSubjects() {
        this.$router.push('/materias'); // Redirige al usuario a la página de selección de materias
      },
    },
  };
  </script>
  
  <style>
.career-and-subjects-container {
  max-width: 500px;
  margin: 0 auto;
  padding: 20px;
  text-align: center;
}

select {
  width: 100%;
  padding: 10px;
  margin-top: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
}

button {
  padding: 10px 20px;
  margin-top: 20px;
  background-color: #ff5900;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

button:hover {
  background-color: #ff5900;
}

h1 {
  font-size: 24px;
  margin-bottom: 20px;
}

p {
  font-size: 16px;
  margin-bottom: 20px;
}

.titulo{
  padding: 5px;
  border-radius: 10px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  transition: all 0.3s ease-in-out; 
  margin-bottom: 10px;
}

.titulo:hover {
  box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
  transform: translateY(-5px); 
  border: 1px solid #ccc;
}

.titulo{
  margin: 0;
  font-weight: bold;
  color: #333;
  margin-bottom: 10px;
}

</style>

  
  