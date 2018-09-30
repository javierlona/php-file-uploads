const current = document.querySelector('#current');
// Returns a nodelist of imgs
const imgs = document.querySelectorAll('.imgs>img');

imgs.forEach(function() {
  addEventListener('click', (e) => current.src = e.target.src)
});
