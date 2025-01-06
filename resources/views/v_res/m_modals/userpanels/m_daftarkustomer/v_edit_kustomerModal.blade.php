 <div class="modal fade text-left modal-success" id="edit_kustomerModal" data-bs-backdrop="static" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel113" aria-hidden="false">
     <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="myModalLabel113">Edit Client Informations</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
             <div class="modal-body" style="max-height: 85vh; overflow-y: auto;">
                 <form class="row g-2 needs-validation mt-1" method="POST" action="{{ route('m.cli.edit') }}" id="edit_kustomerModalFORM" enctype="multipart/form-data"
                     novalidate>
                     @csrf
                     <input type="hidden" id="edit_cli_id" name="edit_cli_id" value="" />
                     <div class="col-xl-12 col-md-12 col-12">
                        <div class="form-group">
                            <label class="form-label" for="edit-cli-name">Client Name</label>
                            <input class="form-control form-control-merge" id="edit-cli-name" name="edit-cli-name"
                                placeholder="Client Name" aria-describedby="edit-cli-name" tabindex="1"></input>
                        </div>
                    </div>
                    <div class="col-xl-12 col-md-12 col-12">
                        <div class="form-group">
                            <label class="form-label" for="edit-cli-addr">Address</label>
                            <input class="form-control form-control-merge" id="edit-cli-addr" name="edit-cli-addr"
                                placeholder="Address" aria-describedby="edit-cli-addr" tabindex="2"></input>
                        </div>
                    </div>

                    <div class="col-xl-6 col-md-6 col-12">
                        <div class="form-group">
                            <label class="form-label" for="edit-cli-telp">No. Telp</label>
                            <input class="form-control form-control-merge" id="edit-cli-telp" name="edit-cli-telp"
                                placeholder="No. Telp" aria-describedby="edit-cli-telp" tabindex="3"></input>
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


