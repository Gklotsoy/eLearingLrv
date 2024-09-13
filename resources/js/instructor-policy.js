document.addEventListener('DOMContentLoaded', function() {
    
    const agreementCheckbox = document.getElementById('agree');

    agreementCheckbox.addEventListener('change', function() {

        const updateForm = document.getElementById('update-form');

        if (agreementCheckbox.checked) {
            updateForm.classList.remove('hidden');
            document.querySelectorAll('.form-control').forEach(function(input) {
                input.value = '';
            });
        } else {
            updateForm.classList.add('hidden');
            document.querySelectorAll('.form-control').forEach(function(input) {
                input.value = '';
            });
        }


    });

    const updateButton = document.getElementById('upgrate-btn');

    updateButton.addEventListener('click', function(event) {

        const confirmation = confirm('Are you sure you want to upgrade your account?' + "\n" + 'This action is irreversible.');

        if (confirmation) {
            
            if (document.querySelector('.form-control').value === '') {
                alert('Please fill out the form.');
                event.preventDefault();
                return;
            }
            else {
                const updateForm = document.getElementById('update-form');
                updateForm.submit();
            }

        } 

    });

});