<template>
  <div class="career-and-subjects-container">
    <h1 class="titulo">Bienvenido a nuestra plataforma de seguimiento académico</h1>
    <p>Aquí podrás ver tu progreso en la carrera y realizar otras acciones.</p>
    <button @click="redirectToSubjects">Seleccionar materias</button>
    <button @click="redirectToCitas">Agendar Cita</button>

    <!-- Sección de comentarios -->
    <div class="comentarios">
      <h2>Comentarios</h2>
      <ul v-if="!pilaComentarios.estaVacia()">
        <li v-for="(comentario, index) in pilaComentarios.items" :key="index">{{ comentario }}</li>
      </ul>
      <p v-else>No hay comentarios.</p>
      <label for="nuevoComentario">Agregar Comentario:</label>
      <input type="text" id="nuevoComentario" v-model="nuevoComentario">
      <button @click="agregarComentario">Agregar</button>
      <button @click="sacarComentario">Eliminar Último Comentario</button>
    </div>
  </div>
</template>

<script>
//import Swal from 'sweetalert2';

class Pila {
  constructor() {
    this.items = [];
  }

  agregarComentario(comentario) {
    this.items.push(comentario);
  }

  sacarComentario() {
    if (this.items.length === 0) {
      return null;
    }
    return this.items.pop();
  }

  estaVacia() {
    return this.items.length === 0;
  }
}

export default {
  data() {
    return {
      pilaComentarios: new Pila(),
      nuevoComentario: ''
    };
  },
  methods: {
    redirectToSubjects() {
      this.$router.push('/materias'); 
    },
    redirectToCitas() {
      this.$router.push('/citas'); 
    },
    agregarComentario() {
      if (this.nuevoComentario.trim() !== '') {
        this.pilaComentarios.agregarComentario(this.nuevoComentario);
        this.nuevoComentario = ''; 
      }
    },
    sacarComentario() {
      this.pilaComentarios.sacarComentario();
    }
  }
};
</script>

<style>
.career-and-subjects-container {
  max-width: 500px;
  margin: 0 auto;
  padding: 20px;
  text-align: center;
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
