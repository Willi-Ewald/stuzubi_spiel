<template>
    <div class="container mt-4">
        <div class="border rounded bg-light p-4 shadow position-relative">
            <h2 class="text-center">Ordne die Bausteine in die richtige Reihenfolge, um das abgebildete Bild nachzubilden.</h2>
            <div class="image-container">
                <img :src="task.referenceImage" alt="Referenzbild" class="img-fluid mb-4" />
            </div>

            <div class="d-flex justify-content-center">
                <!-- Verfügbare Bausteine -->
                <div class="list-container">
                    <h5 class="text-center">Verfügbare Bausteine</h5>
                    <draggable
                        v-model="availableBlocks"
                        :group="{ name: 'blocks', pull: true, put: false }"
                        item-key="id"
                        class="list-group"
                    >
                        <template #item="{ element }">
                            <div class="list-group-item">
                                {{ element.name }}
                            </div>
                        </template>
                    </draggable>
                </div>

                <!-- Zielbereich -->
                <div class="list-container">
                    <h5 class="text-center">Zielbereich</h5>
                    <draggable
                        v-model="userSequence"
                        :group="{ name: 'blocks', pull: false, put: true }"
                        item-key="id"
                        class="list-group"
                        @change="checkOrder"
                    >
                        <template #item="{ element }">
                            <div class="list-group-item">
                                {{ element.name }}
                            </div>
                        </template>
                    </draggable>
                </div>
            </div>

            <!-- Erfolgsmeldung -->
            <div v-if="isCorrectOrder" class="alert alert-success mt-3">
                Glückwunsch! Du hast die Bausteine in die richtige Reihenfolge gebracht.
            </div>

            <!-- Fehlermeldung -->
            <div v-if="showResetMessage" class="alert alert-warning mt-3">
                Die Reihenfolge ist nicht korrekt. Die Bausteine wurden zurückgesetzt. Versuche es erneut!
            </div>

            <!-- Weiter-Button -->
            <div v-if="isCorrectOrder" class="mt-3 d-flex justify-content-end">
                <button
                    class="btn btn-primary"
                    @click="$emit('taskCompleted')"
                >
                    Weiter
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import draggable from 'vuedraggable';

export default {
    components: {
        draggable,
    },
    props: {
        task: Object, // Erhält die aktuelle Aufgabe als Prop
    },
    data() {
        return {
            availableBlocks: [],
            userSequence: [],
            isCorrectOrder: false,
            showResetMessage: false,
        };
    },
    mounted() {
        // Setze die verfügbaren Bausteine basierend auf der Aufgabe
        this.resetBlocks();
    },
    methods: {
        shuffleArray(array) {
            for (let i = array.length - 1; i > 0; i--) {
                const j = Math.floor(Math.random() * (i + 1));
                [array[i], array[j]] = [array[j], array[i]];
            }
            return array;
        },
        checkOrder() {
            if (this.userSequence.length !== this.task.correctSequence.length) {
                // Noch nicht alle Bausteine platziert
                return;
            }
            const isCorrect = this.userSequence.every(
                (item, index) => item.id === this.task.correctSequence[index].id
            );
            if (isCorrect) {
                this.isCorrectOrder = true;
            } else {
                // Bausteine zurücksetzen und Spieler informieren
                this.resetBlocks();
                this.showResetMessage = true;
                // Benachrichtigung nach 3 Sekunden ausblenden
                setTimeout(() => {
                    this.showResetMessage = false;
                }, 3000);
            }
        },
        resetBlocks() {
            // Bausteine zurücksetzen
            this.availableBlocks = this.shuffleArray([...this.task.correctSequence]);
            this.userSequence = [];
            this.isCorrectOrder = false;
        },
    },
    watch: {
        // Beobachte Änderungen an der Aufgabe und setze die Bausteine zurück
        task(newTask, oldTask) {
            this.resetBlocks();
        },
    },
};
</script>

<style scoped>
.ordering-task {
    max-width: 800px;
    margin: 0 auto;
}

.image-container {
    border: 2px solid #000;
    padding: 5px;
    display: inline-block;
    margin-bottom: 20px;
}

.list-container {
    width: 45%;
    margin: 0 10px;
}

.list-group {
    min-height: 200px;
    border: 1px solid #dee2e6;
    background-color: #f8f9fa;
    padding: 10px;
}

.list-group-item {
    cursor: move;
    background-color: white;
    border: 1px solid #dee2e6;
    margin-bottom: 5px;
    padding: 10px;
    transition: background-color 0.3s ease, border-color 0.3s ease;
}

::v-deep .list-group-item:hover {
    background-color: #e2e6ea;
    border-color: #adb5bd;
}

.list-group-item:last-child {
    margin-bottom: 0;
}
</style>
