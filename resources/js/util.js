export function shuffleArray(arr) {
    let newArr = [...arr]; // Create a copy of the original array
    for (let i = newArr.length - 1; i > 0; i--) {
        let j = Math.floor(Math.random() * (i + 1)); // Generate random index
        [newArr[i], newArr[j]] = [newArr[j], newArr[i]]; // Swap elements
    }
    return newArr;
}

export function shuffleAnswers(answers, correctIndices) {
	const correctAnswerIndices = [];

	const shuffledAnswers = [...answers];
	shuffleArray(shuffledAnswers);

	for (const i of correctIndices) {
		correctAnswerIndices.push(shuffledAnswers.indexOf(answers[i]));
	}

	return {
		answers: shuffledAnswers,
		correct: correctAnswerIndices,
	};
}
