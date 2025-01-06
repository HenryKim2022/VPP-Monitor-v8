 <div class="modal fade text-left modal-success" id="edit_moniModal" data-bs-backdrop="static" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel113"
     {{-- aria-hidden="true" --}}
     >
     <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="myModalLabel113">Edit Monitoring Informations</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
             <div class="modal-body" style="max-height: 85vh; overflow-y: auto;">
                 <form class="row g-2 needs-validation mt-1" method="POST" action="{{ route('m.mon.edit') }}"
                     id="edit_moniModalFORM" novalidate>
                     @csrf
                     <input type="hidden" id="edit-mon_id" name="edit-mon_id" value="" />
                     <input type="hidden" id="edit-mon_project_id" name="edit-mon_project_id" value="" />
                     <input type="hidden" id="edit-mon_karyawan_id" name="edit-mon_karyawan_id" value="" />
                     <div class="col-xl-12 col-md-12 col-12">
                         <div class="form-group">
                             <label class="form-label" for="edit-mon_category">Category</label>
                             <input class="form-control form-control-merge" id="edit-mon_category"
                                 name="edit-mon_category" placeholder="e.g. Category A"
                                 aria-describedby="edit-mon_category" tabindex="4"></input>
                         </div>
                     </div>
                     <div class="col-xl-6 col-md-6 col-12">
                         <div class="form-group">
                             <label class="form-label" for="edit-mon_qty">Weight%</label>
                             <input class="form-control form-control-merge" id="edit-mon_qty" name="edit-mon_qty"
                                 placeholder="e.g. 8" aria-describedby="edit-mon_qty" tabindex="4" value="{{ old('edit-mon_qty') }}" step="0.01" min="0" max="100"></input>
                         </div>
                     </div>



                     <input type="hidden" class="form-control" id="edit-prj_start_date" name="edit-prj_start_date"
                         placeholder="Date of Prj Started" value="{{ \Carbon\Carbon::parse($project->start_project)->format('Y-m-d') }}" />
                     <input type="hidden" class="form-control" id="edit-prj_deadline_date"
                         name="edit-prj_deadline_date" placeholder="Date of Prj Ended"
                         value="{{ \Carbon\Carbon::parse($project->deadline_project)->format('Y-m-d') }}" />
                     <div class="col-xl-6 col-md-6 col-12 form-group">
                         <label for="edit-mon_start_end_date">Start-Date to End-Date</label>
                         <input type="text" id="edit-mon_start_end_date" name="edit-mon_start_end_date"
                             class="form-control flatpickr-range" placeholder="YYYY-MM-DD to YYYY-MM-DD" />
                     </div>



                     <div class="col-12 mb-3 mt-2">
                         <div class="form-check">
                             <input type="checkbox" class="form-check-input" id="bsvalidationcheckbox1"
                                 name="bsvalidationcheckbox1" data-default-checked="false" required />
                             <label class="form-check-label" for="bsvalidationcheckbox1">Proceed to save</label>
                             <div class="feedback text-muted">You must agree before saving.</div>
                         </div>
                     </div>
                     <div class="modal-footer w-100 px-0 pt-1 pb-0">
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
