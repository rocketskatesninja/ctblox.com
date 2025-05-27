/**
 * CTBlox Quiz System
 * A standardized quiz initialization and handling system for all lessons
 */

/**
 * Initialize a quiz with the given ID and answers
 * 
 * @param {string} quizId - The ID of the quiz to initialize
 * @param {Object} answers - An object mapping question IDs to correct answer values
 */
function initQuiz(quizId, answers) {
    const quizContainer = document.querySelector(`.quiz-container[data-quiz-id="${quizId}"]`);
    
    if (!quizContainer) {
        console.error(`Quiz container with ID ${quizId} not found`);
        return;
    }
    
    const form = quizContainer.querySelector('.quiz-form');
    const questions = quizContainer.querySelectorAll('.quiz-question');
    const resultsContainer = quizContainer.querySelector('.quiz-results');
    const resultsMessage = quizContainer.querySelector('.results-message');
    const retakeButton = quizContainer.querySelector('.retake-quiz');
    
    if (!form || !questions.length || !resultsContainer || !resultsMessage) {
        console.error(`Quiz ${quizId} is missing required elements`);
        return;
    }
    
    // Handle form submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        let score = 0;
        let totalQuestions = questions.length;
        
        // Process each question
        questions.forEach(question => {
            const questionId = question.dataset.questionId;
            const selectedInput = question.querySelector(`input[name="question${questionId}"]:checked`);
            const feedbackElement = question.querySelector('.answer-feedback');
            
            if (!feedbackElement) {
                console.error(`Feedback element not found for question ${questionId}`);
                return;
            }
            
            // Clear previous feedback
            feedbackElement.innerHTML = '';
            feedbackElement.classList.remove('text-green-600', 'text-red-600', 'hidden');
            
            if (!selectedInput) {
                // No answer selected
                feedbackElement.classList.add('text-red-600');
                feedbackElement.innerHTML = 'Please select an answer.';
                return;
            }
            
            const userAnswer = selectedInput.value;
            const correctAnswer = answers[questionId];
            
            if (userAnswer === correctAnswer) {
                // Correct answer
                score++;
                feedbackElement.classList.add('text-green-600');
                feedbackElement.innerHTML = 'Correct!';
            } else {
                // Incorrect answer
                feedbackElement.classList.add('text-red-600');
                feedbackElement.innerHTML = 'Incorrect. Please try again.';
            }
            
            feedbackElement.classList.remove('hidden');
        });
        
        // Calculate percentage score
        const percentage = Math.round((score / totalQuestions) * 100);
        
        // Display results
        let resultText = `You scored ${score} out of ${totalQuestions} (${percentage}%).`;
        
        if (percentage >= 80) {
            resultText += ' Great job! You have a good understanding of this topic.';
        } else if (percentage >= 60) {
            resultText += ' Good effort! Review the material and try again to improve your score.';
        } else {
            resultText += ' You might want to review the chapter material before trying again.';
        }
        
        // Update quiz state in database
        updateQuizProgress(quizId, score, totalQuestions);
        
        // Show results
        resultsMessage.textContent = resultText;
        form.classList.add('hidden');
        resultsContainer.classList.remove('hidden');
        
        // Log completion to console for debugging
        console.log(`Quiz ${quizId} completed with score ${score}/${totalQuestions} (${percentage}%)`);
    });
    
    // Handle retake button
    if (retakeButton) {
        retakeButton.addEventListener('click', function() {
            // Reset all selections
            const allInputs = form.querySelectorAll('input[type="radio"]');
            allInputs.forEach(input => {
                input.checked = false;
            });
            
            // Hide all feedback
            const allFeedback = form.querySelectorAll('.answer-feedback');
            allFeedback.forEach(feedback => {
                feedback.classList.add('hidden');
                feedback.innerHTML = '';
            });
            
            // Show form and hide results
            form.classList.remove('hidden');
            resultsContainer.classList.add('hidden');
        });
    }
    
    console.log(`Quiz ${quizId} initialized successfully with ${questions.length} questions`);
}

/**
 * Update the user's quiz progress in the database
 * 
 * @param {string} quizId - The ID of the completed quiz
 * @param {number} score - The user's score
 * @param {number} totalQuestions - The total number of questions
 */
function updateQuizProgress(quizId, score, totalQuestions) {
    // Only attempt to update progress if the user is logged in
    if (typeof userId === 'undefined' || !userId) {
        console.log('User not logged in, skipping progress update');
        return;
    }
    
    const data = {
        quiz_id: quizId,
        score: score,
        total_questions: totalQuestions
    };
    
    // Send the data to the server
    fetch('/api/update-quiz-progress', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify(data)
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        console.log('Quiz progress updated:', data);
    })
    .catch(error => {
        console.error('Error updating quiz progress:', error);
    });
}
