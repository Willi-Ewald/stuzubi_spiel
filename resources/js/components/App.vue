<template>
  <div class="app-background">
    <div id="app" class="container text-center mt-5">
      <!-- Logo und Titel -->
      <h1 class="mb-4">Quiz-Spiel</h1>
      <StartScreen
          v-if="currentScreen === 'start'"
          @start="startQuiz"
      />
      <QuizScreen
          v-else-if="currentScreen === 'quiz'"
          :questions="randomizeQuestions"
          :playerName="playerName"
          :counter="counter"
          @quizCompleted="startOrderingTask"
      />
      <OrderingTask
          v-else-if="currentScreen === 'orderingTask'"
          :task="currentOrderingTask"
          @taskCompleted="showNextOrderingTask"
      />
      <ResultScreen
          v-else-if="currentScreen === 'results'"
          :timeTaken="timeTaken"
          :playerName="playerName"
          :counter="counter"
          @restart="restartGame"

      />
    </div>
  </div>
</template>

<script>
import StartScreen from "@/components/StartScreen.vue";
import QuizScreen from "@/components/QuizScreen.vue";
import OrderingTask from "@/components/OrderingTask.vue";
import ResultScreen from "@/components/ResultScreen.vue";
import Questions from "@/components/assets/questions.json";

// Importiere die Referenzbilder
import referenceImage1 from '@/components/assets/julian1.png';
import {shuffleArray} from "@/util.js";

export default {
  components: {
    StartScreen,
    QuizScreen,
    OrderingTask,
    ResultScreen,
  },
  data() {
    return {
      currentScreen: 'start',
      playerName:    '',

      questions:        Questions,
      orderingTasks:    [
        {
          correctSequence: [
            {
              id:   1,
              name: '<div style="color: firebrick; font-weight: bold">'
            },
            {
              id:   2,
              name: '<h1>Important Information</h1>'
            },
            {
              id:   3,
              name: ' <p>This is a very important information, you must not forget!</p>'
            },
            {
              id:   4,
              name: '</div>'
            },
          ],
          referenceImage:  referenceImage1,
        },
      ],
      currentTaskIndex: 0,
      startTime:        0,
      endTime:          0,
      timeTaken:        0,
      counter:          0,
    };
  },
  computed: {
    randomizeQuestions() {
      return shuffleArray(this.questions);
    },
    currentOrderingTask() {
      return this.orderingTasks[this.currentTaskIndex];
    },
  },
  methods:  {
    startQuiz(playerName) {
        this.randomizeQuestions()
      this.playerName = playerName;
      this.currentScreen = 'quiz';
      this.startTime = Date.now();
    },
    startOrderingTask(counter) {
      this.counter = counter
      this.currentScreen = 'orderingTask';
    },
    showNextOrderingTask() {
      if (this.currentTaskIndex < this.orderingTasks.length - 1) {
        this.currentTaskIndex++;
        this.currentScreen = 'orderingTask';
      }
      else {
        this.showResults();
      }
    },
    showResults() {
      this.endTime = Date.now();
      this.timeTaken = (this.endTime - this.startTime) / 1000;
      this.currentScreen = 'results';
    },
    restartGame() {
      this.currentScreen = 'start';
      this.playerName = '';
      this.timeTaken = 0;
      this.startTime = 0;
      this.endTime = 0;
      this.currentTaskIndex = 0;
      this.counter = 0;
    },
  },
};
</script>

<style>
/* Deine bestehenden Styles */
</style>
