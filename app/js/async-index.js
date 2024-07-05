// END TASK 

async function callAPIEndTask(params) {
    try {
        const response = await fetch("api.php?" + params);
        const json = await response.json();
        document.querySelector("[data-end-task-content-id='" + json.id + "']").remove();
    }
    catch(error) {
        console.error("Unable to load todolist datas from the server : " + error);
    }
}



let endTaskButtons = document.querySelectorAll('.js-end-task-btn');

console.log(endTaskButtons);

endTaskButtons.forEach(function(endTaskButton) {
    endTaskButton.addEventListener('click', function(e) {
        callAPIEndTask('action=end_task&id=' + endTaskButton.dataset.endTaskId + '&token=' + document.getElementById('token').value);
    });
});