document.addEventListener('DOMContentLoaded', function() {

    const playVideoBtn = document.getElementsByName('play-video');

    playVideoBtn.forEach(function(btn) {
        btn.addEventListener('click', function() {
            const videoUrl = btn.getAttribute('data-video-url');
            const videoIframe = document.getElementById('video-iframe');
            videoIframe.src = `/storage/lesson_videos/${videoUrl}`;
        });
    });

    const completionCheckboxes = document.querySelectorAll('input[name="completionCheck"]');
    completionCheckboxes.forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            const lessonId = this.dataset.lessonId;
            const isCompleted = this.checked;

            console.log(`Lesson ID: ${lessonId}, Completed: ${isCompleted}`);

            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            if (!csrfToken) {
                console.error('CSRF token not found.');
                return;
            }

            console.log(`Sending request to update completion status for lesson ${lessonId} to ${isCompleted}`);

            fetch(`/lessons/${lessonId}/completion`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ completed: isCompleted })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    console.log('Lesson completion status updated successfully.');
                } else {
                    console.error('Failed to update lesson completion status.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                // Revert the checkbox state
                this.checked = !isCompleted;
            });
        });
    });

    completionCheckboxes.forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            const lessonId = this.dataset.lessonId;
            const isCompleted = this.checked;

            console.log(`Lesson ID: ${lessonId}, Completed: ${isCompleted}`);

            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            if (!csrfToken) {
                console.error('CSRF token not found.');
                return;
            }

            console.log(`Sending request to update completion status for lesson ${lessonId} to ${isCompleted}`);

            fetch(`/lessons/${lessonId}/completion`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ completed: isCompleted })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    console.log('Lesson completion status updated successfully.');
                } else {
                    console.error('Failed to update lesson completion status.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                // Revert the checkbox state
                this.checked = !isCompleted;
            });
        });
    });

});