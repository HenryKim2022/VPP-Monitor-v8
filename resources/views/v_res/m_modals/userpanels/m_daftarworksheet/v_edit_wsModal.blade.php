 <div class="modal fade text-left modal-success" id="edit_wsModal" data-bs-backdrop="static" role="dialog"
 {{-- tabindex="-1" --}}
     aria-labelledby="myModalLabel113" aria-hidden="false">
     <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="myModalLabel113">Edit Worksheet Informations</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
             <div class="modal-body" style="max-height: 85vh; overflow-y: auto;">
                 <form class="row g-2 needs-validation mt-1" method="POST" action="{{ route('m.ws.edit') }}" id="edit_wsModalFORM"
                     novalidate>
                     @csrf
                     <input type="hidden" id="edit-ws_id" name="edit-ws_id" value="" />
                     <input type="hidden" id="edit-ws_project_id" name="edit-ws_project_id" value="" />
                     <input type="hidden" id="edit-ws_id_karyawan" name="edit-ws_id_karyawan" value="" />
                     <div class="col-xl-12 col-md-12 col-12">
                        <div class="form-group">
                            <label for="edit-ws_working_date">Working-Date</label>
                            <input type="date" class="form-control pickadate-months-year" id="edit-ws_working_date" name="edit-ws_working_date"
                                placeholder="Date of Prj Started" value="{{ now()->toDateString() }}" />
                        </div>
                    </div>
                    <div class="col-xl-12 col-md-12 col-12">
                        <div class="form-group">
                            <label for="edit-ws_arrival_time">Arrival-Time</label>
                            <input type="time" id="edit-ws_arrival_time" name="edit-ws_arrival_time" class="form-control text-left flatpickr-time" value="{{ now()->format('H:i:s') }}" placeholder="HH:MM:SS" />
                        </div>
                    </div>
                    <div id="edit-ws_finish_time_section" class="col-xl-12 col-md-12 col-12">
                        <div class="form-group">
                            <label for="edit-ws_finish_time">Finish-Time</label>
                            <input type="time" id="edit-ws_finish_time" name="edit-ws_finish_time" class="form-control text-left flatpickr-time" value="{{ now()->format('H:i:s') }}" placeholder="HH:MM:SS" />
                        </div>
                    </div>

                     <div class="col-12 mb-3 mt-2">
                        <div class="form-check">
                          <input type="checkbox" class="form-check-input" id="bsvalidationcheckbox1" name="bsvalidationcheckbox1" data-default-checked="false" required />
                          <label class="form-check-label" for="bsvalidationcheckbox1">Proceed to save</label>
                          <div class="feedback text-muted">You must agree before saving.</div>
                        </div>
                      </div>
                     <div class="modal-footer w-100 px-0 pt-1 pb-0">
                         <div class="col-12 text-center">
                             <div class="d-flex flex-col justify-content-end">
                                 <button class="modal-btn btn btn-primary" data-dismiss="modal" id="confirmCancel"
                                     type="button">Cancel</button>
                                 <button class="modal-btn btn btn-success ml-1" id="confirmSave" {{-- type="submit" --}}>Save</button>
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


