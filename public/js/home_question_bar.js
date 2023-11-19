document.addEventListener("DOMContentLoaded", function() {
  var titleInput = document.getElementById('question-title');
  var contentTextarea = document.getElementById('question-content');

  titleInput.addEventListener('focus', function() {
      console.log('Focused on title input'); // Test if the event is triggered
      contentTextarea.style.display = 'block'; // Show the content textarea
  });
});
