document.addEventListener('DOMContentLoaded', function() {

    const imageCheckbox = document.getElementById('image-checker');
    const imageFile = document.getElementById('category-image');

    imageCheckbox.addEventListener('change', function(){

        if (imageCheckbox.checked) {
            imageFile.removeAttribute('disabled', true);
            imageFile.setAttribute('required', true);
        } else {
            imageFile.setAttribute('disabled', true);
            imageFile.removeAttribute('required', true);
        }
    });

    // update course category

    document.getElementById('update-category-btn').addEventListener('click', function() {

        const categoryName = document.getElementById('category-name');
        const categoryDescription = document.getElementById('category-description');

        if (imageFile.hasAttribute('required') == false && imageFile.hasAttribute('disabled')) {
            imageFile.value = null;
        }

        const confirmUpdate = confirm('Are you sure you want to update this course category?');
        if (confirmUpdate) {

            if (imageCheckbox.checked && imageFile.hasAttribute('required') == false) {
                imageFile.setAttribute('required', true);
                alert('Please select an image for the course category');
                event.preventDefault();
            }

            if (categoryName.value.trim() == '' || categoryDescription.value.trim() == '') {
                alert('Please fill in all the required fields');
                event.preventDefault();
            }
            document.getElementById('edit-course-category-form').submit();
        }

    });

});