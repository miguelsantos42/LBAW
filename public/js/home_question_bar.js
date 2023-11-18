document.addEventListener("DOMContentLoaded", function() {
  var titleInput = document.getElementById('question-title');
  var additionalFields = document.getElementById('additional-fields');

  titleInput.addEventListener('click', function() {
      // Check if the additional fields are already shown
      if (additionalFields.style.display === 'none') {
          additionalFields.style.display = 'flex'; // Show the additional fields
          this.style.flexBasis = '25%'; // Reduce the width of the title input
      }
  });
});
