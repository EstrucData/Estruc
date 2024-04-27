<template>
  <div>
    <router-view></router-view>
    <div class="login-container">
      <div v-if="!loggedIn" class="login-form">
        <h1 class="titulo">Iniciar sesión</h1>
        <form @submit.prevent="login">
          <label for="username">Usuario:</label>
          <input type="text" id="username" v-model="username" required>
          <br>
          <label for="password">Contraseña:</label>
          <input type="password" id="password" v-model="password" required>
          <br>
          <button type="submit" @click="redirectToWelcome">Iniciar sesión</button>
        </form>
      </div>
      <div v-else class="welcome-message">
        ¡Bienvenido, {{ username }}!
      </div>
      <div class="register-form">
        <h1 class="titulo">Registrarse</h1>
        <form @submit.prevent="register">
          <label for="newUsername">Nuevo Usuario:</label>
          <input type="text" id="newUsername" v-model="newUsername" required>
          <br>
          <label for="newPassword">Nueva Contraseña:</label>
          <input type="password" id="newPassword" v-model="newPassword" required>
          <br>
          <button type="submit">Registrarse</button>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import Swal from 'sweetalert2';

export default {
  data() {
    return {
      username: '',
      password: '',
      newUsername: '',
      newPassword: '',
      loggedIn: false,
    };
  },
  methods: {
    login() {
      if (this.username === 'usuario' && this.password === 'contraseña') {
        this.loggedIn = true;
      } else {
        Swal.fire('Credenciales incorrectas. Inténtalo de nuevo.');
      }
    },
    register() {
      Swal.fire(`Usuario ${this.newUsername} registrado correctamente.`);
    },
    redirectToWelcome() {
      this.$router.push('/bienvenida'); 
    },
  },
};
</script>

<style>
.login-container {
  max-width: 400px;
  margin: 0 auto;
  padding: 20px;
  border: 1px solid #ccc;
  border-radius: 5px;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.login-form, .register-form {
  margin-bottom: 20px;
}

h1 {
  text-align: center;
  margin-bottom: 20px;
}

form {
  display: flex;
  flex-direction: column;
}

label {
  margin-bottom: 8px;
}

input[type="text"], input[type="password"] {
  padding: 8px;
  margin-bottom: 16px;
  border: 1px solid #ccc;
  border-radius: 4px;
}

button {
  padding: 10px;
  background-color: #ff5900;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

button:hover {
  background-color: #ff5900;
}

.welcome-message {
  text-align: center;
  font-size: 20px;
  font-weight: bold;
  padding: 20px;
  background-color: #f0f0f0;
  border: 1px solid #ccc;
  border-radius: 5px;
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

