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
const addTaskForm = document.getElementById('addTaskForm');
const templateCreate = document.getElementById('templateGenerateTask');
const liTemplate = document.querySelectorAll('[data-template-create]');

const taskNumberTemplate = document.querySelectorAll('[data-template-task-id]');
const taskNameTemplate = document.querySelectorAll('[data-template-task-name]');
const taskPriorityTemplate = document.querySelectorAll('[data-template-task-priority]');

forEach.taskNumberTemplate(function (){
    templateCreate.content.taskNumberTemplate.innerHTML = 8;
    templateCreate.content.taskNameTemplate.innerHTML = "Bidule";
    templateCreate.content.taskPriorityTemplate.innerHTML = 48;
})
console.log(taskNumberTemplate);
console.log(taskNameTemplate);
console.log(taskPriorityTemplate);


async function callAPIAddTask(params) {
    try {
        const response = await fetch("api.php?" + params);
        const json = await response.json();
        templateCreate.appendChild(liTemplate);
    }
    catch (error) {
        console.error("Unable to add a task to do list : " + error);
    }
}

addTaskForm.addEventListener('submit', function (event) {
    event.preventDefault();
    
    Task.createTask({
        nameTask: this.querySelector('[name]'),
        priorityTask: this.querySelector('[priority]')
    })
});