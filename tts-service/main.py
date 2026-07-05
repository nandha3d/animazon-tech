import os
import urllib.request
import io
from fastapi import FastAPI, HTTPException
from fastapi.responses import Response
from pydantic import BaseModel
from typing import List, Optional
import soundfile as sf
import numpy as np

app = FastAPI(
    title="Kokoro TTS Microservice",
    description="High-performance, lightweight Text-to-Speech API powered by Kokoro-82M ONNX model.",
    version="1.0.0"
)

# Model paths and cache configuration
SCRIPT_DIR = os.path.dirname(os.path.abspath(__file__))
MODEL_DIR = os.path.join(SCRIPT_DIR, "model_cache")
os.makedirs(MODEL_DIR, exist_ok=True)

MODEL_URL = "https://huggingface.co/fastrtc/kokoro-onnx/resolve/main/kokoro-v1.0.onnx"
VOICES_URL = "https://huggingface.co/fastrtc/kokoro-onnx/resolve/main/voices-v1.0.bin"

MODEL_PATH = os.path.join(MODEL_DIR, "kokoro-v1.0.onnx")
VOICES_PATH = os.path.join(MODEL_DIR, "voices-v1.0.bin")

kokoro_instance = None

def download_file(url, path):
    if not os.path.exists(path):
        print(f"Downloading {url} to {path}...")
        urllib.request.urlretrieve(url, path)
        print("Download complete.")

def get_kokoro():
    global kokoro_instance
    if kokoro_instance is None:
        download_file(MODEL_URL, MODEL_PATH)
        download_file(VOICES_URL, VOICES_PATH)
        # Import dynamically to avoid loading overhead on startup
        from kokoro_onnx import Kokoro
        kokoro_instance = Kokoro(MODEL_PATH, VOICES_PATH)
    return kokoro_instance

class TTSRequest(BaseModel):
    segments: List[str]
    voice: Optional[str] = "af_sarah"
    lang: Optional[str] = "en-us"

@app.post("/api/tts/generate")
async def generate_tts(request: TTSRequest):
    try:
        kokoro = get_kokoro()
    except Exception as e:
        raise HTTPException(status_code=500, detail=f"Failed to initialize Kokoro model: {str(e)}")

    all_samples = []
    sample_rate = 24000
    
    # Determine correct language configuration (Kokoro-82M ONNX uses en-us for English/approximated phonemes)
    lang_code = request.lang.lower()
    if "hi" in lang_code:
        lang_code = "en-us"
    elif "en" in lang_code:
        lang_code = "en-us"

    for idx, text in enumerate(request.segments):
        text = text.strip()
        if not text:
            continue
        try:
            print(f"Synthesizing segment {idx+1}/{len(request.segments)}: '{text[:40]}...'")
            samples, sr = kokoro.create(text, voice=request.voice, speed=1.0, lang=lang_code)
            all_samples.append(samples)
            # Add a 0.5-second natural pause between segments
            pause = np.zeros(int(sr * 0.5))
            all_samples.append(pause)
            sample_rate = sr
        except Exception as e:
            print(f"Error generating segment {idx}: {str(e)}")
            
    if not all_samples:
        raise HTTPException(status_code=400, detail="No audio could be synthesized from the input segments.")

    # Concatenate segments and strip trailing pause
    final_audio = np.concatenate(all_samples[:-1])
    
    # Write to memory buffer as standard WAV audio file
    buffer = io.BytesIO()
    sf.write(buffer, final_audio, sample_rate, format='WAV')
    buffer.seek(0)
    
    return Response(content=buffer.read(), media_type="audio/wav")

@app.get("/health")
def health_check():
    try:
        # Check if model files are present (don't load them to keep health check fast)
        model_exists = os.path.exists(MODEL_PATH)
        voices_exist = os.path.exists(VOICES_PATH)
        return {
            "status": "healthy",
            "model_downloaded": model_exists,
            "voices_downloaded": voices_exist
        }
    except Exception as e:
        return {"status": "unhealthy", "error": str(e)}
