
 <div class="modal fade text-left modal-success" id="add_absenModal" data-bs-backdrop="static" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel113" aria-hidden="false">
     <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="myModalLabel113">Add Check-in/out Informations</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>

             <div class="modal-body" style="max-height: 85vh; overflow-y: auto;">
                <form action="{{ route('m.absen.add') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    {{-- $idKaryawanForAbsen  --}}
                    <!--  <img src="{ Session::get('data')['qr_code_link'] }}" alt="QR Code"> -->

                    <div class="row g-1">
                        <div class="col-xl-6 col-md-6 col-12 pr-0">
                            <div class="form-group mb-0">
                                <label>Employee</label>
                                <select class="select2 form-control form-control-lg" name="absen-in-out-karyawan-id" id="absen-in-out-karyawan-id">
                                    <option value="">Select Employee</option>
                                    @foreach($employee_list as $employee)
                                        <option value="{{ $employee->id_karyawan }}">
                                            {{ $employee->na_karyawan }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-3 col-12 pr-0">
                            <div class="form-group">
                                <label>Attendance Status</label>
                                <select class="select2 form-control form-control-lg" name="attendance-status">
                                    <option value="" selected disabled>Select status</option>
                                    <option value="1">absent</option>
                                    <option value="2">present</option>
                                    <option value="3">permit</option>
                                    <option value="4">unwell</option>
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

                        <div class="col-xl-12 col-md-12 col-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Submit</button>
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



