import * as Task from "./_functions.js";
/////////////////////////////////////////////////////////////////////////////////////////////////////////
// END TASK 
let endTaskButtons = document.querySelectorAll('.js-end-task-btn');

endTaskButtons
    .forEach(function (endTaskButton) {
        endTaskButton.addEventListener('click', function (e) {
            Task.endTask(parseInt(this.dataset.endTaskId));
        });
    });

/////////////////////////////////////////////////////////////////////////////////////////////////////////
// DELETE TASK
let deleteTaskButtons = document.querySelectorAll('[data-delete-task-id]');

deleteTaskButtons
    .forEach(function (deleteTaskButton) {
        deleteTaskButton.addEventListener('click', function (e) {
            Task.deleteTask(parseInt(this.dataset.deleteTaskId));
        });
    });

/////////////////////////////////////////////////////////////////////////////////////////////////////////
// ADD TASK
// const addTaskForm = document.getElementById('addTaskForm');
// const templateCreate = document.getElementById('templateGenerateTask');
// const liTemplate = document.querySelectorAll('[data-template-create]');

// console.log(liTemplate);

// console.log(addTaskForm);

// async function callAPIAddTask(params) {
//     try {
//         const response = await fetch("api.php?" + params);
//         const json = await response.json();
//         templateCreate.appendChild(liTemplate);
//     }
//     catch (error) {
//         console.error("Unable to add a task to do list : " + error);
//     }
// }

// addTaskForm.addEventListener('submit', function (e) {
//     callAPIAddTask('action=create&token=' + document.getElementById('token').value);
// });