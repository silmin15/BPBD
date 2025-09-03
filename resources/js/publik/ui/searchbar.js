// Simple debounce
const debounce = (fn, ms = 300) => {
  let t; return (...args) => { clearTimeout(t); t = setTimeout(() => fn(...args), ms); };
};

function initSearchbar(root) {
  const form = root;
  const input = form.querySelector('.searchbar__input');
  if (!input) return;

  // Submit → dispatch event 'searchbar:submit'
  form.addEventListener('submit', (e) => {
    // biar bisa dipakai sebagai "event-only" tanpa reload:
    if (!form.hasAttribute('action')) e.preventDefault();
    const q = input.value.trim();
    form.dispatchEvent(new CustomEvent('searchbar:submit', {
      bubbles: true, detail: { q }
    }));
  });

  // Input real-time → 'searchbar:input' (debounced)
  const wait = Number(form.dataset.debounce || 350);
  const emit = debounce((q) => {
    form.dispatchEvent(new CustomEvent('searchbar:input', {
      bubbles: true, detail: { q }
    }));
  }, wait);

  input.addEventListener('input', () => emit(input.value.trim()));
}

// init all
export function mountAllSearchbars() {
  document.querySelectorAll('.searchbar').forEach(initSearchbar);
}

// auto-init on DOM ready (safe)
if (document.readyState !== 'loading') mountAllSearchbars();
else document.addEventListener('DOMContentLoaded', mountAllSearchbars);
