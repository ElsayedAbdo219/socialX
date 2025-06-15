<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Chunked Video Upload with Progress</title>
    <style>
        body {
            font-family: sans-serif;
            padding: 30px;
        }

        #progressBar {
            width: 100%;
            height: 25px;
            background: #e0e0e0;
            border-radius: 10px;
            margin-top: 10px;
            overflow: hidden;
        }

        #progressFill {
            height: 100%;
            width: 0%;
            background: #4caf50;
            transition: width 0.2s;
        }

        #status {
            margin-top: 15px;
        }
    </style>
</head>

<body>

    <h2>🚀 رفع فيديو كبير - Chunked Upload</h2>

    <input type="file" id="videoFile" accept="video/mp4,video/mov"><br><br>
    <button onclick="startUpload()">Start Upload</button>

    <div id="progressBar">
        <div id="progressFill"></div>
    </div>
    <div id="status">🕒 بانتظار اختيار الملف...</div>

    <script>
        const uploadEndpoint = "http://socialx.test/chunk";
        const mergeEndpoint = "http://socialx.test/merge";
        const chunkSize = 1 * 1024 * 1024; // 1MB

        async function startUpload() {
            const fileInput = document.getElementById("videoFile");
            const file = fileInput.files[0];
            const status = document.getElementById("status");
            const progressFill = document.getElementById("progressFill");
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            if (!file) return alert("📂 اختر فيديو أولاً");

            const fileName = file.name.replace(/\s+/g, '_') + "_" + Date.now();
            const totalChunks = Math.ceil(file.size / chunkSize);

            status.innerText = `🔁 جاري رفع ${totalChunks} جزء من الملف...`;

            for (let i = 0; i < totalChunks; i++) {
                const start = i * chunkSize;
                const end = Math.min(start + chunkSize, file.size);
                const chunkBlob = file.slice(start, end);

                const formData = new FormData();
                formData.append("file_name", fileName);
                formData.append("chunk_number", i);
                formData.append("chunk", chunkBlob);

                try {
                    const res = await fetch(uploadEndpoint, {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": csrfToken
                        },
                        body: formData,
                    });

                    if (!res.ok) throw new Error("رفع الجزء فشل");

                    const percent = Math.floor(((i + 1) / totalChunks) * 100);
                    progressFill.style.width = `${percent}%`;
                    status.innerText = `✔️ تم رفع الجزء ${i + 1} من ${totalChunks} (${percent}%)`;
                } catch (err) {
                    status.innerText = `❌ فشل رفع الجزء ${i + 1}: ${err.message}`;
                    return;
                }
            }

            status.innerText = "🛠️ جاري دمج الأجزاء... انتظر...";
            progressFill.style.width = "100%";

            try {
                const res = await fetch(mergeEndpoint, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": csrfToken
                    },
                    body: JSON.stringify({
                        file_name: fileName
                    }),
                });

                const result = await res.json();
                if (res.ok) {
                    status.innerHTML =
                        `🎉 تم الدمج بنجاح! <br><a href="http://socialx.test/${result.file_path}" target="_blank">🎬 عرض الفيديو</a>`;
                } else {
                    status.innerText = `❌ فشل الدمج: ${result.error || "حدث خطأ"}`;
                }
            } catch (err) {
                status.innerText = `❌ فشل الاتصال بخادم الدمج`;
            }
        }
    </script>

</body>

</html>
