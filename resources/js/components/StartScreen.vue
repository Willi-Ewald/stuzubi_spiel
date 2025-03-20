<template>
    <div class="container mt-4">
        <div class="border rounded bg-light p-4 shadow">
            <h2 class="text-center">Willkommen zum Quiz-Spiel!</h2>
            <p class="mt-3">Bitte gib deinen Namen ein, um zu beginnen:</p>

            <input
                type="text"
                class="form-control"
                v-model="playerName"
                placeholder="Dein Name"
                @blur="checkUsername"
            />

            <!-- Ladeanzeige -->
            <p v-if="loading" class="text-info mt-2">🔄 Überprüfung läuft...</p>

            <!-- Fehlermeldung falls Name vergeben ist -->
            <p v-if="isTaken" class="text-danger mt-2">❌ Dieser Name ist bereits vergeben.</p>

            <!-- Erfolgsnachricht falls Name verfügbar ist -->
            <p v-if="!isTaken && playerName && !loading" class="text-success mt-2">
                ✅ Name ist verfügbar!
            </p>

            <button
                class="btn btn-primary mt-3"
                :disabled="!playerName || isTaken || loading"
            @click="startGame"
            >
            Starten
            </button>
        </div>

        <!-- Neuer Kasten für Anleitung -->
        <div class="border rounded bg-light p-4 shadow mt-4">
            <h3>Anleitung</h3>
            <p>
                Willkommen zu unserem interaktiven Quiz-Spiel! In diesem Spiel wirst du
                verschiedene Fragen beantworten und Aufgaben lösen. Folgendes erwartet dich:
            </p>
            <ul>
                <li>Beantworte die Quizfragen so schnell wie möglich.</li>
                <li>Ordne die Bausteine in die richtige Reihenfolge.</li>
                <li>Versuche, die beste Zeit zu erreichen und auf der Rangliste zu erscheinen!</li>
            </ul>
            <p>Viel Spaß und viel Erfolg!</p>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            playerName: '',
            isTaken: false,
            loading: false,
        };
    },
    methods: {
        async checkUsername() {
            if (!this.playerName) return;

            this.loading = true;

            try {
                const response = await fetch(`leaderboard?player_name=${this.playerName}`);
                if (!response.ok) {
                    throw new Error('Fehler bei der API-Anfrage');
                }

                const data = await response.json();


                this.isTaken = data.some((player) => player.player_name.toLowerCase() === this.playerName.toLowerCase());
            } catch (error) {
                console.error('Fehler bei der Benutzernamenprüfung:', error);
                this.isTaken = false; // Wenn ein Fehler auftritt, gehe davon aus, dass der Name verfügbar ist
            }

            this.loading = false;
        },
        startGame() {
            // Hier kannst du den Start des Spiels implementieren
            this.$emit('start', this.playerName);
        }

    }
};
</script>

<style scoped>
.text-danger {
    color: red;
}
.text-success {
    color: green;
}
.text-info {
    color: blue;
}
</style>
