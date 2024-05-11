<template>
  <div class="login-form">
    <h1 class="titulo">Iniciar sesión</h1>
    <form @submit.prevent="loginUser">
      <label for="username">Usuario:</label>
      <input type="text" id="username" v-model="username" required>
      <br>
      <label for="password">Contraseña:</label>
      <input type="password" id="password" v-model="password" required>
      <br>
      <button type="submit">Iniciar sesión</button>
    </form>
  </div>
</template>

<script>
import axios from 'axios';
import Swal from 'sweetalert2';

export default {
  data() {
    return {
      username: '',
      password: ''
    };
  },
  methods: {
    loginUser() {
      const userData = {
        username: this.username,
        password: this.password
      };

      axios.post('http://localhost/ESTRUC/back/login.php', userData)
        .then(response => {
          console.log(response.data);

          if (response.data && response.data.authenticated) {
            Swal.fire('Inicio de sesión exitoso!', `¡Bienvenido, ${this.username}!`, 'success');
            this.$router.push('/bienvenida');
          } else {
            Swal.fire('Inicio de sesión fallido', 'Usuario o contraseña incorrectos', 'error');
          }
        })
        .catch(error => {
          console.error('Error al iniciar sesión:', error);
          Swal.fire('Error', 'Ha ocurrido un error al iniciar sesión. Por favor, inténtalo de nuevo.', 'error');
        });
    }
  }
};
</script>


<style scoped>
/* Estilos compartidos */
.login-form {
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



