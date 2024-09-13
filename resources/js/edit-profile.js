// Description: This file contains the javascript code for edit-profile.html
document.addEventListener('DOMContentLoaded', function() {


   // update profile
   document.getElementById('update-btn').addEventListener('click', function() {
      const firstName     = document.getElementById('first_name');
      const lastName      = document.getElementById('last_name');
      const email         = document.getElementById('email');
      const formUpdateBtn = document.getElementById('form-update-btn');

      firstName.removeAttribute('disabled');
      lastName.removeAttribute('disabled');
      email.removeAttribute('disabled');
      formUpdateBtn.removeAttribute('style');

      // create an alert where the user can confirm the update
      // if the user confirms the update, then the form will be submitted
      // if the user cancels the update, then the form will not be submitted

      formUpdateBtn.addEventListener('click', function( event ) {
         const confirmUpdate = confirm('Are you sure you want to update your profile?');
         const firstName     = document.getElementById('first_name');
         const lastName      = document.getElementById('last_name');
         const email         = document.getElementById('email');

         if (firstName.value === '' || lastName.value === '' || email.value === '') {
            alert('Please fill in all fields');
            event.preventDefault();
         } else {

            if (confirmUpdate) {
               document.getElementById('edit-profile-form').submit();
            } else {
               // stop the form from submitting
               event.preventDefault();

               // disable the form fields, hide the update button and reset the the original values
               firstName.setAttribute('disabled', true);
               lastName.setAttribute('disabled', true);
               email.setAttribute('disabled', true);
               formUpdateBtn.setAttribute('style', 'display: none');

               // reset the original value
               firstName.value = firstName.getAttribute('value');
               lastName.value = lastName.getAttribute('value');
               email.value = email.getAttribute('value');


            }
         }
      });
   });


   //delete account

   document.getElementById('delete-btn').addEventListener('click', function() {

      const deletionPassword             = document.getElementById('deletion_password');
      const deletionPasswordConfirmation = document.getElementById('deletion_password_confirmation');

      // show modal-delete
      document.getElementById('modal-delete').style.display = 'block';

      // make the rest of the page unclickable and unscrollable when the modal is open
      document.getElementById('modal-delete').style.zIndex = '1';
      document.body.style.overflow = 'hidden';

      // close modal-delete when the user clicks on the cancel button and stop the form from submitting
      document.getElementById('cancel-delete-btn').addEventListener('click', function() {
         document.getElementById('modal-delete').style.display = 'none';
         event.preventDefault();
         document.body.style.overflow = 'auto';

         deletionPassword.value = null;
         deletionPasswordConfirmation.value = null;
      });

      // confirm delete\
      if (deletionPassword.value !== null && deletionPasswordConfirmation.value !== null) {

         document.getElementById('confirm-delete-btn').addEventListener('click', function() {
            
            const confirmDelete = confirm('Are you sure you want to delete your account?');      
            if (deletionPassword.value !== deletionPasswordConfirmation.value) {
               alert('Passwords do not match');
               deletionPassword.value = null;
               deletionPasswordConfirmation.value = null;
               event.preventDefault();
            } else if (confirmDelete) {
               document.getElementById('delete-account-form').submit();
            } else {
               // stop the form from submitting
               event.preventDefault();
            }
            
            
         });
      }
   });

   //change password

   document.getElementById('password-btn').addEventListener('click', function() {
      const changePasswordModal = document.getElementById('change-password-modal');
      const currentPassword = document.getElementById('current_password');
      const newPassword     = document.getElementById('new_password');
      const confirmPassword  = document.getElementById('new_password_confirmation');

      // show change-password-modal
      changePasswordModal.style.display = 'block';

      // make the rest of the page unclickable and unscrollable when the modal is open
      changePasswordModal.style.zIndex = '1';
      document.body.style.overflow = 'hidden';

      // close change-password-modal when the user clicks on the cancel button and stop the form from submitting
      document.getElementById('cancel-password-btn').addEventListener('click', function() {
         changePasswordModal.style.display = 'none';
         currentPassword.value = null;
         newPassword.value = null;
         confirmPassword.value = null;
         event.preventDefault();
         document.body.style.overflow = 'auto';
      });

      // confirm change password
      document.getElementById('change-password-btn').addEventListener('click', function() {
         

         if (newPassword.value !== confirmPassword.value) {
            alert('Passwords do not match');
            newPassword.value = null;
            confirmPassword.value = null;
            event.preventDefault();
         } else if (currentPassword.value === newPassword.value) {
            alert('New password cannot be the same as the current password');
            newPassword.value = null;
            confirmPassword.value = null;
            event.preventDefault();
         } else if (currentPassword.value === null || newPassword.value === null || confirmPassword.value === null) {
            alert('Please fill in all fields');
            event.preventDefault();
         } else {
            const confirmChangePassword = confirm('Are you sure you want to change your password?');
            if (confirmChangePassword) {
               document.getElementById('change-password-form').submit();
            } else {
               // stop the form from submitting
               event.preventDefault();
            }
         }
            
         
      });

   });

   //Change profile picture

   document.getElementById('user-img').addEventListener('click', function() {
      
      const changeProfilePictureModal = document.getElementById('modal-picture');
      const profilePicture            = document.getElementById('profile_picture');
      // show change-profile-picture-modal
      changeProfilePictureModal.style.display = 'block';

      // make the rest of the page unclickable and unscrollable when the modal is open
      changeProfilePictureModal.style.zIndex = '1';
      document.body.style.overflow = 'hidden';

      // close change-profile-picture-modal when the user clicks on the cancel button and stop the form from submitting
      document.getElementById('cancel-picture-btn').addEventListener('click', function() {
         changeProfilePictureModal.style.display = 'none';
         profilePicture.value = null;
         event.preventDefault();
         document.body.style.overflow = 'auto';
      });

      // confirm change profile picture
      document.getElementById('change-picture-btn').addEventListener('click', function() {
         const confirmChangePicture = confirm('Are you sure you want to change your profile picture?');
         if (confirmChangePicture) {

            if (profilePicture.value === null) {
               alert('Please select a file');
               event.preventDefault();
            } else {
               document.getElementById('change-picture-form').submit();
            }
            
         } else {
            // stop the form from submitting
            event.preventDefault();
         }
      });

   });


});