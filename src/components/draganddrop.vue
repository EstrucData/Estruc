<template>
  <div class="flex">
    <!-- Contenedor para las fichas arrastradas -->
    <div class="materia" @dragover.prevent @drop="dropToMateria">
      <h2 class="titulo">Materias</h2>
      <div class="card" v-for="(card, index) in droppedCards" :key="index"
           :class="card.type"
           draggable="true"
           @dragstart="dragStartGeneral(index)"
           @dragend="dragEnd">
        {{ card.name }}
      </div>
    </div>

    <div class="column" v-for="(column, columnIndex) in columns" :key="columnIndex"
         @dragover.prevent
         @drop="dropToColumn($event, columnIndex)">
      <h2 class="titulo">{{ column.name }}</h2>
      <div class="card" v-for="(card, cardIndex) in column.cards" :key="cardIndex"
           :class="card.type"
           draggable="true"
           @dragstart="dragStart(columnIndex, cardIndex)"
           @dragend="dragEnd">
        {{ card.name }}
      </div>
    </div>
  </div>
  <div>
    <button @click="addSemester" class="boton">Agregar Semestre</button>
    <button @click="removeSemester" class="boton">Eliminar Semestre</button>
    <button @click="calculatePlan" class="boton">Calcular Plan</button>
    <p v-if="planStatus !== null">{{ planStatus }}</p>
  </div>
</template>

<script>
import { ref } from 'vue';

export default {
  setup() {
    const initialCardsAnahuac = [
      { name: 'Liderazgo y Desarrollo Personal', type: 'bloque-anahuac', credits: 3, prerequisites: [] },
      { name: 'Antropología Fundamental', type: 'bloque-anahuac', credits: 3, prerequisites: ['Liderazgo y Desarrollo Personal'] },
      { name: 'Persona y Trascendencia', type: 'bloque-anahuac', credits: 3, prerequisites: ['Antropología Fundamental'] },
    ];

    const initialCardsProfesional = [
      { name: 'Algoritmos y Programación', type: 'bloque-profesional', credits: 4.5, prerequisites: [] },
      { name: 'Programación Orientada a Objetos', type: 'bloque-profesional', credits: 4.5, prerequisites: ['Algoritmos y Programación'] },
      { name: 'Estructura de Datos', type: 'bloque-profesional', credits: 4.5, prerequisites: ['Programación Orientada a Objetos'] },
    ];

    const initialCardsInterdisciplinario = [
      { name: 'Habilidades de Emprendimiento', type: 'bloque-interdisciplinario', credits: 6, prerequisites: [] },
      { name: 'Emprendimiento e Innovación', type: 'bloque-interdisciplinario', credits: 6, prerequisites: ['Habilidades de Emprendimiento'] },
      { name: 'Responsabilidad Social', type: 'bloque-interdisciplinario', credits: 6, prerequisites: ['Emprendimiento e Innovación'] },
    ];

    const droppedCards = ref([...initialCardsAnahuac, ...initialCardsProfesional, ...initialCardsInterdisciplinario]);

    const columns = ref([
      { name: 'Semestre 1', cards: [] },
      { name: 'Semestre 2', cards: [] },
      { name: 'Semestre 3', cards: [] },
      { name: 'Semestre 4', cards: [] },
      { name: 'Semestre 5', cards: [] },
      { name: 'Semestre 6', cards: [] },
      { name: 'Semestre 7', cards: [] },
      { name: 'Semestre 8', cards: [] },
      { name: 'Semestre 9', cards: [] },
    ]);

    let draggedCard = null;

    const subjects = {
      ...initialCardsAnahuac.reduce((acc, card) => {
        acc[card.name] = card.prerequisites;
        return acc;
      }, {}),
      ...initialCardsProfesional.reduce((acc, card) => {
        acc[card.name] = card.prerequisites;
        return acc;
      }, {}),
      ...initialCardsInterdisciplinario.reduce((acc, card) => {
        acc[card.name] = card.prerequisites;
        return acc;
      }, {})
    };

    const availableSubjects = ref([]);
    const planStatus = ref(null);

    function dragStart(columnIndex, cardIndex) {
      draggedCard = JSON.parse(JSON.stringify(columns.value[columnIndex].cards[cardIndex]));
    }

    function dragStartGeneral(index) {
      draggedCard = JSON.parse(JSON.stringify(droppedCards.value[index]));
    }

    function dragEnd() {
      draggedCard = null;
    }

    function dropToColumn(event, columnIndex) {
      if (draggedCard !== null) {
        const existingColumnIndex = columns.value.findIndex(column => isCardInColumn(column, draggedCard));
        if (existingColumnIndex === -1) {
          columns.value[columnIndex].cards.push(draggedCard);
        } else if (existingColumnIndex !== columnIndex) {
          columns.value[existingColumnIndex].cards = columns.value[existingColumnIndex].cards.filter(card => card.name !== draggedCard.name);
          columns.value[columnIndex].cards.push(draggedCard);
        }
        draggedCard = null;
      }
    }

    function isCardInColumn(column, card) {
      return column.cards.some(c => c.name === card.name);
    }

    function dropToMateria() {
      if (draggedCard !== null) {
        const existingIndex = droppedCards.value.findIndex(card => card.name === draggedCard.name);
        if (existingIndex !== -1) {
          droppedCards.value.splice(existingIndex, 1);
        }
        droppedCards.value.push(draggedCard);
        columns.value.forEach(column => {
          column.cards = column.cards.filter(card => card.name !== draggedCard.name);
        });
        draggedCard = null;
      }
    }

    function addSemester() {
      const newSemesterName = `Semestre ${columns.value.length + 1}`;
      columns.value.push({ name: newSemesterName, cards: [] });
    }

    function removeSemester() {
      if (columns.value.length > 1) {
        columns.value.splice(columns.value.length - 1, 1);
      } else {
        console.log("No se pueden eliminar más semestres.");
      }
    }

    function calculatePlan() {
      availableSubjects.value = [];
      planStatus.value = null;

      for (let i = 0; i < columns.value.length; i++) {
        const column = columns.value[i];
        if (column.cards.length > 0) {
          const columnSubjects = column.cards.map(card => card.name);
          let isValid = true;

          // Verificar si cada materia tiene sus prerequisitos en la columna
          for (let j = 0; j < columnSubjects.length; j++) {
            const subject = columnSubjects[j];
            const prerequisites = subjects[subject];
            if (prerequisites) {
              for (let k = 0; k < prerequisites.length; k++) {
                const prerequisite = prerequisites[k];
                if (!columnSubjects.includes(prerequisite)) {
                  isValid = false;
                  planStatus.value = `Plan Erróneo: No puedes cursar ${subject} sin haber tomado ${prerequisite}`;
                  break;
                }
              }
              if (!isValid) break;
            }
          }

          if (!isValid) {
            break;
          }
        }
      }

      if (planStatus.value === null) {
        planStatus.value = "Plan Correcto: Puedes cursar todas las materias en el orden adecuado.";
      }
    }

    return { columns, droppedCards, dragStart, dragStartGeneral, dragEnd, dropToColumn, dropToMateria, addSemester, removeSemester, calculatePlan, availableSubjects, planStatus };
  },
};
</script>

<style scoped>
.flex {
  display: flex;
}

.column {
  flex-basis: calc(33.33% - 20px);
  margin-bottom: 20px;
  padding: 20px;
  background-color: #f9f9f9;
  border: 1px solid #ccc;
  margin-right: 20px;
  margin-top: 10px;
  border-radius: 10px;
}

.card {
  width: 180px;
  height: 50px;
  margin-bottom: 10px;
  cursor: pointer;
  display: flex;
  justify-content: center;
  align-items: center;
  border-radius: 10px;
}

.bloque-anahuac {
  background-color: #FF5733; /* Naranja */
  color: white;
}

.bloque-profesional {
  background-color: #3498DB; /* Azul */
  color: white;
}

.bloque-interdisciplinario {
  background-color: #58D68D; /* Verde */
  color: white;
}

.materia {
  width: 200px;
  border: 1px solid rgb(179, 179, 179);
  padding: 10px;
  margin-right: 10px;
  margin-left: 10px;
  margin-top: 10px;
  margin-bottom: 10px;
  border-radius: 10px;
}

.boton {
  padding: 10px 20px;
  font-size: 16px;
  background-color: #ff5900;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  margin-bottom: 20px;
}

.boton:hover {
  background-color: #ff8d50;
}

@media (max-width: 768px) {
  .bottom-button {
    position: fixed;
    bottom: 20px;
    left: 50%;
    transform: translateX(-50%);
    width: 90%;
  }
}
</style>
