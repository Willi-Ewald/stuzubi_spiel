<template>
  <div class="container mt-4">
    <div class="border rounded bg-light p-4 shadow position-relative">
      <!-- Willkommens-Text nur bei der ersten Frage anzeigen -->
      <h2 class="text-center" v-if="isFirstQuestion">
        Hallo {{ playerName }}, beantworte die folgenden Fragen:
      </h2>
      <!-- Alternative Überschrift für weitere Fragen -->
      <h2
          class="text-center"
          v-else-if="currentQuestionIndex < questions.length"
      >
        Frage {{ currentQuestionIndex + 1 }} von {{ totalQuestions }}
      </h2>

      <div v-if="currentQuestionIndex < questions.length" class="mt-4">
        <h3>{{ currentQuestion.question }}</h3>

        <!-- Dynamischer Hinweis -->
        <p v-if="hasMultipleCorrectAnswers" class="alert alert-info">
          Hinweis: Es gibt {{ currentQuestion.correct.length }} richtige Antworten für diese Frage.
        </p>

        <div class="row g-3">
          <div
              v-for="(answer, index) in currentQuestionAnswers.answers"
              :key="index"
              class="col-12 col-md-6"
          >
            <button
                class="btn w-100"
                :class="getButtonClass(index)"
                @click="selectAnswer(index)"
                :disabled="selectedAnswers.includes(index) || questionAnswered"
            >
              {{ answer }}
            </button>
          </div>
        </div>

        <!-- Tipp Button -->
        <button class="btn btn-secondary mt-3" @click="showHint">
          Tipp anzeigen
        </button>
        <p v-if="showingHint" class="mt-2 alert alert-warning">
          {{ currentQuestion.hint }}
        </p>

        <!-- Nächste Frage Button -->
        <div class="mt-3 d-flex justify-content-end">
          <button
              class="btn btn-primary"
              @click="goToNextQuestion"
              :disabled="!questionAnswered"
          >
            Nächste Frage
          </button>
        </div>
      </div>

      <!-- Leerer Div, kein Abschlussbildschirm -->
      <div v-else></div>
    </div>
  </div>
</template>

<script>
import {shuffleAnswers} from "@/util.js";
export default {
  props: ['questions', 'playerName'],
  data() {
    return {
      currentQuestionIndex: 0,
      showingHint:          false,
      selectedAnswers:      [],
      correctAnswers:       [],
      questionAnswered:     false,
      counter:              0,
    };
  },
  computed: {
    currentQuestion() {
      return this.questions[this.currentQuestionIndex];
    },
    currentQuestionAnswers() {
      return shuffleAnswers(this.currentQuestion.answers, this.currentQuestion.correct)
    },
    hasMultipleCorrectAnswers() {
      return this.currentQuestion.correct.length > 1;
    },
    isFirstQuestion() {
      return this.currentQuestionIndex === 0;
    },
    totalQuestions() {
      return this.questions.length;
    },
  },
  methods:  {
    selectAnswer(index) {
      if (this.currentQuestionAnswers.correct.includes(index)) {
        // Richtige Antwort
        this.correctAnswers.push(index);
      }
      else {
        this.counter++;
      }
      console.log(this.counter)
      this.selectedAnswers.push(index);

      // Überprüfen, ob alle korrekten Antworten gefunden wurden
      if (
          this.correctAnswers.length === this.currentQuestionAnswers.correct.length
      ) {
        this.questionAnswered = true;
      }
    },
    goToNextQuestion() {
      this.nextQuestion();
    },
    nextQuestion() {
      if (this.currentQuestionIndex + 1 < this.questions.length) {
        // Es gibt noch weitere Fragen
        this.currentQuestionIndex++;
        this.showingHint = false;
        this.selectedAnswers = [];
        this.correctAnswers = [];
        this.questionAnswered = false;
      }
      else {
        // Alle Fragen wurden beantwortet, Übergang zur nächsten Aufgabe
        this.finishQuiz();
      }
    },
    showHint() {
      this.hints++;
      this.showingHint = true;
    },
    getButtonClass(index) {
      if (this.correctAnswers.includes(index)) {
        return 'btn-success';
      }
      else if (this.selectedAnswers.includes(index)) {
        return 'btn-danger';
      }
      else {
        return 'btn-outline-primary';
      }
    },
    finishQuiz() {
      // Event auslösen und Daten an die Elternkomponente senden
      this.$emit('quizCompleted',
          this.counter,
      );
    },
  },
};
</script>

<style scoped>
.btn-success {
  background-color: #28a745 !important;
  border-color: #28a745 !important;
  color: white !important;
}

.btn-danger {
  background-color: #dc3545 !important;
  border-color: #dc3545 !important;
  color: white !important;
}

.alert-info {
  background-color: #d1ecf1;
  color: #0c5460;
}
</style>
