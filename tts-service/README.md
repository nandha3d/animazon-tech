# Kokoro TTS Microservice

A high-performance, lightweight Text-to-Speech API microservice powered by the **Kokoro-82M ONNX** model. This service is designed to run on a Virtual Private Server (VPS) and handle speech synthesis tasks asynchronously for the main application, keeping the website server free from heavy ML workloads.

---

## Features
- **Fast ONNX Inference:** Runs Kokoro-82M using `onnxruntime`, generating ultra-realistic studio-quality voice clips in seconds.
- **Dynamic Segment Stitching:** Accepts sequential segments of text to build a natural, continuous flow of speech with realistic pauses.
- **Zero Server Setup overhead:** Uses native HTTP requests to send text and retrieve audio files.

---

## Deployment to VPS

### Option 1: Using Docker (Recommended)
Docker ensures all dependencies (`libsndfile`, `onnxruntime`, etc.) are pre-configured in an isolated environment.

1. **Copy the `tts-service/` directory** to your VPS.
2. **Build the Docker Image:**
   ```bash
   docker build -t kokoro-tts-service .
   ```
3. **Run the Container:**
   ```bash
   docker run -d --name tts-service -p 8000:8000 --restart unless-stopped kokoro-tts-service
   ```
4. The service will be available at `http://your-vps-ip:8000`. You can access the automatic documentation/Swagger UI at `http://your-vps-ip:8000/docs`.

---

### Option 2: Running directly on Host (Python 3.10+)

1. **Install system packages:**
   On Ubuntu/Debian:
   ```bash
   sudo apt-get update && sudo apt-get install -y libsndfile1
   ```
2. **Install requirements:**
   ```bash
   pip install -r requirements.txt
   ```
3. **Start the server:**
   ```bash
   uvicorn main:app --host 0.0.0.0 --port 8000
   ```

---

## API Documentation

### 1. Health Check
- **Endpoint:** `GET /health`
- **Response:**
  ```json
  {
    "status": "healthy",
    "model_downloaded": true,
    "voices_downloaded": true
  }
  ```

### 2. Generate Audio
- **Endpoint:** `POST /api/tts/generate`
- **Headers:** `Content-Type: application/json`
- **Payload:**
  ```json
  {
    "segments": [
      "Hello, welcome to our web hosting proposal.",
      "We hope you like the new VPS configurations."
    ],
    "voice": "af_sarah",
    "lang": "en-us"
  }
  ```
- **Response:** Binary audio file with Content-Type `audio/wav`.
