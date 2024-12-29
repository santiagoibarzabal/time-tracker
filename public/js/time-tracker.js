let isTimerRunning = JSON.parse(localStorage.getItem("isTimerRunning")) || false;
let elapsedTime = parseInt(localStorage.getItem("elapsedTime")) || 0;
let currentTask = JSON.parse(localStorage.getItem("currentTask")) || null;
let buttonAction = JSON.parse(localStorage.getItem("buttonAction")) || "Start";
let tasks = JSON.parse(localStorage.getItem("tasks")) || [];

const taskNameInput = document.getElementById("taskName");
const startStopButton = document.getElementById("startStopButton");
const timerCurrent = document.getElementById("timerCurrent");
let timerInterval = null;

const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

const updateTask = () => {
    fetch(`http://localhost:8000/tasks/${currentTask.name}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
        },
        body: JSON.stringify({ time: elapsedTime })
    })
        .then(response => response.json())
        .then(data => {
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
            console.log('Task started:', data);
        })
        .catch(error => {
            console.error('Error starting task:', error);
        });
}
const startStopTimer = () => {
    if (isTimerRunning) {
        clearInterval(timerInterval);
        buttonAction = "Start"
        startStopButton.textContent = buttonAction;
        isTimerRunning = false;
        if (currentTask && currentTask.name) {
            updateTask();
            saveState();
        }
    } else {
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
        buttonAction = "Stop";
        startStopButton.textContent = buttonAction;
        isTimerRunning = true;
        saveState();
    }
}

const updateTimerDisplay = (time) => {
    const seconds = time % 60;
    timerCurrent.innerHTML = `<p>Current timer: ${seconds}</p>`;
}

const saveState = () => {
    localStorage.setItem("buttonAction", JSON.stringify(buttonAction));
    localStorage.setItem("isTimerRunning", JSON.stringify(isTimerRunning));
    localStorage.setItem("elapsedTime", elapsedTime);
    localStorage.setItem("currentTask", JSON.stringify(currentTask));
    localStorage.setItem("tasks", JSON.stringify(tasks));
}
