// REDO TASK 

async function callAPIRedoTask(params) {
    try {
        const response = await fetch("api.php?" + params);
        const json = await response.json();
        document.querySelector("[data-redo-task-content-id='" + json.id + "']").remove();
    }
    catch(error) {
        console.error("Unable to load todolist datas from the server : " + error);
    }
}



let redoTaskButtons = document.querySelectorAll('.js-redo-task-btn');

console.log(redoTaskButtons);

redoTaskButtons.forEach(function(redoTaskButton) {
    redoTaskButton.addEventListener('click', function(e) {
        callAPIRedoTask('action=redo_task&id=' + redoTaskButton.dataset.redoTaskId + '&token=' + document.getElementById('token').value);
    });
});