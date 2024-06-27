// Hamburger Navigation //

const burgerMenu = document.getElementById('hamburger-menu-icon');

const overlay = document.getElementById('menu');

burgerMenu.addEventListener('click', function () {
    this.classList.toggle("close");
    overlay.classList.toggle("overlay");
});



// Pen button
const btnMinus = document.getElementById('btn-minus');
const formDelete = document.getElementById('form-delete');
const btnPen = document.getElementById('btn-modifier');
const formModifier = document.getElementById('form-modifier');
const btnTool = document.getElementById('btn-tool');
const toolBox = document.getElementById('toolbox');

btnPen.addEventListener('click', function(event){
    if(event){
        formModifier.classList.toggle("hidden");
        formDelete.classList.add('hidden');
        btnPen.classList.toggle('.btn--pen--active');
        btnMinus.classList.remove('.btn--minus--active');
    }
})

// Minus button 

btnMinus.addEventListener('click', function(event){
    if(event){
        formDelete.classList.toggle('hidden');
        formModifier.classList.add('hidden');
        btnMinus.classList.toggle('.btn--minus--active');
        btnPen.classList.remove('.btn--pen--active');
    }
})

// console.log(btnPen, formModifier);

// Tool button

btnTool.addEventListener('click', function(event){
    if(event){
        btnTool.classList.toggle("btn--tool--clicked")
        btnPen.classList.toggle("hidden");
        btnMinus.classList.toggle("hidden");
        formModifier.classList.add('hidden');
        formDelete.classList.add('hidden');
    }
})