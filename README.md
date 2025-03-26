# SSE Proof of Concept with PHP 🚀

A fun little project demonstrating Server-Sent Events (SSE) using PHP and the Leaf framework. Get ready for some dad jokes streaming in real-time! 😄

## What's This All About? 🤔

This project shows how to implement Server-Sent Events in PHP. It streams random dad jokes and events to your browser in real-time. Because who doesn't need more dad jokes in their life?

## Prerequisites 🛠️

- A sense of humor (very important!)
- PHP 8.2+ (if running locally)
- Composer

## Quick Start 🏃‍♂️

1. Clone this repo:
```bash
git clone https://github.com/theranken/sse-poc-php.git
cd sse-poc-php
```

2. Start the app:
```bash
leaf serve
```

3. Open your browser and navigate to:
```
http://localhost:5500
```

4. Click the "Connect" button and watch the dad jokes roll in! 🎉

## Configuration Options ⚙️

You can customize the streaming behavior with these parameters:

- **Number of Events**: How many dad jokes you can handle (default: 10)
- **Interval**: Time between jokes in seconds (default: 1)
- **Timeout**: How long to keep the connection alive in milliseconds (default: 10000)

## How It Works 🤓

1. The frontend establishes an SSE connection
2. The backend streams random dad jokes and events
3. You laugh (or groan) at dad jokes
4. Everyone has a good time!

## Troubleshooting 🔧

- If jokes aren't streaming, check your connection
- If jokes are too dad-like... that's working as intended 😉

## Contributing 🤝

Feel free to contribute! Just keep the dad jokes coming.

## License 📄

MIT License - Feel free to use this, but remember: with great dad jokes comes great responsibility.

## Author ✍️

Built with ❤️ and too many dad jokes by Rankencorp