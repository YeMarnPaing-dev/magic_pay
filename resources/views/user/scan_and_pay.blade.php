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
                <!-- Button -->
                <button type="button" class="btn btn-sm text-white" style="background-color:#5842E3;" data-toggle="modal"
                    data-target="#scanModal">
                    Scan
                </button>

                <!-- Modal -->
                <div class="modal fade" id="scanModal" tabindex="-1" role="dialog" aria-labelledby="scanModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">

                            <div class="modal-header">
                                <h5 class="modal-title" id="scanModalLabel">Scan</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-body">
                                <video id="scanner" style="width: 100%;height:300px" src=""></video>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
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
            $(document).ready(function() {
                var videoElem = document.getElementById('scanner')
                const qrScanner = new QrScanner(videoElem, function(result){
                    if(result){
                        qrScanner.stop();
                        $('#scanModal').modal('hide');
                    }
                    console.log(result);

                } );

                const myModalEl = document.getElementById('scanModal')
                myModalEl.addEventListener('shown.bs.modal', event => {
                      qrScanner.start();
                });

                  myModalEl.addEventListener('hidden.bs.modal', event => {
                      qrScanner.stop();
                });
            });
        </script>
    @endsection
