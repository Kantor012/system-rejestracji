const media = window.matchMedia("(max-width: 1024px)");

const sidebar = document.querySelector('.sidebar');
const close = document.querySelector('.sidebar__close');
const open = document.querySelector('.sidebar__open');

if (media.matches) {
  if (close) {
    sidebar.classList.add('sidebar--closed');

    close.addEventListener('click', () => {
      sidebar.classList.add('sidebar--closed');
    });
  }

  if (open) {
    open.addEventListener('click', () => {
      sidebar.classList.remove('sidebar--closed');
    });
  }
}