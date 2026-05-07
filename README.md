# Reqbin

> Minimalist RequestBin clone with real-time request inspection powered by WebSockets.

<!--
![Reqbin Preview](./docs/banner.png)
-->

## Features

- Generate temporary request endpoints
- Inspect incoming HTTP requests in real-time
- WebSocket-powered live updates
- Request detail inspection:
  - Headers
  - Body
  - Query parameters
  - HTTP method
- Persistent request history
- Automatic bin expiration after 24 hours
- Self-hostable architecture
- Lightweight and minimal setup

## Tech Stack

### Frontend
- Vue 3
- TypeScript
- Pinia

### Backend
- PHP
- SQLite

### Realtime
- Soketi
- Laravel Echo

### Infrastructure
- Podman
- Nginx

## Installation

### Prerequisites

- Docker or Podman

## Running Locally

### Clone the repository

```bash
git clone https://github.com/k4ik/reqbin.git
cd reqbin
```

### Start containers

```bash
podman compose up -d --build
```

or

```bash
docker compose up -d --build
```

## Architecture

Reqbin follows a lightweight layered architecture:

- Controllers handle HTTP requests
- Services contain business logic
- Repositories manage persistence
- DTOs standardize captured request data
- Workers handle background cleanup tasks

### Realtime Flow

```txt
Incoming Request
        ↓
PHP Backend
        ↓
SQLite Persistence
        ↓
Soketi Broadcast
        ↓
Vue Frontend Sync
```

## Project Structure

```txt
.
├── backend/
│   ├── app/
│   │   ├── Controllers/
│   │   ├── Database/
│   │   ├── DTO/
│   │   ├── Repositories/
│   │   ├── Services/
│   │   └── Workers/
│   │
│   ├── public/
│   └── storage/
│
├── frontend/
│   ├── src/
│   │   ├── components/
│   │   ├── composables/
│   │   ├── helpers/
│   │   ├── stores/
│   │   └── types/
│
└── README.md
```

## How It Works

1. Create a new temporary bin
2. Send requests to the generated endpoint
3. Reqbin captures and stores the request
4. Incoming requests are broadcast through WebSockets
5. The frontend updates in real-time
6. Expired bins are automatically cleaned after 24 hours

## Example Request

```bash
curl -X POST http://localhost:8000/bin/:bin \
  -H "Content-Type: application/json" \
  -d '{"message":"hello world"}'
```

<!--
## 📸 Screenshots

### Dashboard
![Dashboard](./docs/dashboard.png)

### Request Details
![Request Details](./docs/request-details.png)
-->

## Project Goals

Reqbin was built to explore:

- Real-time communication using WebSockets
- Request inspection systems
- Lightweight backend architecture
- Fullstack application design
- Self-hostable developer tooling

## Roadmap

- [x] Real-time request updates
- [x] Request storage
- [x] Request detail viewer
- [x] Automatic bin expiration
- [ ] Rate limiting
- [ ] Request filtering
- [ ] Security improvements
- [ ] Better UI/UX

## Contributing

Contributions, issues, and feature requests are welcome.

1. Fork the repository
2. Create your feature branch
3. Commit your changes
4. Push your branch
5. Open a Pull Request

## License

This project is licensed under the MIT License.