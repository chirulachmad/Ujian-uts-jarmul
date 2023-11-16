<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Mendefinisikan karakter set dan viewport -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Judul halaman web -->
    <title>Radio Streaming </title>
    <!-- Gaya CSS untuk tata letak dan desain -->
    <style>
        body {
    font-family: 'Roboto', sans-serif;
    text-align: center;
    padding: 20px;
    background-color: #282c36;
    color: #ffffff;
    background-image: url('r.jpg')
}

.container {
    max-width: 600px;
    margin: 0 auto;
}

.header {
    background-color: #61dafb;
    color: #282c36;
    padding: 10px;
    border-radius: 8px;
    margin-bottom: 20px;
}

.title {
    font-size: 40px;
    margin-bottom: 10px;
}

.subtitle {
    font-size: 24px;
    margin-bottom: 20px;
}

.btn-container {
    margin-top: 20px;
}

button {
    background-color: #61dafb;
    color: #282c36;
    border: none;
    padding: 10px 20px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 18px;
    margin: 10px 5px;
    cursor: pointer;
    border-radius: 8px;
    transition: background-color 0.3s ease;
}

button:hover {
    background-color: #4fa3d1;
}

button:active {
    background-color: #3d8eb1;
}

select, input[type="number"] {
    padding: 10px;
    font-size: 16px;
    border-radius: 8px;
    margin-bottom: 10px;
    width: calc(100% - 20px);
    border: 2px solid #61dafb;
    background-color: #282c36;
    color: #ffffff;
}

select:hover, input[type="number"]:hover {
    border-color: #4fa3d1;
}

audio {
    width: 100%;
    margin-top: 20px;
}

.volume-slider {
    width: 80%;
    margin-top: 20px;
}

.volume-slider input[type="range"] {
    width: 100%;
    cursor: pointer;
    appearance: none;
    height: 10px;
    border-radius: 5px;
    background-color: #282c36;
    outline: none;
}

.volume-slider input[type="range"]::-webkit-slider-thumb {
    appearance: none;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background-color: #61dafb;
    cursor: pointer;
}

.volume-slider input[type="range"]::-moz-range-thumb {
    width: 20px;
    height: 20px;
    border-radius: 90%;
    background-color: #61dafb;
    cursor: pointer;
}

.volume-slider input[type="range"]::-ms-thumb {
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background-color: #61dafb;
    cursor: pointer;
}

@media screen and (max-width: 768px) {
    .container {
        padding: 0 20px;
    }
}

    </style>
</head>

<body>
    <div class="container">
        <!-- Judul halaman -->
        <div class="header">
            <div class="title">RADIO BERITA</div>
            <div class="subtitle">Menemani Gabut Anda</div>
        </div>

        <!-- Kontainer untuk tombol-tombol dan input -->
        <div class="btn-container">
            <!-- Tombol Play/Pause -->
            <button id="playPauseBtn">Play</button>
            <br>
            <!-- Tombol Stop -->
            <button id="stopBtn">Stop</button>
            <br>
            <!-- Dropdown untuk memilih saluran radio -->
            <select id="channelSelect">
                <option value="0">Suara Surabaya</option>
                <option value="1">Suara Medan</option>
                <option value="2">KBR</option>
                <option value="3">Dradio Jambi</option>
                <option value="4">E 100</option>
            </select>
            <br>
            <!-- Label dan input untuk waktu otomatis berhenti -->
            <label for="autoStopTime">Auto Stop Time (minutes):</label>
            <input type="number" id="autoStopTime" min="1" value="30">
        </div>

        <!-- Elemen audio untuk memutar radio dengan kontrol pemutaran -->
        <audio id="radio" controls></audio>
        <!-- Kontainer untuk slider volume -->
        <div class="volume-slider">
            <!-- Label slider volume -->
            <label for="volume">Volume:</label>
            <!-- Slider volume dengan nilai antara 0 dan 1, dengan langkah 0.1 -->
            <input type="range" id="volume" min="0" max="1" step="0.1" value="1">
        </div>
    </div>

    <!-- Script JavaScript untuk mengontrol pemutaran radio -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Mendapatkan elemen-elemen HTML yang diperlukan
            const radio = document.getElementById('radio');
            const playPauseBtn = document.getElementById('playPauseBtn');
            const stopBtn = document.getElementById('stopBtn');
            const volumeSlider = document.getElementById('volume');
            const channelSelect = document.getElementById('channelSelect');
            const autoStopTimeInput = document.getElementById('autoStopTime');

            // Array URL saluran radio
            const channels = [
                "https://c5.siar.us/proxy/ssfm/stream",
                "https://stream-node0.rri.co.id/streaming/11/9011/rrimedanpro4.mp3",
                "https://i.klikhost.com/8056/kbr",
                "https://i.klikhost.com/8132/stream/1/",
                "https://c5.siar.us/proxy/ssfm/stream"
            ];

            // Variabel untuk timer waktu otomatis berhenti dan status pemutaran
            let autoStopTimer;
            let isPlaying = false;

            // Fungsi untuk memutar saluran radio
            function playChannel(channelIndex) {
                radio.src = channels[channelIndex];
                radio.play();
                isPlaying = true;

                // Mengatur waktu otomatis berhenti dalam milidetik
                const autoStopTime = parseInt(autoStopTimeInput.value) * 60 * 1000;
                // Menjalankan timer waktu otomatis berhenti
                autoStopTimer = setTimeout(function () {
                    radio.pause();
                    radio.currentTime = 0;
                    playPauseBtn.textContent = 'Play';
                    isPlaying = false;
                    alert('Radio otomatis berhenti setelah ' + parseInt(autoStopTimeInput.value) + ' menit.');
                }, autoStopTime);
            }

            // Menambahkan event listener untuk memilih saluran radio
            channelSelect.addEventListener('change', function () {
                const selectedChannel = parseInt(channelSelect.value);
                playChannel(selectedChannel);
                playPauseBtn.textContent = 'Pause';
            });

            // Menambahkan event listener untuk tombol Play/Pause
            playPauseBtn.addEventListener('click', function () {
                if (isPlaying) {
                    radio.pause();
                    playPauseBtn.textContent = 'Play';
                } else {
                    const selectedChannel = parseInt(channelSelect.value);
                    playChannel(selectedChannel);
                    playPauseBtn.textContent = 'Pause';
                }
                isPlaying = !isPlaying;
            });

            // Menambahkan event listener untuk tombol Stop
            stopBtn.addEventListener('click', function () {
                radio.pause();
                radio.currentTime = 0;
                playPauseBtn.textContent = 'Play';
                isPlaying = false;
                // Menghentikan timer waktu otomatis berhenti
                clearTimeout(autoStopTimer);
            });

            // Menambahkan event listener untuk slider volume
            volumeSlider.addEventListener('input', function () {
                radio.volume = volumeSlider.value;
            });
        });
    </script>
</body>

</html>
