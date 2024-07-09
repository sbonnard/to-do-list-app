import * as Task from "./_functions.js";

// END TASK 
let endTaskButtons = document.querySelectorAll('.js-end-task-btn');
// console.log(endTaskButtons);

async function callAPIEndTask(params) {
    try {
        const response = await fetch("api.php?" + params);
        const json = await response.json();
        document.querySelector("[data-end-task-content-id='" + json.id + "']").remove();
    }
    catch (error) {
        console.error("Unable to load todolist datas from the server : " + error);
    }
}


endTaskButtons.forEach(function (endTaskButton) {
    endTaskButton.addEventListener('click', function (e) {
        callAPIEndTask('action=end_task&id=' + endTaskButton.dataset.endTaskId + '&token=' + document.getElementById('token').value);
    });
});

// DELETE TASK
let deleteTaskButtons = document.querySelectorAll('[data-delete-task-id]');

// console.log(deleteTaskButtons);


///////////////////////////////////////////////////////////////////////////////////////////

deleteTaskButtons
    .forEach(function (deleteTaskButton) {
        deleteTaskButton.addEventListener('click', function (e) {
            Task.deleteTask(parseInt(this.dataset.deleteTaskId));
        });
    });

//////////////////////////////////////////////////////////////////////////////////////////

// async function callAPIDeleteTask(params) {
//     try {
//         const response = await fetch("api.php?" + params);
//         const json = await response.json();
//         document.querySelector("[data-end-task-content-id='" + json.id + "']").remove();
//     }
//     catch (error) {
//         console.error("Unable to load todolist datas from the server : " + error);
//     }
// }


// deleteTaskButtons.forEach(function (deleteTaskButton) {
//     deleteTaskButton.addEventListener('click', function (e) {
//         callAPIDeleteTask('action=delete&id=' + deleteTaskButton.dataset.deleteTaskId + '&token=' + document.getElementById('token').value);
//     });
// });



// ADD TASK
const addTaskForm = document.getElementById('addTaskForm');
console.log(addTaskForm);

async function callAPIAddTask(params) {
    try {
        const response = await fetch("api.php?" + params);
        const json = await response.json();
        document.querySelector("[data-task-list]").appendChild();
    }
    catch (error) {
        console.error("Unable to add a task to do list : " + error);
    }
}

addTaskForm.addEventListener('submit', function (e) {
    callAPIAddTask('action=create&token=' + document.getElementById('token').value);
});