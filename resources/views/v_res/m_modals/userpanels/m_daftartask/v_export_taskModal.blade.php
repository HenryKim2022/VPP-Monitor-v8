@php
    $taskCount = count($loadDataWS['task']); // Get the length of the task array
@endphp


<div class="modal fade text-left modal-success" id="export_taskModal" data-bs-backdrop="static" tabindex="-1" role="dialog"
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
                <form id="printForm" {{-- action="{{ route('m.task.printdomtask') }}" --}} method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-1">
                        <input type="hidden" id="print-prj_id" name="print-prj_id"
                            value="{{ $loadDataWS->id_project }}" @readonly(true) />
                        <input type="hidden" id="print-ws_id" name="print-ws_id" value="{{ $loadDataWS->id_ws }}"
                            @readonly(true) />
                        <input type="hidden" id="print-ws_date" name="print-ws_date"
                            value="{{ $loadDataWS->working_date_ws }}" @readonly(true) />

                        <input type="hidden" id="print-act" name="print-act" value="dom" />
                        <input type="hidden" id="print-task-title" name="print-task-title"
                            value="{{ $project->id_project }} {{ \Carbon\Carbon::parse($loadDataWS->working_date_ws)->isoFormat($cust_date_format) }} DAILY WORKSHEETS" />

                        <div class="form-group col-xl-12 col-md-12 col-12">
                            <div class="form-group">
                                <div class="demo-inline-spacing">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="task-def-print-setting" name="task-print-setting"
                                            class="custom-control-input" checked />
                                        <label class="custom-control-label" for="task-def-print-setting">Default</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="task-cs-print-setting" name="task-print-setting"
                                            class="custom-control-input" />
                                        <label class="custom-control-label" for="task-cs-print-setting">Custom</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-6 col-md-6 col-6">
                            <div class="form-group">
                                <label for="task-print-mt">Margin-Top(cm)</label>
                                <input type="number" id="task-print-mt" name="task-print-mt" class="form-control"
                                    placeholder="eg: 3" value="{{ '1.5' }}" step="0.1" min="0.1"
                                    max="4">
                            </div>
                        </div>
                        <div class="col-xl-6 col-md-6 col-6">
                            <div class="form-group">
                                <label for="task-print-mb">Margin-Bottom(cm)</label>
                                <input type="number" id="task-print-mb" name="task-print-mb" class="form-control"
                                    placeholder="eg: 0.1" value="{{ '1.5' }}" step="0.1" min="0.1"
                                    max="4">
                            </div>
                        </div>

                        <div class="col-xl-6 col-md-6 col-6">
                            <div class="form-group">
                                <label for="task-print-mr">Margin-Right(cm)</label>
                                <input type="number" id="task-print-mr" name="task-print-mr" class="form-control"
                                    placeholder="eg: 0.1" value="{{ '1.5' }}" step="0.1" min="0.1"
                                    max="4">
                            </div>
                        </div>
                        <div class="col-xl-6 col-md-6 col-6">
                            <div class="form-group">
                                <label for="task-print-ml">Margin-Left(cm)</label>
                                <input type="number" id="task-print-ml" name="task-print-ml" class="form-control"
                                    placeholder="eg: 0.1" value="{{ '1.5' }}" step="0.1" min="0.1"
                                    max="4">
                            </div>
                        </div>

                        <div class="col-xl-6 col-md-6 col-6">
                            <div class="form-group">
                                <label for="task-print-ep">Task Each Page(pcs)</label>
                                <input type="number" id="task-print-ep" name="task-print-ep" class="form-control"
                                    placeholder="eg: 3" value="{{ $taskCount }}" step="1" min="3"
                                    max="7">
                            </div>
                        </div>
                        <div class="col-xl-6 col-md-6 col-6">
                            <div class="form-group">
                                <label for="task-print-tbh">Tbody Height(px)</label>
                                <input type="number" id="task-print-tbh" name="task-print-tbh" class="form-control"
                                    placeholder="eg: 266"
                                    value="{{ 270 - ($taskCount * ($taskCount * 2) - ($taskCount * 2 - ($taskCount < 3 ? ($taskCount < 2 ? 6.5 : 4.5) : 3.5))) }}"
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

                            @if ($isProjectOpen)
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
                                            }, 8000); // 8000ms = 8 seconds
                                        });
                                    });
                                </script>
                            @endif
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
            const taskPrintDefaultOption = document.getElementById('task-def-print-setting');
            const taskPrintCustomOption = document.getElementById('task-cs-print-setting');
            const taskPrintSettingInputs = [
                document.getElementById('task-print-mt'),
                document.getElementById('task-print-mb'),
                document.getElementById('task-print-mr'),
                document.getElementById('task-print-ml'),
                document.getElementById('task-print-ep'),
                document.getElementById('task-print-tbh')
            ];

            function toggleMarginInputs() {
                const isReadOnly = taskPrintDefaultOption.checked;
                taskPrintSettingInputs.forEach(input => {
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

            taskPrintDefaultOption.addEventListener('change', toggleMarginInputs);
            taskPrintCustomOption.addEventListener('change', toggleMarginInputs);
            toggleMarginInputs(); // Initial call to set the correct state on page load
        });
    </script>


    <script>
        function submitForm(event, action) {
            event.preventDefault(); // Prevent the default form submission
            const form = document.getElementById('printForm');
            if (action === 'print') {
                form.action = '{{ route('m.task.printdomtask') }}';
            } else if (action === 'pdf') {
                form.action = '{{ route('m.task.savedomtask') }}'; // Change to your desired route
            }
            // console.log('Task Each Page:', document.getElementById('task-print-ep').value);
            form.submit(); // Submit the form programmatically
        }
    </script>




</div>
