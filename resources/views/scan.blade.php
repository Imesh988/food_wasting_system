<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Scan Barcode</title>
  <script src="https://unpkg.com/@zxing/library@latest"></script>
  <style>body{font-family:sans-serif;text-align:center;margin:16px}video{width:100%;max-width:420px;border:1px solid #ddd;border-radius:6px}</style>
</head>
<body>
  <h2>📷 Scan Product</h2>
  <video id="preview"></video>
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

// Try play video safely
if (video.paused) {
    video.play().catch(err => {
        console.error("Video play failed:", err);
    });
}

// Start scanning
codeReader.decodeFromVideoDevice(null, 'preview', (result, err) => {
  if (result) {
    status.textContent = 'Scanned: ' + result.text;
    sendBarcode(result.text);
  }
  // ignore not found errors
});



function sendBarcode(barcode, manualExpiry=null, batch=null) {
  fetch('{{ url('/scan-barcode') }}', {
    method: 'POST',
    headers: {'Content-Type':'application/json','X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').content},
    body: JSON.stringify({ barcode, manual_expiry: manualExpiry, batch })
  })
  .then(r=>r.json())
  .then(json=>{
    if (json.ok) status.textContent = '✅ Saved. Expiry: ' + (json.parsed.expiry ?? 'N/A');
    else status.textContent = 'Error saving';
  })
  .catch(e=> status.textContent = 'Network error');
}

document.getElementById('manualBtn').addEventListener('click', ()=> {
  const m = document.getElementById('manual');
  m.style.display = m.style.display === 'none' ? 'block' : 'none';
});
document.getElementById('manualSave').addEventListener('click', ()=> {
  const b = document.getElementById('barcodeInput').value.trim();
  const e = document.getElementById('expiryInput').value || null;
  if (!b) { alert('Enter barcode'); return; }
  sendBarcode(b, e);
});
</script>
</body>
</html>
