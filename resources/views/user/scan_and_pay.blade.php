@extends('user.layouts.app_plain')
@section('title', 'Scan and Pay')

@section('content')

    <div class="Scan and Pay">
        <div class="card">
            <div class="card-body text-center">
                <div class="text-center">
                    <img style="width: 220px" src="{{ asset('frontend/image/scan.png') }}" alt="">
                </div>
                <p class="mb-3 mt-2">Click button,put QR code in the frame and pay.</p>

        <!-- Button -->
<button type="button" class="btn btn-sm text-white" style="background-color:#5842E3;"
    data-bs-toggle="modal" data-bs-target="#scanModal">
    Scan
</button>

<!-- Modal -->
<div class="modal fade" id="scanModal" tabindex="-1" aria-labelledby="scanModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="scanModalLabel">Scan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <video id="scanner" style="width: 100%; height:300px;"></video>
                <p id="scanResult" class="mt-2 text-success fw-bold"></p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>


            </div>
        </div>

    @endsection

@section('script')
<script src="{{ asset('frontend/js/qr-scanner.umd.min.js') }}"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const videoElem = document.getElementById('scanner');
    const resultElem = document.getElementById('scanResult');

    QrScanner.WORKER_PATH = "{{ asset('frontend/js/qr-scanner-worker.min.js') }}";

    const qrScanner = new QrScanner(videoElem, result => {
        const code = result.data;
        console.log(code);

        resultElem.textContent = "Scanned: " + code;

        if (code) {
            qrScanner.stop();
            const modalEl = document.getElementById('scanModal');
            const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
            modal.hide();
        }
    }, { returnDetailedScanResult: true });

    const myModalEl = document.getElementById('scanModal');

    myModalEl.addEventListener('shown.bs.modal', async () => {
        try {
            await qrScanner.start();
        } catch (e) {
            console.error("Camera start failed:", e);
            resultElem.textContent = "⚠️ No camera found or permission denied.";
        }
    });

    myModalEl.addEventListener('hidden.bs.modal', () => {
        qrScanner.stop();
    });
});

</script>
@endsection


