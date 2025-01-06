 <div class="modal fade text-left modal-success" id="edit_absenModal" data-bs-backdrop="static" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel113" aria-hidden="false">
     <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="myModalLabel113">Edit Check-in/out Informations</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
             <div class="modal-body" style="max-height: 85vh; overflow-y: auto;">
                 <form class="row g-2 needs-validation mt-1" method="POST" action="{{ route('m.absen.edit') }}" id="edit_absenModalFORM"
                     novalidate>
                     @csrf
                     <input type="hidden" id="absen_id" name="absen_id" value="" />
                     <input type="hidden" id="karyawan_id" name="karyawan_id" value="" />
                     <div class="col-12 col-sm-6">
                         <div class="form-group mb-0">
                             <label>Employee</label>
                             <select class="select2 form-control form-control-lg" name="employee-id" id="employee-id" @disabled(true)>
                                {{-- GOT OPTIONS FROM JS --}}
                            </select>
                         </div>
                     </div>
                     <div class="col-xl-3 col-md-3 col-12 pr-0">
                        <div class="form-group">
                            <label>Attendance Status</label>
                            <select class="select2 form-control form-control-lg" name="attendance-status">
                                {{-- <option value="" selected disabled>Select status</option>
                                <option value="1">absent</option>
                                <option value="2">present</option>
                                <option value="3">permit</option>
                                <option value="4">unwell</option> --}}
                            </select>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-3 col-12">
                        <div class="form-group">
                            <label>Action</label>
                            <select class="select2 form-control form-control-lg" name="attendance-action">
                                <option value="" selected disabled>Select action</option>
                                <option value="1">Check-in</option>
                                <option value="2">Check-out</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-xl-12 col-md-12 col-12">
                        <div class="form-group">
                            <label class="form-label" for="absen-karyawan-reason">Reason</label>
                            <textarea class="form-control form-control-merge" id="absen-karyawan-reason" name="absen-karyawan-reason"
                                placeholder="e.g. Sakit diare parah" aria-describedby="absen-karyawan-reason" tabindex="4"></textarea>
                        </div>
                    </div>

                    <div class="col-xl-12 col-md-12 col-12">
                        <div class="form-group">
                            <label class="form-label" for="absen-karyawan-proof">Proof</label>
                            <input type="file" class="form-control form-control-merge"
                                id="absen-karyawan-proof" name="absen-karyawan-proof"
                                aria-describedby="absen-karyawan-proof" tabindex="5">
                        </div>
                    </div>

                     <div class="col-12 mb-3 mt-2">
                        <div class="form-check">
                          <input type="checkbox" class="form-check-input" id="bsvalidationcheckbox1" name="bsvalidationcheckbox1" data-default-checked="false" required />
                          <label class="form-check-label" for="bsvalidationcheckbox1">Proceed to save</label>
                          <div class="feedback text-muted">You must agree before saving.</div>
                        </div>
                      </div>
                     <div class="modal-footer w-100 px-0 py-1">
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


