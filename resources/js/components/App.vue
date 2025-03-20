<template>
    <div class="app-background">
        <div id="app" class="container text-center mt-5">
            <!-- Logo und Titel -->
            <h1 class="mb-4">Quiz-Spiel</h1>
            <StartScreen v-if="currentScreen === 'start'" @start="startQuiz" />
            <QuizScreen
                v-else-if="currentScreen === 'quiz'"
                :questions="questions"
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

// Importiere die Referenzbilder
import referenceImage1 from '@/components/assets/julian1.png'; // Stelle sicher, dass dieser Pfad korrekt ist
import referenceImage2 from '@/components/assets/julian1.png'; // Füge weitere Bilder hinzu, falls nötig

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
            playerName: '',

            questions: [
                {
                    question: "Welche der folgenden HTML-Tags wird verwendet, um einen Absatz zu erstellen?",
                    answers: ["<section>", "<p>", "<div>", "<absatz>"],
                    correct: [1],
                    hint: 'Dieser Tag steht für das englische Wort "paragraph".'
                },
                {
                    question: "Welcher HTML-Tag definiert die größte Überschrift auf einer Webseite?",
                    answers: ["<h1>", "<h6>", "<header>", "hMax"],
                    correct: [0],
                    hint: "Überschriften in HTML sind nummeriert."
                },
                {
                    question: 'Wofür steht die Abkürzung "HTML"?',
                    answers: ["Hypertext Markup Language", "Hyperlinks and Text Modeling Language", "Home Tool Markup Language", "Home Text Markup Language"],
                    correct: [0],
                    hint: "Standardsprache zur Strukturierung von Webinhalten."
                },
                {
                    question: 'Was ist eine Variable in der Programmierung?',
                    answers: ["Ein fester Wert", "Ein Operator zur Verknüpfung von Daten", "Eine Funktion zur Ausgabe von Text", "Ein Platzhalter für Werte, die sich ändern können"],
                    correct: [3],
                    hint: "Sie speichert Daten und kann sich im Programmverlauf ändern."
                },
                {
                    question: 'Was ist der Zweck von Schleifen in der Programmierung?',
                    answers: ["Um einen Block von Code mehrfach auszuführen", "Um Entscheidungen im Code zu treffen", "Um einen Block von Code nur einmal auszuführen", "Um den Programmcode zu löschen"],
                    correct: [0],
                    hint: "Es spart Zeit, wenn du wiederholt dieselben Anweisungen ausführen musst."
                },
                {
                    question: 'Was macht die Funktion `print()` in vielen Programmiersprachen?',
                    answers: ["Speichert Daten in einer Datei", "Löscht eine Datei", "Gibt Text oder Daten auf der Konsole aus", "Druckt einen Text auf Papier"],
                    correct: [2],
                    hint: "Sie zeigt Informationen zur Überprüfung des Programms an."
                },
                {
                    question: "Was ist der höchste Wert, den ein Integer haben kann?",
                    answers: ["2147483647", "2999999999", "255", "4294967295"],
                    correct: [0],
                    hint: "Der höchste Integer-Wert hängt von der maximalen Größe ab, die ein 32-Bit-System speichern kann. Überlege, wie viele Bits für die Darstellung eines Integers verwendet werden."
                },
                {
                    question: "Wie ändert man die Hintergrundfarbe zu Grün mit CSS?",
                    answers: ["Background: grün", "Color: grün", "Background-color: grün", "font-color: grün"],
                    correct: [2],
                    hint: "Achte darauf, dass es in CSS einen speziellen Begriff für die Hintergrundfarbe gibt. Es ist nicht dasselbe wie die Farbe."
                },
                {
                    question: "Wofür steht Responsive Webdesign?",
                    answers: [
                        "Responsive Webdesign bedeutet, dass die Seite auf die Eingaben reagiert, die ich mache.",
                        "Responsive Webdesign bedeutet, dass die Website sich auf verschiedenen Geräten gut anpasst.",
                        "Responsive Webdesign bedeutet, dass die Website immer gleich aussieht, unabhängig von der Bildschirmgröße.",
                        "Responsive Webdesign bedeutet, dass die Website in verschiedenen Sprachen verfügbar ist."
                    ],
                    correct: [1],
                    hint: "Überlege, was das Wort \"responsive\" bedeutet. Es geht darum, dass sich die Website flexibel an verschiedene Umgebungen anpasst, statt immer gleich auszusehen."
                },
                {
                    question: "Welchen Selektor verwendet man in CSS um ein Element mit der ID 'Header' zu bearbeiten?",
                    answers: ["headerID", "header", ".header", "#header"],
                    correct: [3],
                    hint: "IDs sind eindeutig und benötigen einen speziellen Charakter vor ihrem Namen um sie anzusprechen"
                },
                {
                    question: "Welches Symbol wird in PHP verwendet, um zu zeigen, dass etwas eine Variable ist?",
                    answers: ["$", "@", "#", "!"],
                    correct: [0],
                    hint: "Dieses Symbol wird auch in anderen Sprachen, wie zum Beispiel python verwendet um Variablen zu kennzeichnen."
                },
                {
                    question: "Wie erstellt mann einen Link in HTML?",
                    answers: ['<link href="//online-ganztagsschule.de">GTS</a>', '<a href="//online-ganztagsschule.de">GTS</a>', '<url href="online-ganztagsschule.de">GTS</url>', '<HTML link="online-ganztagsschule.de">GTS</HTML>'],
                    correct: [1],
                    hint: 'Der Link wird durch einen "anchor" (=Anker) kreiert. Er "ankert" den Nutzer zu einem anderen Punkt auf der Seite oder im Netz.'
                },
            ],
            orderingTasks: [
                {
                    correctSequence: [
                        {id: 1, name: '<div style="color: firebrick; font-weight: bold">'},
                        {id: 2, name: '<h1>Important Information</h1>'},
                        {id: 3, name: ' <p>This is a very important information, you must not forget!</p>'},
                        {id: 4, name: '</div>'},
                    ],
                    referenceImage: referenceImage1,
                },
            ],
            currentTaskIndex: 0,
            startTime: 0,
            endTime: 0,
            timeTaken: 0,
            counter: 0,
        };
    },
    computed: {
        currentOrderingTask() {
            return this.orderingTasks[this.currentTaskIndex];
        },
    },
    methods: {
        startQuiz(playerName) {
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
            } else {
                this.showResults();
            }
        },
        showResults() {
            this.counter = this.counter;
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
            this.counter= 0;
        },
    },
};
</script>

<style>
/* Deine bestehenden Styles */
</style>
