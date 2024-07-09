import * as Task from "./_functions.js";

// REDO TASK 

let redoTaskButtons = document.querySelectorAll('.js-redo-task-btn');

redoTaskButtons
    .forEach(function (redoTaskButton) {
        redoTaskButton.addEventListener('click', function (e) {
            Task.redoTask(parseInt(this.dataset.redoTaskId));
        });
    });





