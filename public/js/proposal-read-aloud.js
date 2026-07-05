document.addEventListener("DOMContentLoaded", function () {
    var buttons = document.querySelectorAll('[data-role="proposal-read-aloud"]');
    var synth = window.speechSynthesis;
    var currentAudio = null;
    var currentUtterances = [];
    var currentIndex = 0;
    var activeBtn = null;

    if (synth) {
        // Cancel any lingering browser speech on load
        synth.cancel();
    }

    function stopSpeaking() {
        if (synth && synth.speaking) {
            synth.cancel();
        }
        if (currentAudio) {
            currentAudio.pause();
            currentAudio = null;
        }
        if (activeBtn) {
            activeBtn.classList.remove('is-speaking');
            var icon = activeBtn.querySelector('i');
            if (icon) {
                icon.className = 'ti ti-volume-2';
            }
            activeBtn = null;
        }
        currentUtterances = [];
        currentIndex = 0;
    }

    function speakNext() {
        if (currentIndex < currentUtterances.length) {
            var utterance = currentUtterances[currentIndex];
            utterance.onend = function () {
                currentIndex++;
                speakNext();
            };
            utterance.onerror = function (event) {
                console.error("TTS error:", event);
                stopSpeaking();
            };
            synth.speak(utterance);
        } else {
            stopSpeaking();
        }
    }

    buttons.forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            e.preventDefault();

            if (activeBtn === btn) {
                stopSpeaking();
                return;
            }

            // Stop any active speech/audio
            stopSpeaking();

            activeBtn = btn;
            btn.classList.add('is-speaking');
            var icon = btn.querySelector('i');
            if (icon) {
                icon.className = 'ti ti-player-stop';
            }

            var docLang = document.documentElement.lang || 'en';
            // Check for Kokoro pre-generated audio file first
            var audioUrl = btn.getAttribute('data-tts-audio-url-' + docLang) || btn.getAttribute('data-tts-audio-url');
            
            if (audioUrl) {
                console.log("Attempting to play Kokoro TTS audio:", audioUrl);
                currentAudio = new Audio(audioUrl);
                currentAudio.play().then(function() {
                    currentAudio.onended = function() {
                        stopSpeaking();
                    };
                }).catch(function(err) {
                    console.warn("Audio playback failed, falling back to speech synthesis:", err);
                    playSpeechSynthesisFallback(btn, docLang);
                });
            } else {
                playSpeechSynthesisFallback(btn, docLang);
            }
        });
    });

    function playSpeechSynthesisFallback(btn, docLang) {
        if (!synth || !('speechSynthesis' in window)) {
            console.error("Web Speech API not supported.");
            stopSpeaking();
            return;
        }

        var segmentsJson = btn.getAttribute('data-tts-segments-' + docLang) || btn.getAttribute('data-tts-segments');
        if (!segmentsJson) {
            stopSpeaking();
            return;
        }

        var segments = [];
        try {
            segments = JSON.parse(segmentsJson);
        } catch (err) {
            console.error("Failed to parse TTS segments:", err);
            stopSpeaking();
            return;
        }

        if (!segments || segments.length === 0) {
            stopSpeaking();
            return;
        }

        var utterLang = docLang;
        if (docLang === 'hi') {
            utterLang = 'hi-IN';
        } else if (docLang === 'en') {
            utterLang = 'en-US';
        }

        currentUtterances = segments.map(function (text) {
            var u = new SpeechSynthesisUtterance(text);
            u.rate = 0.95;
            u.lang = utterLang;
            return u;
        });

        currentIndex = 0;
        speakNext();
    }

    // Cancel any active speech/audio on page leave
    window.addEventListener('beforeunload', function () {
        stopSpeaking();
    });
});
