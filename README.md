# ReqBin

ReqBin is a minimal request bin built with pure PHP to capture and inspect incoming HTTP requests. 

## ✨ Features

* Capture HTTP requests (GET, POST, PUT, DELETE, etc.)
* Inspect headers, body, and request metadata

## 🚀 Getting Started

### Installation

Clone the repository and start the containers:

```bash
git clone https://github.com/k4ik/reqbin.git
cd reqbin
podman compose up -d --build
```

The application will be available at:

* Backend: `http://localhost:8000`
* Frontend: `http://localhost:5173`

## 🧪 Usage

1. Create a new request bin:

   * Via frontend, or
   * Send a `POST` request to:

     ```
     http://localhost:8000/bin/new
     ```

2. Use the generated bin endpoint to receive requests:

   ```
   http://localhost:8000/bin/{id}
   ```

3. Send requests using tools like `curl`, Postman, or any HTTP client.

4. Inspect captured requests:

   * Via frontend, or
   * Send a `GET` request to:

     ```
     http://localhost:8000/bin/{id}/requests
     ```

## 🔮 Future Improvements

* Replace polling with WebSockets for real-time updates
* Improve UX, responsiveness, and accessibility
* Enhance performance and scalability

## 📄 License

This project is open-source and available under the MIT License.

---

Built for learning, debugging, and simple request inspection.
