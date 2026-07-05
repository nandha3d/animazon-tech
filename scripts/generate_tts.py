import os
import sys
import json
import urllib.request

# Dynamic dependency installer for ONNX-based Kokoro TTS
try:
    from kokoro_onnx import Kokoro
    import soundfile as sf
    import numpy as np
except ImportError:
    print("Installing missing dependencies (kokoro-onnx, soundfile, numpy)...")
    import subprocess
    subprocess.check_call([sys.executable, "-m", "pip", "install", "kokoro-onnx", "soundfile", "numpy"])
    from kokoro_onnx import Kokoro
    import soundfile as sf
    import numpy as np

# Cache directories for models
SCRIPT_DIR = os.path.dirname(os.path.abspath(__file__))
MODEL_DIR = os.path.join(SCRIPT_DIR, "model_cache")
os.makedirs(MODEL_DIR, exist_ok=True)

MODEL_URL = "https://huggingface.co/fastrtc/kokoro-onnx/resolve/main/kokoro-v1.0.onnx"
VOICES_URL = "https://huggingface.co/fastrtc/kokoro-onnx/resolve/main/voices-v1.0.bin"

MODEL_PATH = os.path.join(MODEL_DIR, "kokoro-v1.0.onnx")
VOICES_PATH = os.path.join(MODEL_DIR, "voices-v1.0.bin")

def download_file(url, path):
    if not os.path.exists(path):
        print(f"Downloading {url} to {path}...")
        # Custom progress reporter
        def reporthook(blocknum, blocksize, totalsize):
            readsofar = blocknum * blocksize
            if totalsize > 0:
                percent = readsofar * 1e2 / totalsize
                s = "\r%5.1f%% %*d / %d" % (
                    percent, 10, readsofar, totalsize)
                sys.stdout.write(s)
                sys.stdout.flush()
            else:
                sys.stdout.write("\rread %d\n" % (readsofar,))

        urllib.request.urlretrieve(url, path, reporthook)
        print("\nDownload complete.")

def main():
    if len(sys.argv) < 5:
        print("Usage: python generate_tts.py [output_path] [voice] [lang] [text_json_or_string]")
        sys.exit(1)

    output_path = sys.argv[1]
    voice = sys.argv[2]
    lang = sys.argv[3]
    text_input = sys.argv[4]

    try:
        segments = json.loads(text_input)
    except json.JSONDecodeError:
        segments = [text_input]

    # Ensure model and voice files exist
    download_file(MODEL_URL, MODEL_PATH)
    download_file(VOICES_URL, VOICES_PATH)

    print("Initializing Kokoro TTS...")
    kokoro = Kokoro(MODEL_PATH, VOICES_PATH)

    all_samples = []
    sample_rate = 24000

    # Match language code or fallback
    lang_code = lang.lower()
    if "hi" in lang_code:
        # Fallback to en-us (Kokoro v1.0 standard ONNX parses English phonemes)
        lang_code = "en-us"
    elif "en" in lang_code:
        lang_code = "en-us"

    print("Generating segments...")
    for idx, text in enumerate(segments):
        text = text.strip()
        if not text:
            continue
        try:
            print(f"Processing segment {idx+1}: {text[:60]}...")
            samples, sr = kokoro.create(text, voice=voice, speed=1.0, lang=lang_code)
            all_samples.append(samples)
            # Add a 0.5s pause between segments
            pause = np.zeros(int(sr * 0.5))
            all_samples.append(pause)
            sample_rate = sr
        except Exception as e:
            print(f"Error on segment {idx+1}: {e}")

    if not all_samples:
        print("No audio was successfully generated.")
        sys.exit(1)

    # Concatenate all generated audio segments
    final_audio = np.concatenate(all_samples[:-1])

    # Save audio output
    os.makedirs(os.path.dirname(output_path), exist_ok=True)
    sf.write(output_path, final_audio, sample_rate)
    print(f"Audio successfully saved to: {output_path}")

if __name__ == "__main__":
    main()
