const current = document.querySelector('#current');

// Returns a nodelist of imgs
const imgs = document.querySelectorAll('.imgs>img');

// Create an event listener to respond to each image clicked
imgs.forEach(function() {
  addEventListener('click', click_image);
});

// Describe how to handle each image click
function click_image(event) {
  // Only perform following actions when an image is clicked
  if(event.target.src !== undefined){

    // Add fade in class
    current.classList.add('fade-in');
    
    // Remove fade-in class after .5 seconds
    setTimeout(() => current.classList.remove('fade-in'), 500);
    
    // Change current big image to the selected image src
    current.src = event.target.src;
  } else {
    // Do nothing 
  }
}