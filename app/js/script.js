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
const btnPriority = document.getElementById('btn-priority');
const formPriority = document.getElementById('form-emergency');


// Pen button

btnPen.addEventListener('click', function(event){
    if(event){
        formModifier.classList.toggle("hidden");
        formDelete.classList.add('hidden');
        formPriority.classList.add('hidden');
        btnPen.classList.toggle('btn--pen--active');
        btnMinus.classList.remove('btn--minus--active');
        btnPriority.classList.remove('btn--priority--active');
    }
})

// Priority button

btnPriority.addEventListener('click', function(event){
    if(event){
        formPriority.classList.toggle("hidden");
        formDelete.classList.add('hidden');
        formModifier.classList.add('hidden');
        btnPriority.classList.toggle('btn--priority--active');
        btnMinus.classList.remove('btn--minus--active');
        btnPen.classList.remove('btn--pen--active');
    }
})

// Minus button 

btnMinus.addEventListener('click', function(event){
    if(event){
        formDelete.classList.toggle('hidden');
        formModifier.classList.add('hidden');
        formPriority.classList.add('hidden');
        btnMinus.classList.toggle('btn--minus--active');
        btnPen.classList.remove('btn--pen--active');
        btnPriority.classList.remove('btn--priority--active');
    }
})

// console.log(btnPen, formModifier);

// Tool button

btnTool.addEventListener('click', function(event){
    if(event){
        btnTool.classList.toggle("btn--tool--clicked")
        btnPen.classList.toggle("hidden");
        btnMinus.classList.toggle("hidden");
        btnPriority.classList.toggle("hidden");
        formModifier.classList.add('hidden');
        formPriority.classList.add('hidden');
        formDelete.classList.add('hidden');
        btnMinus.classList.remove('btn--minus--active');
        btnPen.classList.remove('btn--pen--active');
        btnPriority.classList.remove('btn--priority--active');
    }
})