document.getElementById('uploadForm').addEventListener('submit', async function(event) {
    event.preventDefault();
    const formData = new FormData();
    const videoFile = document.getElementById('videoInput').files[0];
    formData.append('video', videoFile);

    try {
        const response = await fetch('/upload', {
            method: 'POST',
            body: formData
        });
        const result = await response.json();
        if (response.ok) {
            const videoLink = document.getElementById('videoLink');
            videoLink.href = result.url;
            videoLink.textContent = result.url;
            document.getElementById('linkContainer').style.display = 'block';
        } else {
            alert('Gagal mengunggah video: ' + result.error);
        }
    } catch (error) {
        console.error('Terjadi kesalahan:', error);
        alert('Terjadi kesalahan saat mengunggah video.');
    }
});
