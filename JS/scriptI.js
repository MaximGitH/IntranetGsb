const containerSlot = document.querySelector(".slot");
const btnConfettis = document.querySelector("#main-logo");
const emojis = ["🦠", "💉","🔬","👌","🧪","🧫"];
const btnValider =document.querySelector(".button_valider");

btnConfettis.addEventListener("click", fiesta);

function fiesta() {
  
  if(isTweening()) return;

  for (let i = 0; i < 200; i++) {
    const confetti = document.createElement("div");
    confetti.innerText = emojis[Math.floor(Math.random() * emojis.length)];
    containerSlot.appendChild(confetti);
  }

  animateConfettis();
}

function animateConfettis() {
  
  const TLCONF = gsap.timeline();

  TLCONF.to(".slot div", {
    y: "random(-20,100)",
    x: "random(-100,100)",
    z: "random(0,1000)",
    rotation: "random(-90,90)",
    duration: 2,
  })
    .to(".slot div", { autoAlpha: 0, duration: 0.3 }, "-=0.2")
    .add(() => {
      containerSlot.innerHTML = "";
    });
}

function isTweening(){
  return gsap.isTweening('.slot div');
}

var animateButton = function(e) {

  e.preventDefault;
  //reset animation
  e.target.classList.remove('animate');
  
  e.target.classList.add('animate');
  setTimeout(function(){
    e.target.classList.remove('animate');
  },700);
};

var bubblyButtons = document.getElementsByClassName(".bubbly-button");

for (var i = 0; i < bubblyButtons.length; i++) {
  bubblyButtons[i].addEventListener('click', animateButton, false);
}