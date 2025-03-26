<!DOCTYPE html>
<html>
<head>
    <title>SSE POC</title>
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
            font-weight: 800;
            color: rgb(18, 18, 20);
        }

        p {
            text-align: center;
            font-size: 18px;
            color: #333;
        }

        #events {
            margin-top: 20px;
            padding: 10px;
            border: 1px solid rgba(18, 18, 20, 0.75);
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
            background-color: rgba(18, 18, 20, 0.9);
            color: white;
            border: none;
        }

        #disconnectButton {
            background-color: #f44336;
            color: white;
            border: none;
        }

        #connectButton:disabled,
        #disconnectButton:disabled {
            background-color: #ccc;
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

        .event-item {
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .event-header {
            padding: 10px;
            background-color: #f5f5f5;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
        }

        .event-content {
            padding: 10px;
            display: none;
        }

        .event-content.active {
            display: block;
        }

        .toggle-btn {
            transition: transform 0.3s;
        }

        .toggle-btn.active {
            transform: rotate(180deg);
        }

        pre {
            margin: 0;
            white-space: pre-wrap;
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
                <label for="interval">Interval:</label>
                <input type="number" id="interval" name="interval" value="5" min="1">
            </div>
            <div class="input-group">
                <label for="timeout">Timeout (ms):</label>
                <input type="number" id="timeout" name="timeout" value="10000" min="10000">
            </div>
        </div>

        <div id="events">
            <div id="accordion-container">
                <template id="event-template">
                    <div class="event-item">
                        <div class="event-header">
                            Event #<span class="event-number"></span>
                            <span class="toggle-btn">▼</span>
                        </div>
                        <div class="event-content">
                            <pre class="event-data"></pre>
                        </div>
                    </div>
                </template>
            </div>
        </div>
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
            url.pathname = '/api/events';
            url.searchParams.set('numEvents', numEventsInput.value);
            url.searchParams.set('interval', intervalInput.value);
            url.searchParams.set('timeout', timeoutInput.value);
            return url.href;
        }

        connectButton.addEventListener('click', () => {
            if (!eventSource) {
                ;
                eventSource = new EventSource(getQueryParams());

                eventSource.onmessage = function (event) {
                    const data = JSON.parse(event.data);
                    const template = document.getElementById('event-template');
                    const container = document.getElementById('accordion-container');
                    const clone = template.content.cloneNode(true);

                    clone.querySelector('.event-number').textContent = data.id;
                    clone.querySelector('.event-data').textContent = JSON.stringify(data, null, 2);

                    clone.querySelector('.event-header').addEventListener('click', function() {
                        const content = this.nextElementSibling;
                        const toggleBtn = this.querySelector('.toggle-btn');
                        content.classList.toggle('active');
                        toggleBtn.classList.toggle('active');
                    });

                    container.insertBefore(clone, container.firstChild);
                };

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