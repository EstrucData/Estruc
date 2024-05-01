<template>
  <div class="flex">
    <!-- Contenedor para las fichas arrastradas -->
    <div class="materia" @dragover.prevent @drop="dropToMateria">
      <h2 class="titulo">Materias</h2>
      <div class="card" v-for="(card, index) in droppedCards" :key="index"
           :class="card.type"
           draggable="true"
           @dragstart="dragStartGeneral(index)"
           @dragend="dragEnd"
           v-bind:title="'Créditos: ' + card.credits"> 
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
           @dragend="dragEnd"
           v-bind:title="'Créditos: ' + card.credits">
        {{ card.name }}
      </div>
    </div>
  </div>
  <div>
    <button @click="addSemester" class="boton">Agregar Semestre</button>
    <button @click="removeSemester" class="boton">Eliminar Semestre</button>
  </div>
</template>

<script>
import { ref } from 'vue';

export default {
  setup() {
    const initialCardsAnahuac = [
      { name: 'Ficha 1', type: 'bloque-anahuac', credits: 3 },
      { name: 'Ficha 4', type: 'bloque-anahuac', credits: 3 },
      { name: 'Ficha 7', type: 'bloque-anahuac', credits: 3 },
      { name: 'Ficha 10', type: 'bloque-anahuac', credits: 3 },
      { name: 'Ficha 13', type: 'bloque-anahuac', credits: 3 },
    ];

    const initialCardsProfesional = [
      { name: 'Ficha 2', type: 'bloque-profesional', credits: 4.5 },
      { name: 'Ficha 5', type: 'bloque-profesional', credits: 4.5 },
      { name: 'Ficha 8', type: 'bloque-profesional', credits: 4.5 },
      { name: 'Ficha 11', type: 'bloque-profesional', credits: 4.5 },
      { name: 'Ficha 14', type: 'bloque-profesional', credits: 4.5 },
    ];

    const initialCardsInterdisciplinario = [
      { name: 'Ficha 3', type: 'bloque-interdisciplinario', credits: 6 },
      { name: 'Ficha 6', type: 'bloque-interdisciplinario', credits: 6 },
      { name: 'Ficha 9', type: 'bloque-interdisciplinario', credits: 6 },
      { name: 'Ficha 12', type: 'bloque-interdisciplinario', credits: 6 },
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

    return { columns, droppedCards, dragStart, dragStartGeneral, dragEnd, dropToColumn, dropToMateria, addSemester, removeSemester };
  },
};
</script>


<style>
.flex {
  display: flex;
}

.drop-container {
  flex: 1;
  padding: 20px;
  background-color: #f0f0f0;
  border: 1px solid #ccc;
  margin-right: 20px;
}

.column-container {
  display: flex;
  flex-wrap: wrap;
  flex: 2;
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
  background-color: #FF5733; 
}

.bloque-profesional {
  background-color: #3498DB;
}

.bloque-interdisciplinario {
  background-color: #58D68D; 
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

.container {
  display: flex;
  flex-direction: column;
  min-height: 100vh; 
}

.bottom-button {
  margin-top: auto;
  text-align: center; 
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





