document.onreadystatechange = _ => {
  if (document.readyState === 'complete') {
    const msgs = document.getElementsByClassName(`message`);
    fade(msgs);
  }
};
function fade(elems) {
  setTimeout(_ => { 
    [...elems].forEach(elem => {
      elem.style.opacity = 1; 
      const timer = setInterval(_ => {
        if (elem.style.opacity == 0) {
          clearInterval(timer);
        }
        else {
          elem.style.opacity -= 0.1;
        }
      }, 100);
    });
  }, 4000);
}