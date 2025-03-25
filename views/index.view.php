<!DOCTYPE html>
<html>
<head>
    <title>SSE Client Example</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        h1 {
            text-align: center;
            font-weight: 900;
            color: rgb(57, 93, 255);
        }
        #events {
            margin-top: 20px;
            padding: 10px;
            border: 1px solid rgb(57, 93, 255);
            border-radius: 5px;
            background-color: #f9f9f9;
            max-height: 50vh;
            min-height: 50vh;
            overflow-y: auto;
        }
        .button-wrappers {
            display: flex;
            justify-content: center;
            margin-top: 5%;
        }
        button {
            flex: auto;
            padding: 20px 40px;
            font-size: 16px;
            margin: 0 10px;
            cursor: pointer;
            border-radius: 5px;
        }

        #connectButton {
            background-color:rgb(57, 93, 255);
            color: white;
            border: none;
        }

        #disconnectButton {
            background-color: #f44336;
            color: white;
            border: none;
        }

        .input-group {
            margin-bottom: 15px;
        }
        .input-group label {
            display: block;
            margin-bottom: 5px;
        }
        .input-group input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        @media screen and (min-width: 430px) {
            .container {
                max-width: 100%;
                padding: 2.5%;
            }
            
            .button-wrappers {
                gap: 10px;
            }
            
            button {
                margin: 10px 0;
                width: 100%;
            }
            
            #events {
                min-height: 70vh;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>S.S.E Demo</h1>
        <p>Click the button below to connect to the server and start receiving updates.</p>
        <div class="button-wrappers">
            <div class="input-group">
                <label for="numEvents">Number of Events:</label>
                <input type="number" id="numEvents" name="numEvents" value="10" min="1">
            </div>
            <div class="input-group">
                <label for="interval">Interval (ms):</label>
                <input type="number" id="interval" name="interval" value="1000" min="100">
            </div>
            <div class="input-group">
                <label for="timeout">Timeout (ms):</label>
                <input type="number" id="timeout" name="timeout" value="30000" min="1000">
            </div>
        </div>
        <div id="events"></div>
        <div class="button-wrappers">
            <button id="disconnectButton" disabled>Disconnect</button>
            <button id="connectButton">Connect to Server</button>
        </div>
    </div>
    <script>
        let eventSource = null;
        const connectButton = document.getElementById('connectButton');
        const disconnectButton = document.getElementById('disconnectButton');
        const eventsDiv = document.getElementById('events');

        const numEventsInput = document.getElementById('numEvents');
        const intervalInput = document.getElementById('interval');
        const timeoutInput = document.getElementById('timeout');

        const getQueryParams = () => {
            const url = new URL(window.location.href);
            url.pathname = '/events';
            url.searchParams.set('numEvents', numEventsInput.value);
            url.searchParams.set('interval', intervalInput.value);
            url.searchParams.set('timeout', timeoutInput.value);
            return url.href;
        }

        connectButton.addEventListener('click', () => {
            if (!eventSource) {;
                eventSource = new EventSource(getQueryParams);

                // Listen for 'update' events
                eventSource.addEventListener('update', (event) => {
                    const data = JSON.parse(event.data);
                    const updateElement = document.createElement('p');
                    updateElement.textContent = `Update: ${JSON.stringify(data)}`;
                    eventsDiv.appendChild(updateElement);
                });

                // Listen for 'milestone' events
                eventSource.addEventListener('milestone', (event) => {
                    const data = JSON.parse(event.data);
                    const milestoneElement = document.createElement('p');
                    milestoneElement.style.color = 'red';
                    milestoneElement.textContent = `MILESTONE: ${JSON.stringify(data)}`;
                    eventsDiv.appendChild(milestoneElement);
                });

                // Handle connection errors
                eventSource.onerror = (error) => {
                    console.error('EventSource failed:', error);
                    eventSource.close();
                    eventSource = null;
                    connectButton.disabled = false;
                    disconnectButton.disabled = true;
                };

                connectButton.disabled = true;
                disconnectButton.disabled = false;
            }
        });

        disconnectButton.addEventListener('click', () => {
            if (eventSource) {
                eventSource.close();
                eventSource = null;
                connectButton.disabled = false;
                disconnectButton.disabled = true;
            }
        });
    </script>
</body>
</html>