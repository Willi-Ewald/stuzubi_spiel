<template>
    <div class="container mt-4">
        <div class="border rounded bg-light p-4 shadow position-relative">
            <h2 class="text-center">Ergebnis</h2>
            <p class="mt-3">Glückwunsch, {{ playerName }}!</p>
            <p>Du hast {{ timeTaken }} Sekunden gebraucht.</p>
            <p>Du hast {{ counter}} Fehler gemacht.</p>
            <button class="btn btn-primary mt-3" @click="$emit('restart')">Erneut spielen</button>

            <!-- Rangliste anzeigen -->
            <Leaderboard :leaderboard="leaderboardData" />
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import Leaderboard from './Leaderboard.vue';

export default {
    components: {
        Leaderboard,
    },
    props: {
        timeTaken: Number,
        playerName: String,
        counter: Number,
    },
    data() {
        return {
            leaderboardData: [], // Hier speichern wir die Ranglistendaten
        };
    },
    mounted() {
        // Daten an das Back-End senden
        axios.post('/leaderboard', {
            player_name: this.playerName,
            time_taken: this.timeTaken,
            counter: this.counter,  // Fehler werden als counter hier gesendet

        })

            .then(response => {
                console.log('Daten gespeichert:', response.data);
                // Nach erfolgreichem Speichern die Rangliste abrufen
                this.fetchLeaderboard();
            })
            .catch(error => {
                console.error('Fehler beim Speichern der Daten:', error);
            });
    },
    methods: {
        fetchLeaderboard() {

            console.log(this.counter)

            axios.get('/leaderboard')
                .then(response => {
                    this.leaderboardData = response.data;
                })
                .catch(error => {
                    console.error('Fehler beim Abrufen der Rangliste:', error);
                });
        },
    },
};
</script>

<style scoped>
/* Deine Styles */
</style>
