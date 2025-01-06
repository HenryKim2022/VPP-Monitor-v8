 <div class="modal fade text-left modal-success" id="edit_karyawanModal" data-bs-backdrop="static" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel113" aria-hidden="false">
     <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="myModalLabel113">Edit Employee Informations</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
             <div class="modal-body" style="max-height: 85vh; overflow-y: auto;">
                 <form class="row g-2 needs-validation mt-1" method="POST" action="{{ route('m.emp.edit') }}" id="edit_karyawanModalFORM" enctype="multipart/form-data"
                     novalidate>
                     @csrf
                     <input type="hidden" id="edit_karyawan_id" name="edit_karyawan_id" value="" />
                     <div class="col-xl-6 col-md-6 col-12">
                        <div class="form-group">
                            <label class="form-label" for="edit-emp-name">Employee Name</label>
                            <input class="form-control form-control-merge" id="edit-emp-name" name="edit-emp-name"
                                placeholder="Employee Name" aria-describedby="edit-emp-name" tabindex="1"></input>
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-6 col-12">
                        <div class="form-group">
                            <label>Religion</label>
                            <select class="select2 form-control form-control-lg"
                                name="edit-emp-religion" id="edit-emp-religion">
                                {{-- @php
                                    $religion = $authenticated_user_data->agama_karyawan;
                                @endphp
                                <option value=""
                                    {{ !$religion ? 'selected' : '' }}>
                                    Select religion</option>
                                <option value="Islam"
                                    {{ $religion == 'Islam' ? 'selected' : '' }}>
                                    Islam</option>
                                <option value="Kristen"
                                    {{ $religion == 'Kristen' ? 'selected' : '' }}>
                                    Kristen</option>
                                <option value="Hindu"
                                    {{ $religion == 'Hindu' ? 'selected' : '' }}>
                                    Hindu</option>
                                <option value="Buddha"
                                    {{ $religion == 'Buddha' ? 'selected' : '' }}>
                                    Buddha</option>
                                <option value="Konghucu"
                                    {{ $religion == 'Konghucu' ? 'selected' : '' }}>
                                    Konghucu</option> --}}
                            </select>
                        </div>
                    </div>
                    <div class="col-xl-12 col-md-12 col-12">
                        <div class="form-group">
                            <label class="form-label" for="edit-emp-addr">Address</label>
                            <input class="form-control form-control-merge" id="edit-emp-addr" name="edit-emp-addr"
                                placeholder="Address" aria-describedby="edit-emp-addr" tabindex="2"></input>
                        </div>
                    </div>

                    <div class="col-xl-6 col-md-6 col-12">
                        <div class="form-group">
                            <label class="form-label" for="edit-emp-telp">No. Telp</label>
                            <input class="form-control form-control-merge" id="edit-emp-telp" name="edit-emp-telp"
                                placeholder="No. Telp" aria-describedby="edit-emp-telp" tabindex="3"></input>
                        </div>
                    </div>

                    <div class="col-xl-6 col-md-6 col-12">
                        <div class="media">
                            <a href="javascript:void(0);" class="mr-25 p-1 rounded">
                                <img
                                    src="{{ asset('public/assets/defaults/avatar_default.png') }}"
                                    id="avatar-upload-img-2" class="rounded hover-qr-image" alt="profile image"
                                    height="80" width="80" />
                            </a>
                            <!-- upload and reset button -->
                            <div class="media-body mt-75 ml-1">
                                <label for="edit-avatar-upload"
                                    class="btn btn-sm btn-primary mb-75 mr-75">Browse</label>
                                <input type="file" id="edit-avatar-upload" name="edit-avatar-upload" hidden
                                    accept="image/png, image/jpeg, image/*" />
                                <button
                                    class="btn btn-sm acc-avatar-reset-edit btn-outline-secondary mb-75">Reset</button>
                                <p>Allowed JPG, GIF or PNG. Max size of 5MB</p>
                            </div>
                            <!--/ upload and reset button -->
                        </div>
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                const uploadedAvatar = document.getElementById('avatar-upload-img-2');
                                const uploadInput = document.getElementById('edit-avatar-upload');
                                const resetButton = document.querySelector('.acc-avatar-reset-edit');

                                // Function to handle image upload
                                uploadInput.addEventListener('change', function() {
                                    const file = uploadInput.files[0];
                                    if (file && file.type.startsWith('image/')) {
                                        const reader = new FileReader();
                                        reader.onload = function(e) {
                                            uploadedAvatar.src = e.target.result;
                                        };
                                        reader.readAsDataURL(file);
                                    }
                                });

                                // Reset button functionality
                                resetButton.addEventListener('click', function(e) {
                                    e.preventDefault();
                                    // Reset the image to the default avatar
                                    uploadedAvatar.src = '{{ asset('public/assets/defaults/avatar_default.png') }}';
                                    // Clear the file input
                                    uploadInput.value = '';
                                });
                            });
                        </script>
                    </div>

                    <div class="col-xl-6 col-md-6 col-12">
                        <div class="form-group">
                            <label class="form-label" for="edit-emp-bday-place">Birth-Place</label>
                            <input class="form-control form-control-merge phone-number-mask" id="edit-emp-bday-place" name="edit-emp-bday-place"
                                placeholder="Birth Place" aria-describedby="edit-emp-bday-place" tabindex="3"></input>
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-6 col-12">
                        <div class="form-group">
                            <label for="edit-emp-birth-date">Birth-Date</label>
                            <input type="date" class="form-control" id="edit-emp-birth-date"
                                name="edit-emp-birth-date pickadate-birth-date" placeholder="Date of Birth"
                                value="1999-01-01" />
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


