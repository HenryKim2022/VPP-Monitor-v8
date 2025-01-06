 <div class="modal fade text-left modal-success" id="edit_userModal" data-bs-backdrop="static" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel113" aria-hidden="false">
     <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="myModalLabel113">Edit User Informations</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
             <div class="modal-body" style="max-height: 85vh; overflow-y: auto;">
                 <form class="row g-2 needs-validation mt-1" method="POST" action="{{ route('m.user.cli.edit') }}" id="edit_userModalFORM"
                     novalidate>
                     @csrf
                     <input type="hidden" id="user_id" name="user_id" value="" />
                     <div class="col-12 col-sm-6">
                         <div class="form-group mb-0">
                             <label>Client</label>
                             <select class="select2 form-control form-control-lg" name="modalEditClient" id="modalEditClient" @disabled(true)>
                                {{-- GOT OPTIONS FROM JS --}}
                            </select>
                         </div>
                     </div>
                     <div class="col-12 col-md-6">
                         <div class="form-group form-floating form-floating-outline mb-0">
                             <label for="modalEditUsername">Username</label>
                             <input type="text" id="modalEditUsername" name="modalEditUsername" class="form-control"
                                 placeholder="Username" required />
                         </div>
                     </div>
                     <div class="col-12 col-md-12">
                         <div class="form-group form-floating form-floating-outline">
                             <label for="modalEditEmail">Email</label>
                             <input type="email" id="modalEditEmail" name="modalEditEmail" class="form-control"
                                 placeholder="Email" required />
                         </div>
                     </div>
                     <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label>User Type</label>
                            <select class="select2 form-control form-control-lg" name="modalEditUserType" id="modalEditUserType">
                                {{-- GOT OPTIONS FROM JS --}}
                            </select>
                        </div>
                     </div>
                     <div class="col-12 col-sm-6">
                         <div class="form-group">
                             <label for="modalEditPassword">Password</label>
                             <div class="input-group form-password-toggle input-group-merge">
                                 <input type="password" class="form-control" id="modalEditPassword" name="modalEditPassword"
                                     placeholder="Password" required />
                                 <div class="input-group-append">
                                     <div class="input-group-text cursor-pointer toggle-password">
                                         <i data-feather="eye"></i>
                                     </div>
                                 </div>
                             </div>
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


