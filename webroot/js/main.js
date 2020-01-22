document.onreadystatechange = _ => {
  if (document.readyState === 'complete') {
    const msgs = document.getElementsByClassName(`message`);
    fade(msgs);
  }
};
function fade(elems, delay = 4, interval = 0.1, step = 0.1) {
  // delay (before fade starts) in seconds
  // step (reduction in opacity per step)
  // interval (time between steps) in seconds
  setTimeout(_ => { 
    [...elems].forEach(elem => {
      elem.style.opacity = 1; 
      const timer = setInterval(_ => {
        if (elem.style.opacity <= 0) {
          clearInterval(timer);
          elem.style.display = `none`;
        }
        else {
          elem.style.opacity -= step;
        }
      }, interval * 1000);
    });
  }, delay * 1000);
}