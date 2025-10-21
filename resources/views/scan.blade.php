<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Scan Barcode</title>
  <script src="https://unpkg.com/@zxing/library@latest"></script>
  <style>
    body {
      font-family: sans-serif;
      text-align: center;
      margin: 16px;
    }
    video {
      width: 100%;
      max-width: 420px;
      border: 1px solid #ddd;
      border-radius: 6px;
    }
    button {
      padding: 10px 18px;
      margin: 8px;
      border: none;
      border-radius: 6px;
      background-color: #007bff;
      color: white;
      cursor: pointer;
    }
    button:hover {
      background-color: #0056b3;
    }
  </style>
</head>
<body>
  <h2>📷 Scan Product</h2>
  
  <button id="startBtn">Start Camera</button>
  <video id="preview" playsinline></video>
  <p id="status">Waiting...</p>

  <button id="manualBtn">Manual entry</button>

  <div id="manual" style="display:none;margin-top:12px">
    <input id="barcodeInput" placeholder="Barcode / GTIN" style="width:90%;max-width:320px;padding:8px"><br><br>
    <label>Expiry <input id="expiryInput" type="date"></label><br><br>
    <button id="manualSave">Save</button>
  </div>

<script>
const codeReader = new ZXing.BrowserMultiFormatReader();
const status = document.getElementById('status');
const video = document.getElementById('preview');

document.getElementById('startBtn').addEventListener('click', () => {
  // Start scanning only after user clicks button
  codeReader.decodeFromVideoDevice(null, 'preview', (result, err) => {
    if (result) {
      status.textContent = 'Scanned: ' + result.text;
      sendBarcode(result.text);
    }
    if (err && !(err instanceof ZXing.NotFoundException)) {
      console.error(err);
    }
  });
  status.textContent = "Camera started...";
});

function sendBarcode(barcode, manualExpiry = null, batch = null) {
  fetch('{{ url('/scan-barcode') }}', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
    },
    body: JSON.stringify({ barcode, manual_expiry: manualExpiry, batch })
  })
  .then(r => r.json())
  .then(json => {
    if (json.ok)
      status.textContent = '✅ Saved. Expiry: ' + (json.parsed.expiry ?? 'N/A');
    else
      status.textContent = '⚠️ Error saving';
  })
  .catch(e => {
    status.textContent = 'Network error';
    console.error(e);
  });
}

document.getElementById('manualBtn').addEventListener('click', () => {
  const m = document.getElementById('manual');
  m.style.display = m.style.display === 'none' ? 'block' : 'none';
});

document.getElementById('manualSave').addEventListener('click', () => {
  const b = document.getElementById('barcodeInput').value.trim();
  const e = document.getElementById('expiryInput').value || null;
  if (!b) { alert('Enter barcode'); return; }
  sendBarcode(b, e);
});
</script>
</body>
</html>
