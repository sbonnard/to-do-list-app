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
const btnTheme = document.getElementById('btn-theme');
const formTheme = document.getElementById('form-new-theme');


// Pen button

btnPen.addEventListener('click', function(event){
    if(event){
        formModifier.classList.toggle("hidden");
        formDelete.classList.add('hidden');
        formPriority.classList.add('hidden');
        btnPen.classList.toggle('btn--pen--active');
        btnMinus.classList.remove('btn--minus--active');
        btnPriority.classList.remove('btn--priority--active');
        btnTheme.classList.remove('btn--theme--active');
    }
})

// Priority button

btnPriority.addEventListener('click', function(event){
    if(event){
        formPriority.classList.toggle("hidden");
        formDelete.classList.add('hidden');
        formModifier.classList.add('hidden');
        formTheme.classList.add('hidden');
        btnPriority.classList.toggle('btn--priority--active');
        btnMinus.classList.remove('btn--minus--active');
        btnPen.classList.remove('btn--pen--active');
        btnTheme.classList.remove('btn--theme--active');

    }
})

// Minus button 

btnMinus.addEventListener('click', function(event){
    if(event){
        formDelete.classList.toggle('hidden');
        formModifier.classList.add('hidden');
        formPriority.classList.add('hidden');
        formTheme.classList.add('hidden');
        btnMinus.classList.toggle('btn--minus--active');
        btnPen.classList.remove('btn--pen--active');
        btnPriority.classList.remove('btn--priority--active');
        btnTheme.classList.remove('btn--theme--active');
    }
})

// console.log(btnPen, formModifier);

// Theme Button

btnTheme.addEventListener('click', function(event){
    if(event){
        formTheme.classList.toggle('hidden');
        formModifier.classList.add('hidden');
        formPriority.classList.add('hidden');
        formDelete.classList.add('hidden');
        btnTheme.classList.toggle('btn--theme--active');
        btnMinus.classList.remove('btn--minus--active');
        btnPen.classList.remove('btn--pen--active');
        btnPriority.classList.remove('btn--priority--active');
    }
})

// Tool button

btnTool.addEventListener('click', function(event){
    if(event){
        btnTool.classList.toggle("btn--tool--clicked")
        btnPen.classList.toggle("hidden");
        btnMinus.classList.toggle("hidden");
        btnTheme.classList.toggle("hidden");
        btnPriority.classList.toggle("hidden");
        formModifier.classList.add('hidden');
        formPriority.classList.add('hidden');
        formDelete.classList.add('hidden');
        formTheme.classList.add('hidden');
        btnMinus.classList.remove('btn--minus--active');
        btnPen.classList.remove('btn--pen--active');
        btnPriority.classList.remove('btn--priority--active');
        btnTheme.classList.remove('btn--theme--active');
    }
})