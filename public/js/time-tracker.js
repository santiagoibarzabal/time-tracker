let isTimerRunning = false;
let elapsedTime = 0;
let currentTask = null;
let tasks = [];

const taskNameInput = document.getElementById("taskName");
const startStopButton = document.getElementById("startStopButton");
const timerCurrent = document.getElementById("timerCurrent");
let timerInterval = null;

const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

function startStopTimer() {
    if (isTimerRunning) {
        clearInterval(timerInterval);
        startStopButton.textContent = "Start";
        isTimerRunning = false;
        if (currentTask && currentTask.name) {
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

        console.log(currentTask.name)
        fetch(`http://localhost:8000/tasks/${currentTask.name}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
            },
            body: JSON.stringify({ time: elapsedTime })
        })
            .then(response => response.json())
            .then(data => {
                console.log('Task started:', data);
            })
            .catch(error => {
                console.error('Error starting task:', error);
            });

        startStopButton.textContent = "Stop";
        isTimerRunning = true;
    }
}

function updateTimerDisplay(time) {
    const seconds = time % 60;
    timerCurrent.innerHTML = `<p>Current timer: ${seconds}</p>`;
}
