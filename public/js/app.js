"use strict";
document.addEventListener("DOMContentLoaded", function () {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const taskForm = document.querySelector("#taskForm");
    taskForm.addEventListener("submit", function (event) {
        event.preventDefault();
        const formData = new FormData(taskForm);
        fetch('/', {
            method: 'POST',
            body: formData
        }).then(response => response.json())
            .then(data => {
            alert('Success: Task added');
            window.location.href = window.location.href.split('?')[0]; 
        })
            .catch((error) => {
            alert('Error: Could not add task');
        });
    });
    const updateButtons = document.querySelectorAll(".update-task");
    updateButtons.forEach(button => {
        button.addEventListener("click", (event) => {
            const target = event.target;
            const buttonElement = target.closest('button.update-task');
            if (buttonElement) {
                const taskId = buttonElement.getAttribute("data-task-id");
                if (taskId) {
                    fetch(`/${taskId}`, {
                        method: 'PATCH',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                    }).then(response => {
                        if (!response.ok) {
                            return response.json().then(data => {
                                throw new Error(data.message || 'Failed to update task');
                            });
                        }
                        return response.json();
                    })
                        .then(data => {
                        alert('Success: Task updated');
                        window.location.href = window.location.href.split('?')[0]; 
                    })
                        .catch(error => alert('Error updating task: ' + error.message));
                }
            }
            else {
                alert('Error: Unable to find task ID');
            }
        });
    });
    const deleteButtons = document.querySelectorAll(".delete-task");
    deleteButtons.forEach(button => {
        button.addEventListener("click", (event) => {
            const target = event.target;
            const buttonElement = target.closest('button.delete-task');
            if (buttonElement) {
                const taskId = buttonElement.getAttribute("data-task-id");
                if (taskId) {
                    fetch(`/${taskId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                    })
                        .then(response => {
                        if (!response.ok) {
                            return response.json().then(data => {
                                throw new Error(data.message || 'Failed to delete task');
                            });
                        }
                        return response.json();
                    })
                        .then(data => {
                        alert('Success: Task deleted');
                        window.location.href = window.location.href.split('?')[0];
                    })
                        .catch(error => {
                        alert('Error deleting task: ' + error.message);
                    });
                }
            }
        });
    });
});
//# sourceMappingURL=app.js.map