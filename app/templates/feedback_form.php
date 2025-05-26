<?php
/**
 * Lesson feedback form template
 * This template displays a feedback form at the end of a lesson
 * 
 * Required variables:
 * - $lessonId: The ID of the lesson
 */

// Ensure required variables are set
if (!isset($lessonId)) {
    throw new Exception('Feedback form template requires $lessonId to be set');
}
?>

<div id="lesson-feedback-container" class="mt-8 p-6 bg-white dark:bg-gray-800 rounded-lg shadow-md">
    <h3 class="text-xl font-bold mb-4">Lesson Feedback</h3>
    <p class="mb-4">We'd love to hear your thoughts on this lesson. Your feedback helps us improve!</p>
    
    <form id="feedback-form" class="space-y-4">
        <input type="hidden" name="lesson_id" value="<?= htmlspecialchars($lessonId) ?>">
        
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">How would you rate this lesson?</label>
            <div class="flex space-x-8 justify-center">
                <label class="flex flex-col items-center cursor-pointer">
                    <input type="radio" name="rating" value="positive" class="sr-only" required>
                    <div class="text-5xl feedback-emoji" data-rating="positive">😃</div>
                    <span class="mt-1 text-sm">Great!</span>
                </label>
                
                <label class="flex flex-col items-center cursor-pointer">
                    <input type="radio" name="rating" value="neutral" class="sr-only">
                    <div class="text-5xl feedback-emoji" data-rating="neutral">😐</div>
                    <span class="mt-1 text-sm">Okay</span>
                </label>
                
                <label class="flex flex-col items-center cursor-pointer">
                    <input type="radio" name="rating" value="negative" class="sr-only">
                    <div class="text-5xl feedback-emoji" data-rating="negative">😞</div>
                    <span class="mt-1 text-sm">Gross!</span>
                </label>
            </div>
        </div>
        
        <div>
            <label for="feedback-comments" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Additional Comments (Optional)</label>
            <textarea id="feedback-comments" name="comments" rows="4" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white"></textarea>
        </div>
        
        <div class="flex justify-end">
            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-700 dark:hover:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800 dark:focus:ring-indigo-400">
                Submit Feedback
            </button>
        </div>
    </form>
    
    <div id="feedback-thank-you" class="hidden text-center py-6">
        <div class="text-3xl mb-2">🙏</div>
        <h4 class="text-lg font-medium mb-2">Thank You for Your Feedback!</h4>
        <p>Your input helps us improve our lessons for everyone.</p>
    </div>
</div>

<style>
.feedback-emoji {
    opacity: 0.5;
    transition: all 0.2s ease;
}

input[type="radio"]:checked + .feedback-emoji {
    opacity: 1;
    transform: scale(1.2);
}

label:hover .feedback-emoji {
    opacity: 0.8;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const feedbackForm = document.getElementById('feedback-form');
    const thankYouMessage = document.getElementById('feedback-thank-you');
    
    // Add click handlers for the emoji ratings
    document.querySelectorAll('.feedback-emoji').forEach(emoji => {
        emoji.addEventListener('click', function() {
            const rating = this.dataset.rating;
            document.querySelector(`input[value="${rating}"]`).checked = true;
        });
    });
    
    // Handle form submission
    feedbackForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(feedbackForm);
        
        // Submit the feedback via AJAX
        fetch('/lesson/saveFeedback', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show thank you message
                feedbackForm.classList.add('hidden');
                thankYouMessage.classList.remove('hidden');
            } else {
                alert('There was an error submitting your feedback. Please try again.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('There was an error submitting your feedback. Please try again.');
        });
    });
});
</script>
