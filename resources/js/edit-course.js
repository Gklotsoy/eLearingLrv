document.addEventListener('DOMContentLoaded', function() {

    //enable image update
    const imageCheckbox = document.getElementById('image-checkbox');
    const imageInput = document.getElementById('image-input');

    imageCheckbox.addEventListener('change', function(){
        
        if (imageCheckbox.checked) {
            imageInput.removeAttribute('disabled');
        }
        else {
            imageInput.setAttribute('disabled', '');
        }
    });

    //enable title update

    const titleBtn = document.getElementById('course-title-btn');
    const titleInput = document.getElementById('course-title');

    titleBtn.addEventListener('click', function(){

        titleInput.removeAttribute('disabled');
        event.preventDefault();
    });

    //enable description update

    const descriptionBtn = document.getElementById('course-description-btn');
    const descriptionInput = document.getElementById('course-description');

    descriptionBtn.addEventListener('click', function(event){
            
        descriptionInput.removeAttribute('disabled');
        event.preventDefault();
    });


    //update course

    const updateBtn = document.getElementById('update-btn');
    const courseTitle = titleInput.value;
    const courseDescription = descriptionInput.value;

    updateBtn.addEventListener('click', function(event){
        const confirmUpdate = confirm('Are you sure you want to update this course?');
        if (confirmUpdate) {

            if (imageCheckbox.checked && imageInput.value == '') {
                alert('Please select an image');
                event.preventDefault();
                return;
            }

            if (titleInput.value == '') {
                alert('Please enter a title');
                event.preventDefault();
                titleInput.value = courseTitle;
                return;
            }

            if (descriptionInput.value == '') {
                alert('Please enter a description');
                event.preventDefault();
                descriptionInput.value = courseDescription;
                return;
            }

            const disableInputs = document.querySelectorAll('.course-data');

            disableInputs.forEach(function(input){ 
                input.removeAttribute('disabled');
            });

            document.getElementById('edit-course-form').submit();

        } else {
            event.preventDefault();
        }
    });

    const addLessonBtn = document.getElementById('add-lesson-btn');
    const newLessonForm = document.getElementById('new-lesson-form');

    addLessonBtn.addEventListener('click', function(){

        newLessonForm.removeAttribute('hidden').style.display = 'block';

    });

    const cancelLessonBtn = document.getElementById('cancel-lesson-btn');
    const lessonTitle = document.getElementById('lesson-title');
    const lessonDescription = document.getElementById('lesson-description');
    const lessonVideo = document.getElementById('lesson-video');

    cancelLessonBtn.addEventListener('click', function(event){

        newLessonForm.setAttribute('hidden', '');
        preventDefault();
        return;
    });

    const saveLessonBtn = document.getElementById('save-lesson-btn');

    saveLessonBtn.addEventListener('click', function(event){

        if (lessonTitle.value == '') {
            alert('Please enter a title');
            event.preventDefault();
            return;
        }

        if (lessonDescription.value == '') {
            alert('Please enter a description');
            event.preventDefault();
            return;
        }

        if (lessonVideo.value == '') {
            alert('Please enter a video URL');
            event.preventDefault();
            return;
        }

        document.getElementById('new-lesson-form').submit();
    });

    //enable button to delete lesson
    const deleteLessonBtn = document.querySelectorAll('.delete-lesson-btn');

    deleteLessonBtn.forEach(function(btn){

        btn.addEventListener('click', function(event){
            const confirmDelete = confirm('Are you sure you want to delete this lesson?');
            if (!confirmDelete) {
                event.preventDefault();
                return;
            }

        });
    });


});