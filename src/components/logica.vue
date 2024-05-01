<template>
    <div class="hello">
      <h1>{{ msg }}</h1>
      <form @submit.prevent="submitForm">
        <h3>Selecciona las materias que has aprobado:</h3>
        <div v-for="(value, subject) in subjects" :key="subject">
          <input type="checkbox" :value="subject" v-model="selectedSubjects">
          <label>{{ subject }}</label>
        </div>
        <button type="submit">Enviar</button>
      </form>
      <h3>Materias disponibles para llevar:</h3>
      <ul>
        <li v-for="subject in availableSubjects" :key="subject">{{ subject }}</li>
      </ul>
    </div>
  </template>
  
  <script>
  export default {
    name: 'HelloWorld',
    props: {
      msg: String
    },
    data() {
      return {
        subjects: {
          'PIMAT': ['Fundamentos'],
          'Fundamentos': ['Calculo diferencial'],
          'Calculo diferencial':['Calculo vectorial'],
          'Calculo vectorial':['Calculo multivariado'],
          'Calculo multivariado':['Ecuaciones'],
          'Ecuaciones':[]
        },
        selectedSubjects: [],
        availableSubjects: []
      };
    },
    computed: {
      orderedSubjects() {
        return this.topologicalSort(this.subjects);
      }
    },
    methods: {
      topologicalSort(graph) {
        const visited = new Set();
        const stack = [];
  
        function dfs(node) {
          visited.add(node);
          for (const neighbor of graph[node]) {
            if (!visited.has(neighbor)) {
              dfs(neighbor);
            }
          }
          stack.push(node);
        }
  
        for (const node in graph) {
          if (!visited.has(node)) {
            dfs(node);
          }
        }
  
        return stack.reverse();
      },
      submitForm() {
        const selectedSet = new Set(this.selectedSubjects);
        const prerequisitesSet = new Set();
  
        // Iterar sobre las materias seleccionadas para encontrar sus prerequisitos
        for (const subject of selectedSet) {
          if (this.subjects[subject]) {
            for (const prerequisite of this.subjects[subject]) {
              prerequisitesSet.add(prerequisite);
            }
          }
        }
  
        // Filtrar las materias disponibles basadas en los prerequisitos encontrados
        this.availableSubjects = Object.keys(this.subjects).filter(subject => {
          return prerequisitesSet.has(subject) && !selectedSet.has(subject);
        });
      }
    }
  }
  </script>
  
  
  <style scoped>
  h3 {
    margin: 20px 0;
  }
  ul {
    list-style-type: none;
    padding: 0;
  }
  li {
    margin-bottom: 10px;
  }
  </style>