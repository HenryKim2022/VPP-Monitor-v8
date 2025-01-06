@php
    $moniCount = count($project->monitor); // Get the length of the monitor array
@endphp


<div class="modal fade text-left modal-success" id="export_moniModal" data-bs-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="myModalLabel113" aria-hidden="false">
    <div class="modal-dialog modal-dialog-centered modal-sm modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel113">Export - Settings</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="false">&times;</span>
                </button>
            </div>

            <div class="modal-body" style="max-height: 85vh; overflow-y: auto;">
                <form id="printForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-1">
                        <input type="hidden" id="print-prj_id" name="print-prj_id" value="{{ $project->id_project }}"
                            @readonly(true) />
                        <input type="hidden" id="print-act" name="print-act" value="dom" />
                        <input type="hidden" id="print-monitor-title" name="print-monitor-title"
                            value="{{ $project->id_project }} {{ \Carbon\Carbon::parse($project->start_project)->isoFormat($cust_date_format) }} PROGRESS PROJECT MONITORING" />

                        <div class="form-group col-xl-12 col-md-12 col-12">
                            <div class="form-group">
                                <div class="demo-inline-spacing">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="monitor-def-print-setting"
                                            name="monitor-print-setting" class="custom-control-input" checked />
                                        <label class="custom-control-label"
                                            for="monitor-def-print-setting">Default</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="monitor-cs-print-setting" name="monitor-print-setting"
                                            class="custom-control-input" />
                                        <label class="custom-control-label"
                                            for="monitor-cs-print-setting">Custom</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-6 col-md-6 col-6">
                            <div class="form-group">
                                <label for="monitor-print-mt">Margin-Top(cm)</label>
                                <input type="number" id="monitor-print-mt" name="monitor-print-mt" class="form-control"
                                    placeholder="eg: 3" value="{{ '1.5' }}" step="0.1" min="0.1"
                                    max="4">
                            </div>
                        </div>
                        <div class="col-xl-6 col-md-6 col-6">
                            <div class="form-group">
                                <label for="monitor-print-mb">Margin-Bottom(cm)</label>
                                <input type="number" id="monitor-print-mb" name="monitor-print-mb" class="form-control"
                                    placeholder="eg: 0.1" value="{{ '1.5' }}" step="0.1" min="0.1"
                                    max="4">
                            </div>
                        </div>

                        <div class="col-xl-6 col-md-6 col-6">
                            <div class="form-group">
                                <label for="monitor-print-mr">Margin-Right(cm)</label>
                                <input type="number" id="monitor-print-mr" name="monitor-print-mr" class="form-control"
                                    placeholder="eg: 0.1" value="{{ '1.5' }}" step="0.1" min="0.1"
                                    max="4">
                            </div>
                        </div>
                        <div class="col-xl-6 col-md-6 col-6">
                            <div class="form-group">
                                <label for="monitor-print-ml">Margin-Left(cm)</label>
                                <input type="number" id="monitor-print-ml" name="monitor-print-ml" class="form-control"
                                    placeholder="eg: 0.1" value="{{ '1.5' }}" step="0.1" min="0.1"
                                    max="4">
                            </div>
                        </div>

                        <div class="col-xl-6 col-md-6 col-6">
                            <div class="form-group">
                                <label for="monitor-print-ep">Monitor Each Page(pcs)</label>
                                <input type="number" id="monitor-print-ep" name="monitor-print-ep"
                                    class="form-control" placeholder="eg: 3" value="{{ $moniCount }}"
                                    step="1" min="3" max="7">
                            </div>
                        </div>
                        <div class="col-xl-6 col-md-6 col-6">
                            @php
                                $moniTbody =
                                    $moniCount * ($moniCount * 2) -
                                    ($moniCount * 2 - ($moniCount < 3 ? ($moniCount < 2 ? 6.5 : 4.5) : 3.5));
                            @endphp
                            <div class="form-group">
                                <label for="monitor-print-tbh">Tbody Height(px)</label>
                                <input type="number" id="monitor-print-tbh" name="monitor-print-tbh"
                                    class="form-control" placeholder="eg: 459.5" value="{{ 475 - $moniTbody }}"
                                    step="1" min="3" max="1000">
                            </div>
                        </div>

                        <div class="col-xl-12 col-md-12 col-12">
                            <div class="form-group text-right">
                                <button onclick="submitForm(event, 'print')" type="button"
                                    class="btn btn-export btn-success">
                                    <i class="fas fa-duotone fa-print text-white"></i>
                                </button>
                                <button onclick="submitForm(event, 'pdf')" type="button"
                                    class="btn btn-export btn-success">
                                    <i class="fad fa-download text-white"></i>
                                </button>
                            </div>

                            <script>
                                const mailingTokenBtns = document.querySelectorAll('.btn-export');
                                mailingTokenBtns.forEach((button) => {
                                    button.addEventListener('click', function() {
                                        const preloader = document.getElementById('preloader');
                                        preloader.style.display = 'flex';
                                        document.body.classList.add('no-scroll');

                                        setTimeout(() => {
                                            preloader.style.display = 'none';
                                            document.body.classList.remove('no-scroll');
                                        }, 8000);  // 8000ms = 8 seconds
                                    });
                                });
                            </script>
                        </div>
                    </div>
                </form>

            </div>


            <div class="modal-footer d-none">
                <button type="button" class="btn btn-success" data-dismiss="modal">Okay</button>
            </div>
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const monitorPrintDefaultOption = document.getElementById('monitor-def-print-setting');
            const monitorPrintCustomOption = document.getElementById('monitor-cs-print-setting');
            const monitorPrintSettingInputs = [
                document.getElementById('monitor-print-mt'),
                document.getElementById('monitor-print-mb'),
                document.getElementById('monitor-print-mr'),
                document.getElementById('monitor-print-ml'),
                document.getElementById('monitor-print-ep'),
                document.getElementById('monitor-print-tbh')
            ];

            function toggleMarginInputs() {
                const isReadOnly = monitorPrintDefaultOption.checked;
                monitorPrintSettingInputs.forEach(input => {
                    input.readOnly = isReadOnly; // Set readOnly property
                    // Add or remove the read-only class
                    if (isReadOnly) {
                        input.readOnly = true;
                        input.classList.add('read-only');
                    } else {
                        input.readOnly = false;
                        input.classList.remove('read-only');
                    }
                });
            }

            monitorPrintDefaultOption.addEventListener('change', toggleMarginInputs);
            monitorPrintCustomOption.addEventListener('change', toggleMarginInputs);
            toggleMarginInputs(); // Initial call to set the correct state on page load
        });
    </script>

    <script>
        function submitForm(event, action) {
            event.preventDefault(); // Prevent the default form submission
            const form = document.getElementById('printForm');
            if (action === 'print') {
                form.action = '{{ route('m.mon.printdommon') }}';
            } else if (action === 'pdf') {
                form.action = '{{ route('m.mon.savedommon') }}'; // Change to your desired route
            }
            // console.log('Monitor Each Page:', document.getElementById('monitor-print-ep').value);
            form.submit(); // Submit the form programmatically
        }
    </script>



</div>
