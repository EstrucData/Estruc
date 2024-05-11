<template>
  <div class="register-form">
    <h1 class="titulo">Registrarse</h1>
    <form @submit.prevent="registerUser">
      <label for="firstName">Nombres:</label>
      <input type="text" id="firstName" v-model="firstName" required>
      <br>
      <label for="lastName">Apellidos:</label>
      <input type="text" id="lastName" v-model="lastName" required>
      <br>
      <label for="newUsername">Usuario:</label>
      <input type="text" id="newUsername" v-model="newUsername" required>
      <br>
      <label for="newPassword">Contraseña:</label>
      <input type="password" id="newPassword" v-model="newPassword" required>
      <br>
      <label for="selectedCareer">Carrera:</label>
      <select v-model="selectedCareer" required>
        <option v-for="career in careers" :key="career.id_carrera" :value="career.id_carrera">{{ career.nombre }}</option>
      </select>
      <br>
      <button type="submit">Registrarse</button>
    </form>
  </div>
</template>

<script>
import axios from 'axios';
import Swal from 'sweetalert2';

export default {
  data() {
    return {
      firstName: '',
      lastName: '',
      newUsername: '',
      newPassword: '',
      selectedCareer: null,
      careers: []
    };
  },
  methods: {
    registerUser() {
      const userData = {
        firstName: this.firstName,
        lastName: this.lastName,
        newUsername: this.newUsername,
        newPassword: this.newPassword,
        selectedCareer: this.selectedCareer
      };

      axios.post('http://localhost/ESTRUC/back/registro.php', userData)
        .then(response => {
          console.log(response.data);
          if (response.data.nombre) {
            Swal.fire(`Usuario ${this.newUsername} registrado correctamente en la carrera ${response.data.nombre}.`);
            this.$router.push('/login'); 
          } else {
            Swal.fire(`Usuario ${this.newUsername} registrado correctamente.`);
            this.$router.push('/login'); 
          }
        })
        .catch(error => {
          console.error('Error al registrar usuario:', error);
          Swal.fire('Error al registrar usuario. Por favor, inténtalo de nuevo.');
        });
    },
    loadCareers() {
      axios.get('http://localhost/ESTRUC/back/obtener_carreras.php')
        .then(response => {
          this.careers = response.data;
        })
        .catch(error => {
          console.error('Error al cargar las carreras:', error);
        });
    }
  },
  mounted() {
    this.loadCareers();
  }
};
</script>
 
  
  <style scoped>
  /* Estilos compartidos */
  .register-form {
    margin-bottom: 20px;
  }
  
  .titulo {
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
  
  .titulo {
    margin: 0;
    font-weight: bold;
    color: #333;
    margin-bottom: 10px;
  }
  </style>
  
  