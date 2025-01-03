let isTimerRunning = JSON.parse(localStorage.getItem("isTimerRunning")) || false;
let elapsedTime = parseInt(localStorage.getItem("elapsedTime")) || 0;
let currentTask = JSON.parse(localStorage.getItem("currentTask")) || null;
let tasks = JSON.parse(localStorage.getItem("tasks")) || [];

const taskNameInput = document.getElementById("taskName");
const timerCurrent = document.getElementById("timerCurrent");
let timerInterval = null;

const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

const stopTask = () => {
    fetch(`http://localhost:8000/tasks/${currentTask.name}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
        },
    })
        .then(response => response.json())
        .then(data => {
            if (data.error){
                showError(data.error)
            }
            console.log('Task stopped:', data);
        })
        .catch(error => {
            console.error('Error stopping task:', error);
        });
}
const startTask = () => {
    fetch(`http://localhost:8000/tasks/${currentTask.name}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
        },
    })
        .then(response => response.json())
        .then(data => {
            if (data.error){
                showError(data.error)
            }
            console.log('Task started:', data);
        })
        .catch(error => {
            console.error('Error starting task:', error);
        });
}
const showError = (error) => {
    timerCurrent.innerHTML = `<p>Error ${error}</p>`;
    setTimeout(window.location.reload.bind(window.location), 300);
}

const startTimer = () => {
    if (taskNameInput.value.trim() === "") {
        return;
    }
    currentTask = {
        name: taskNameInput.value.trim(),
        time: 0
    };
    tasks.push(currentTask);
    elapsedTime = 0;
    timerInterval = setInterval(() => {
        elapsedTime++;
        updateTimerDisplay(elapsedTime);
    }, 1000);
    startTask();
    isTimerRunning = true;
    saveState();
}


const stopTimer = () => {
    currentTask = {
        name: taskNameInput.value.trim(),
        time: 0
    };
    clearInterval(timerInterval);
    isTimerRunning = false;
    if (currentTask && currentTask.name) {
        stopTask();
        saveState();
        updateTimerDisplay(0)
        setTimeout(window.location.reload.bind(window.location), 500);
    }
}

const updateTimerDisplay = (time) => {
    if (isNaN(time)) {
        timerCurrent.innerHTML = `<p>Current timer: 0h 0m 0s</p>`;
        return
    }
    const seconds = time % 60;
    const minutes = Math.floor(time / 60) % 60;
    const hours = Math.floor(time / 3600);
    timerCurrent.innerHTML = `<p>Current timer: ${hours}h ${minutes}m ${seconds}s</p>`;

}

const saveState = () => {
    localStorage.setItem("isTimerRunning", JSON.stringify(isTimerRunning));
    localStorage.setItem("elapsedTime", elapsedTime);
    localStorage.setItem("currentTask", JSON.stringify(currentTask));
    localStorage.setItem("tasks", JSON.stringify(tasks));
}

