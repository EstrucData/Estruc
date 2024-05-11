<template>
    <div class="citas-container">
      <div class="formulario">
        <h2>Completa el cuestionario</h2>
        <label for="proposito">Propósito:</label>
        <input type="text" v-model="proposito" id="proposito">
        <label for="semestre">Semestre:</label>
        <input type="number" v-model="semestre" id="semestre">
        <label for="nombre">Nombre:</label>
        <input type="text" v-model="nombre" id="nombre">
        <label for="apellido">Apellido:</label>
        <input type="text" v-model="apellido" id="apellido">
        <label for="director">Director de Carrera:</label>
        <input type="text" v-model="director" id="director">
        <button @click="enviarQuizz">Enviar</button>
      </div>
  
      <div class="citas-info">
        <div class="turno-actual">
          <h2>Turno Actual</h2>
          <div v-if="colaCitas.obtenerTamaño() > 0">
            <p>{{ colaCitas.obtenerPrimeraCita().nombre }}</p>
            <button @click="atenderCita">Atender Cita</button>
          </div>
          <div v-else>
            <p>No hay citas agendadas.</p>
          </div>
        </div>
  
        <div class="citas-espera">
          <h2>Citas en Espera</h2>
          <ul v-if="colaCitas.obtenerTamaño() > 1">
            <li v-for="(cita, index) in colaCitas.obtenerTodasLasCitas().slice(1)" :key="index">{{ cita.nombre }}</li>
          </ul>
          <p v-else>No hay citas en espera.</p>
        </div>
      </div>
    </div>
  </template>
  
  
  <script>
  class Nodo {
    constructor(cita) {
      this.cita = cita;
      this.siguiente = null;
    }
  }
  
  class ListaEnlazada {
    constructor() {
      this.primerNodo = null;
      this.ultimoNodo = null;
    }
  
    agregarCita(cita) {
      const nuevoNodo = new Nodo(cita);
      if (!this.primerNodo) {
        this.primerNodo = nuevoNodo;
        this.ultimoNodo = nuevoNodo;
      } else {
        this.ultimoNodo.siguiente = nuevoNodo;
        this.ultimoNodo = nuevoNodo;
      }
    }
  
    atenderCita() {
      if (!this.primerNodo) {
        return null;
      }
      const citaAtendida = this.primerNodo.cita;
      this.primerNodo = this.primerNodo.siguiente;
      return citaAtendida;
    }
  
    obtenerPrimeraCita() {
      return this.primerNodo ? this.primerNodo.cita : null;
    }
  
    obtenerTodasLasCitas() {
      const citas = [];
      let actual = this.primerNodo;
      while (actual) {
        citas.push(actual.cita);
        actual = actual.siguiente;
      }
      return citas;
    }
  
    obtenerTamaño() {
      let tamaño = 0;
      let actual = this.primerNodo;
      while (actual) {
        tamaño++;
        actual = actual.siguiente;
      }
      return tamaño;
    }
  }
  
  export default {
    data() {
      return {
        colaCitas: new ListaEnlazada(),
        proposito: '',
        semestre: null,
        nombre: '',
        apellido: '',
        director: ''
      };
    },
    methods: {
      enviarQuizz() {
        const cita = {
          nombre: this.nombre,
          proposito: this.proposito,
          semestre: this.semestre,
          apellido: this.apellido,
          director: this.director
        };
        this.colaCitas.agregarCita(cita);
        // Restaurar valores del quizz
        this.proposito = '';
        this.semestre = null;
        this.nombre = '';
        this.apellido = '';
        this.director = '';
      },
      atenderCita() {
        this.colaCitas.atenderCita();
      }
    }
  };
  </script>
  
  <style scoped>
  
  
  .citas-container {
    max-width: 100%;
    margin: 0 auto;
    display: flex;
    justify-content: space-between;
  
  }
  
  .formulario {
    width: 30%;
    padding: 15px;
    background-color: #fff; /* Fondo blanco */
    border-radius: 10px;
  }
  
  .citas-info {
    width: 65%; /* Ocupa el espacio restante */
    display: flex;
  }
  
  .turno-actual,
  .citas-espera {
    flex: 100; /* Ocupa todo el espacio disponible */
    padding: 15px;
    background-color: rgba(255, 204, 128, 0.7); /* Naranja claro con transparencia */
    border-radius: 10px;
    transition: background-color 0.3s ease; /* Transición suave del color de fondo */
  }
  
  .turno-actual:hover,
  .citas-espera:hover {
    background-color: rgba(255, 139, 37, 0.9); /* Naranja oscuro con transparencia al pasar el ratón */
  }
  
  .citas-espera {
    margin-left: 20px; /* Espacio entre citas-espera y turno-actual */
  }
  
  button {
    padding: 10px 20px;
    background-color: #f25907; /* Naranja oscuro */
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    margin-top: 10px;
  }
  
  button:hover {
    background-color: #ff6d40; /* Naranja más oscuro al pasar el ratón */
  }
  </style>