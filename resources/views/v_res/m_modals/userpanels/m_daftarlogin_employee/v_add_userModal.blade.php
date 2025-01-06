
 <div class="modal fade text-left modal-success" id="add_userModal" data-bs-backdrop="static" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel113" aria-hidden="false">
     <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="myModalLabel113">Add New User Informations</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
             <div class="modal-body" style="max-height: 85vh; overflow-y: auto;">
                 <form class="row g-2 needs-validation mt-1" method="POST" action="{{ route('m.user.emp.add') }}"
                     novalidate>
                     @csrf
                     <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label>Employee</label>
                            <select class="select2 form-control form-control-lg" name="modalAddEmployee" id="modalAddEmployee">
                                <option value="">Select Employee</option>
                                @foreach($employee_list as $employee)
                                    <option value="{{ $employee->id_karyawan }}">
                                        {{ $employee->na_karyawan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                     <div class="col-12 col-md-6">
                         <div class="form-group form-floating form-floating-outline">
                             <label for="modalAddUsername">Username</label>
                             <input type="text" id="modalAddUsername" name="modalAddUsername" class="form-control"
                                 placeholder="Username" required />
                         </div>
                     </div>
                     <div class="col-12 col-md-12">
                         <div class="form-group form-floating form-floating-outline">
                             <label for="modalAddEmail">Email</label>
                             <input type="email" id="modalAddEmail" name="modalAddEmail" class="form-control"
                                 placeholder="Email" required />
                         </div>
                     </div>
                     <div class="col-12 col-sm-6">
                         <div class="form-group">
                             <label>User Type</label>
                             <select class="select2 form-control form-control-lg" name="modalAddUserType" id="modalAddUserType" aria-autocomplete="none">
                                 <option value="">
                                     Select UserType</option>
                                 {{-- <option value="1" selected>
                                     Client</option> --}}
                                 <option value="2">
                                     Superuser</option>
                                 <option value="3">
                                     Supervisor</option>
                                 <option value="4" selected>
                                     Engineer</option>
                             </select>




                         </div>
                     </div>
                     <div class="col-12 col-sm-6">
                         <div class="form-group">
                             <label for="modalAddPassword">Password</label>
                             <div class="input-group form-password-toggle input-group-merge">
                                 <input type="password" class="form-control" id="modalAddPassword" name="modalAddPassword"
                                     placeholder="Password" required />
                                 <div class="input-group-append">
                                     <div class="input-group-text cursor-pointer toggle-password">
                                         <i data-feather="eye"></i>
                                     </div>
                                 </div>
                             </div>
                         </div>
                     </div>
                     {{-- <div class="modal-footer w-100 px-0 py-1 mt-1">
                         <div class="col-12 text-center">
                             <div class="d-flex flex-col justify-content-end">
                                 <button class="modal-btn btn btn-primary" data-dismiss="modal"
                                     type="button">Cancel</button>
                                 <button class="modal-btn btn btn-success ml-1" type="submit">Save</button>
                             </div>
                         </div>
                     </div> --}}

                    <div class="modal-footer mt-1 pb-0 col-xl-12 col-md-12 col-12">
                        <div class="form-group w-100 text-center px-0 mx-0">
                            <div class="d-flex flex-col justify-content-end">
                                <button type="button" class="btn btn-primary mr-1" data-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-success">Submit</button>
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



