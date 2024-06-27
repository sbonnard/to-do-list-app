// Hamburger Navigation //

const burgerMenu = document.getElementById('hamburger-menu-icon');

const overlay = document.getElementById('menu');

burgerMenu.addEventListener('click', function () {
    this.classList.toggle("close");
    overlay.classList.toggle("overlay");
});

// Pen button

const btnPen = document.getElementById('btn-modifier');
const formModifier = document.getElementById('form-modifier');

btnPen.addEventListener('click', function(event){
    if(event){
        formModifier.classList.toggle("hidden");
    }
})

// console.log(btnPen, formModifier);