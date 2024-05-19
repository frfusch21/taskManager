"use strict";
document.addEventListener("DOMContentLoaded", function () {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const taskForm = document.querySelector("#taskForm");

    // Create task
    taskForm.addEventListener("submit", function (event) {
        event.preventDefault();
        const formData = new FormData(taskForm);
        fetch('/api/tasks', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Authorization': `Bearer ${localStorage.getItem('token')}`,
                'Accept': 'application/json',
            },
            body: formData
        }).then(response => {
            if (!response.ok) {
                return response.json().then(errorData => { throw errorData; });
            }
            return response.json();
        })
        .then(data => {
            console.log('Success data:', data);
            alert('Success: Task added');
            window.location.href = window.location.href.split('?')[0];
        })
        .catch((error) => {
            console.error('Error details:', error);
            alert('Error: Could not add task');
        });
    });

    // Update task
    const updateButtons = document.querySelectorAll(".update-task");
    updateButtons.forEach(button => {
        button.addEventListener("click", (event) => {
            const target = event.target;
            const buttonElement = target.closest('button.update-task');
            if (buttonElement) {
                const taskId = buttonElement.getAttribute("data-task-id");
                console.log(taskId);
                if (taskId) {
                    fetch(`/api/tasks-update/${taskId}`, {
                        method: 'PUT',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Authorization': `Bearer ${localStorage.getItem('token')}`,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ isDone: true })
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
                } else {
                    alert('Error: Unable to find task ID');
                }
            }
        });
    });

    // Delete task
    const deleteButtons = document.querySelectorAll(".delete-task");
    deleteButtons.forEach(button => {
        button.addEventListener("click", (event) => {
            const target = event.target;
            const buttonElement = target.closest('button.delete-task');
            if (buttonElement) {
                const taskId = buttonElement.getAttribute("data-task-id");
                if (taskId) {
                    fetch(`/api/tasks-delete/${taskId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Authorization': `Bearer ${localStorage.getItem('token')}`,
                            'Accept': 'application/json'
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
