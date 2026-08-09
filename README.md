<div align="center">

# ReqBin

**HTTP request inspector built with PHP and Vue**

[![PHP](https://img.shields.io/badge/PHP-8.3-777BB4?style=flat-square&logo=php&logoColor=white)](https://php.net)
[![Vue.js](https://img.shields.io/badge/Vue.js-3.x-4FC08D?style=flat-square&logo=vuedotjs&logoColor=white)](https://vuejs.org)
[![TypeScript](https://img.shields.io/badge/TypeScript-5.0-3178C6?style=flat-square&logo=typescript&logoColor=white)](https://typescriptlang.org)
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg?style=flat-square)](LICENSE)

<br />

<!--<video src="/preview/file.mp4" autoplay loop muted playsinline width="100%"></video>-->

</div>

---

## Features
- **Real-time requests**: requests appear immediately through WebSockets.
- **Request inspection**: view HTTP methods, headers, query parameters, and request bodies.
- **Rate limiting**: IP-based rate limiting backed by Redis.
- **Request validation**: payload size limits and security middleware.
- **Temporary bins**: bins and their requests expire automatically after 24 hours.


## Tech Stack
- **Frontend**:  Vue 3, TypeScript 
- **Backend**:  PHP 8.3, SQLite, Redis 
- **WebSockets**:  Soketi, Laravel Echo 
- **Infra & Ops**:  Nginx, Podman 



## Architecture Overview

```txt
┌──────────────┐       HTTP POST       ┌─────────────────┐       Save       ┌──────────────────┐
│ Incoming Req │ ────────────────────> │   PHP Backend   │ ───────────────> │ SQLite Database  │
└──────────────┘                       └────────┬────────┘                  └──────────────────┘
                                                │
                                                │ Broadcast Event
                                                ▼
┌──────────────┐        WebSocket      ┌─────────────────┐
│ Vue Frontend │ <──────────────────── │  Soketi Server  │
└──────────────┘                       └─────────────────┘
```

## Getting Started
### Prerequisites
- Docker/Podman

### Quickstart
```Bash
git clone https://github.com/k4ik/reqbin.git
cd reqbin
podman compose up -d --build
```

Open http://localhost:8000 in your browser.

## Example Usage
Create a bin via the web interface, then send requests using cURL:

```Bash
curl -X POST http://localhost:8000/bin/YOUR_BIN_ID \
  -H "Content-Type: application/json" \
  -H "X-Custom-Header: ReqbinTest" \
  -d '{"event": "user.signup", "userId": 42}'
```

## License
Distributed under the MIT License.
