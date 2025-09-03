export const ready = (fn) =>
  document.readyState !== 'loading'
    ? fn()
    : document.addEventListener('DOMContentLoaded', fn);
