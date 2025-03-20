<template>
    <div class="leaderboard mt-4">
        <h3>Rangliste</h3>
        <table class="table">
            <thead>
            <tr>
                <th>Platz</th>
                <th>Name</th>
                <th>Zeit (Sekunden)</th>
                <th>Fehler</th>
            </tr>
            </thead>
            <tbody>
            <tr
                v-for="(entry, index) in leaderboard"
                :key="entry.id"
                :class="getRowClass(index)"
            >
                <td>{{ index + 1 }}</td>
                <td>{{ entry.player_name }}</td>
                <td>{{ entry.time_taken }}</td>
                <td>{{ entry.counter }}</td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    props: {
        leaderboard: Array,
    },
    methods: {
        getRowClass(index) {
            if (index === 0) {
                return 'first-place';
            } else if (index === 1) {
                return 'second-place';
            } else if (index === 2) {
                return 'third-place';
            } else {
                return '';
            }
        },
    },
};
</script>

<style scoped>
/* Styles für die Rangliste */
.first-place {
    background-color: gold;
}

.second-place {
    background-color: silver;
}

.third-place {
    background-color: #cd7f32; /* Bronze Farbe */
}

/* Optional: Textfarbe anpassen, falls nötig */
.first-place td,
.second-place td,
.third-place td {
    color: black;
}

/* Optional: Schrift fett darstellen */
.first-place td,
.second-place td,
.third-place td {
    font-weight: bold;
}
</style>
