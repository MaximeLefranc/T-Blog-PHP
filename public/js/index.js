const headerMobileBtn = document.querySelector('.header-mobile-icon');
const headerMobileList = document.querySelector('.header-mobile-list');

headerMobileBtn.addEventListener('click', () => {
  headerMobileList.classList.toggle('show');
});
