
document.addEventListener('DOMContentLoaded', function() {

    // save course
    document.getElementById('save-course-btn').addEventListener('click', function(event) {
        const courseTitle       = document.getElementById('course-title');
        const courseDescription = document.getElementById('course-description');
        const courseImage       = document.getElementById('course-image');
        const courseCategory    = document.getElementById('course-category');

        
        courseTitle.value       = courseTitle.value.trim();
        courseDescription.value = courseDescription.value.trim();
        courseImage.value       = courseImage.value.trim();
        courseCategory.value    = courseCategory.value.trim();
        

        if (courseTitle.value !== '' && courseDescription.value !== '' && courseImage.value !== '' && courseCategory.value !== '') {
            
            document.getElementById('create-course-form').submit();
        } else {
            alert('All fields are required');
        }
    });




});

