<div class="modal fade text-left modal-success" id="edit_taskModal" data-bs-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="myModalLabel113" aria-hidden="false">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                {{-- <h5 class="modal-title" id="myModalLabel113">Edit Task Informations</h5> --}}
                <h5 class="modal-title" id="myModalLabel113">Edit
                *{{ \Carbon\Carbon::parse($loadDataWS->working_date_ws)->isoFormat($cust_date_format) }} -
                Task Informations
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="false">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="max-height: 85vh; overflow-y: auto;">
                <form class="row g-2 needs-validation mt-1" method="POST" action="{{ route('m.task.edit') }}"
                    id="edit_taskModalFORM" novalidate>
                    @csrf

                    @php
                        $currentTime = now();
                        $formattedTime = $currentTime->format('h:i:s');
                    @endphp
                    <input type="hidden" id="edit-task_id" name="edit-task_id" class="form-control text-left"
                        value="Filled by system!" placeholder="Filled by system!" />

                    <div class="col-xl-12 col-md-12 col-12">
                        <div class="form-group">
                            <label for="edit-task_work_time">Working-Time</label>
                            <input type="time" id="edit-task_work_time" name="edit-task_work_time"
                                class="form-control text-left flatpickr-time" value="{{ $formattedTime }}" placeholder="HH:MM:SS AM/PM" />
                        </div>
                    </div>
                    <div class="col-xl-12 col-md-12 col-12 mb-1">
                        <div class="form-group mb-0">
                            <label>Task</label>
                            <select class="select2 form-control form-control-lg" name="edit-task_id_monitoring"
                                id="edit-task_id_monitoring">
                                <option value="">Select Task</option>
                                {{-- generated ny JSONs --}}
                            </select>
                        </div>
                    </div>

                    <div class="col-xl-12 col-md-12 col-12">
                        <div class="form-group">
                            <label for="edit-task_description" data-toggle="tooltip"
                            data-popup="tooltip-custom" data-placement="bottom"
                            data-original-title="Min description character is 20-characters"
                            class="pull-down">Description <span id="charCount">(0)</span></label>
                            <textarea id="edit-task_description" name="edit-task_description" class="form-control" rows="3"
                                placeholder="*- Doing abcd &#10;*- Doing efg&#10;*- Doing hijkl"></textarea>
                        </div>
                    </div>
                    <div class="col-xl-12 col-md-12 col-12">
                        <div class="form-group">
                            <label for="edit-task_current_progress">Current Progress%</label>
                            <input type="number" id="edit-task_current_progress" name="edit-task_current_progress"
                                class="form-control" placeholder="eg: 2" step="0.01" min="0" max="100"></input>
                        </div>
                    </div>
                    <input type="hidden" class="form-control form-control-merge" id="edit-ws_id_ws"
                        name="edit-ws_id_ws" placeholder="filled by system" aria-describedby="edit-ws_id_ws"
                        tabindex="4" value="{{ auth()->user()->id_karyawan }}"></input>
                    <input type="hidden" class="form-control form-control-merge" id="edit-ws_id_project"
                        name="edit-ws_id_project" placeholder="filled by system" aria-describedby="edit-ws_id_project"
                        tabindex="4" value="{{ $loadDataWS->id_project }}"></input>

                    <input type="hidden" class="form-control form-control-merge" id="edit-ws_arrival_time"
                        name="edit-ws_arrival_time" placeholder="filled by system"
                        aria-describedby="edit-ws_arrival_time" tabindex="4"
                        value="{{ $loadDataWS->arrival_time_ws }}"></input>
                    <input type="hidden" class="form-control form-control-merge" id="edit-ws_finish_time"
                        name="edit-ws_finish_time" placeholder="filled by system" aria-describedby="edit-ws_finish_time"
                        tabindex="4" value="{{ $loadDataWS->finish_time_ws }}"></input>

                    <div class="col-12 mb-3 mt-1">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="bsvalidationcheckbox1"
                                name="bsvalidationcheckbox1" data-default-checked="false" required />
                            <label class="form-check-label" for="bsvalidationcheckbox1">Proceed to save</label>
                            <div class="feedback text-muted">You must agree before saving.</div>
                        </div>
                    </div>
                    <div class="modal-footer w-100 px-0 pt-1 mb-0">
                        <div class="col-12 text-center">
                            <div class="d-flex flex-col justify-content-end">
                                <button class="modal-btn btn btn-primary" data-dismiss="modal" id="confirmCancel"
                                    type="button">Cancel</button>
                                <button class="modal-btn btn btn-success ml-1" id="confirmSave"
                                    {{-- type="submit" --}}>Save</button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer d-none">
                <button type="button" class="btn btn-success" data-dismiss="modal">Okay</button>
            </div>
        </div>
    </div>
</div>
