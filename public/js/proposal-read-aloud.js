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
        if (synth.onvoiceschanged !== undefined) {
            synth.onvoiceschanged = function() {
                synth.getVoices();
            };
        }
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

            var docLang = btn.getAttribute('data-current-lang') || document.documentElement.lang || 'en';
            // Check for pre-existing audio file first
            var audioUrl = btn.getAttribute('data-tts-audio-url-' + docLang) || btn.getAttribute('data-tts-audio-url');
            
            if (audioUrl && audioUrl.length > 5) {
                console.log("Attempting to play audio file:", audioUrl);
                currentAudio = new Audio(audioUrl);
                currentAudio.play().then(function() {
                    currentAudio.onended = function() {
                        stopSpeaking();
                    };
                }).catch(function(err) {
                    console.warn("Audio playback failed, falling back to real-time speech synthesis:", err);
                    playRealtimeSpeech(btn, docLang);
                });
            } else {
                playRealtimeSpeech(btn, docLang);
            }
        });
    });

    function playRealtimeSpeech(btn, docLang) {
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

        var voiceSetting = btn.getAttribute('data-tts-voice') || 'en-IN-female';
        var voices = synth.getVoices();
        var selectedVoice = null;
        var utterLang = docLang;

        if (docLang === 'ml' || docLang === 'malayalam') {
            utterLang = 'ml-IN';
            if (voices && voices.length > 0) {
                selectedVoice = voices.find(function(v) {
                    return v.lang === 'ml-IN' || v.lang === 'ml_IN' || v.lang.indexOf('ml') === 0 || v.name.indexOf('Malayalam') !== -1 || v.name.indexOf('Sobhana') !== -1 || v.name.indexOf('Midhun') !== -1;
                });
            }
        } else if (docLang === 'hi' || docLang === 'hindi' || (docLang !== 'en' && (voiceSetting.indexOf('hi') !== -1 || voiceSetting === 'hf_alpha' || voiceSetting === 'hf_beta' || voiceSetting === 'hm_omega' || voiceSetting === 'hm_psi'))) {
            utterLang = 'hi-IN';
            if (voices && voices.length > 0) {
                var isMale = (voiceSetting.indexOf('hm_') !== -1 || voiceSetting.indexOf('male') !== -1 || voiceSetting.indexOf('Prabhat') !== -1 || voiceSetting.indexOf('Rishi') !== -1 || voiceSetting.indexOf('Hemant') !== -1);
                var hindiVoices = voices.filter(function(v) {
                    return v.lang === 'hi-IN' || v.lang === 'hi_IN' || v.lang.indexOf('hi') === 0 || v.name.indexOf('Hindi') !== -1;
                });
                if (hindiVoices.length > 0) {
                    if (isMale) {
                        selectedVoice = hindiVoices.find(function(v) {
                            return v.name.indexOf('Male') !== -1 || v.name.indexOf('Prabhat') !== -1 || v.name.indexOf('Rishi') !== -1 || v.name.indexOf('Hemant') !== -1;
                        }) || hindiVoices[0];
                    } else {
                        selectedVoice = hindiVoices.find(function(v) {
                            return v.name.indexOf('Female') !== -1 || v.name.indexOf('Swara') !== -1 || v.name.indexOf('Madhur') !== -1 || v.name.indexOf('Kalpana') !== -1;
                        }) || hindiVoices[0];
                    }
                }
            }
        } else if (docLang && docLang !== 'en' && docLang !== 'en-US' && docLang !== 'en-GB' && docLang !== 'en-IN') {
            utterLang = docLang;
            if (voices && voices.length > 0) {
                selectedVoice = voices.find(function(v) {
                    return v.lang.indexOf(docLang) === 0 || v.lang.replace('_', '-').toLowerCase().indexOf(docLang.toLowerCase()) === 0;
                });
            }
        } else {
            // English language reading - use admin voice setting
            utterLang = 'en-IN';
            if (voices && voices.length > 0) {
                if (voiceSetting.indexOf('GB') !== -1 || voiceSetting.indexOf('bf_') !== -1 || voiceSetting.indexOf('bm_') !== -1) {
                    utterLang = 'en-GB';
                    selectedVoice = voices.find(function(v) {
                        return v.lang === 'en-GB' || v.lang === 'en_GB' || v.name.indexOf('UK') !== -1 || v.name.indexOf('British') !== -1;
                    });
                } else if (voiceSetting.indexOf('US') !== -1 || voiceSetting.indexOf('af_') !== -1 || voiceSetting.indexOf('am_') !== -1) {
                    utterLang = 'en-US';
                    selectedVoice = voices.find(function(v) {
                        return v.lang === 'en-US' || v.lang === 'en_US' || v.name.indexOf('US') !== -1 || v.name.indexOf('United States') !== -1;
                    });
                } else {
                    // Default Indian English
                    utterLang = 'en-IN';
                    var isMale = (voiceSetting.indexOf('hm_') !== -1 || voiceSetting.indexOf('male') !== -1 || voiceSetting.indexOf('Prabhat') !== -1 || voiceSetting.indexOf('Rishi') !== -1 || voiceSetting.indexOf('Hemant') !== -1);
                    var indianVoices = voices.filter(function(v) {
                        return v.lang === 'en-IN' || v.lang === 'en_IN' || v.name.indexOf('India') !== -1;
                    });
                    if (indianVoices.length > 0) {
                        if (isMale) {
                            selectedVoice = indianVoices.find(function(v) {
                                return v.name.indexOf('Male') !== -1 || v.name.indexOf('Prabhat') !== -1 || v.name.indexOf('Rishi') !== -1 || v.name.indexOf('Hemant') !== -1 || v.name.indexOf('David') !== -1;
                            }) || indianVoices[0];
                        } else {
                            selectedVoice = indianVoices.find(function(v) {
                                return v.name.indexOf('Female') !== -1 || v.name.indexOf('Neerja') !== -1 || v.name.indexOf('Veena') !== -1 || v.name.indexOf('Heera') !== -1 || v.name.indexOf('Kalpana') !== -1 || v.name.indexOf('Swara') !== -1;
                            }) || indianVoices[0];
                        }
                    }
                }
            }
        }

        currentUtterances = segments.map(function (text) {
            var u = new SpeechSynthesisUtterance(text);
            u.rate = 0.95;
            u.lang = utterLang;
            if (selectedVoice) {
                u.voice = selectedVoice;
            }
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
