<div class="modal fade text-left modal-success" id="add_kustomerModal" tabindex="-1"
    role="dialog" aria-labelledby="myModalLabel113" aria-hidden="false">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel113">Add Client Informations</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="false">&times;</span>
                </button>
            </div>

            <div class="modal-body" style="max-height: 85vh; overflow-y: auto;">
                <form action="{{ route('m.cli.add') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-1">
                        <div class="col-xl-12 col-md-12 col-12">
                            <div class="form-group">
                                <label class="form-label" for="cli-name">Client Name</label>
                                <input class="form-control form-control-merge" id="cli-name" name="cli-name"
                                value="{{ old('cli-name', $inputs['cli-name'] ?? '') }}"
                                    placeholder="Client Name" aria-describedby="cli-name" tabindex="1"></input>
                            </div>
                        </div>
                        <div class="col-xl-12 col-md-12 col-12">
                            <div class="form-group">
                                <label class="form-label" for="cli-addr">Address</label>
                                <input class="form-control form-control-merge" id="cli-addr" name="cli-addr"
                                value="{{ old('cli-addr', $inputs['cli-addr'] ?? '') }}"
                                    placeholder="Address" aria-describedby="cli-addr" tabindex="2"></input>
                            </div>
                        </div>

                        <div class="col-xl-6 col-md-6 col-12">
                            <div class="form-group">
                                <label class="form-label" for="cli-telp">No. Telp</label>
                                <input class="form-control form-control-merge" id="cli-telp" name="cli-telp"
                                value="{{ old('cli-telp', $inputs['cli-telp'] ?? '') }}"
                                    placeholder="No. Telp" aria-describedby="cli-telp" tabindex="3"></input>
                            </div>
                        </div>

                        <div class="col-xl-6 col-md-6 col-12">
                            <div class="media">
                                <a href="javascript:void(0);" class="mr-25 p-1 rounded">
                                    <img
                                        src="{{ asset('public/assets/defaults/avatar_default.png') }}"
                                        id="avatar-upload-img" class="rounded hover-qr-image" alt="profile image"
                                        height="80" width="80" />
                                </a>
                                <!-- upload and reset button -->
                                <div class="media-body mt-75 ml-1">
                                    <label for="avatar-upload"
                                        class="btn btn-sm btn-primary mb-75 mr-75">Browse</label>
                                    <input type="file" id="avatar-upload" name="avatar-upload" hidden
                                        accept="image/png, image/jpeg, image/*" />
                                    <button
                                        class="btn btn-sm acc-avatar-reset btn-outline-secondary mb-75">Reset</button>
                                    <p>Allowed JPG, GIF or PNG. Max size of 5MB</p>
                                </div>
                                <!--/ upload and reset button -->
                            </div>
                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    const uploadedAvatar = document.getElementById('avatar-upload-img');
                                    const uploadInput = document.getElementById('avatar-upload');
                                    const resetButton = document.querySelector('.acc-avatar-reset');

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
                            <!--/ header media -->
                        </div>

                        <div class="modal-footer mt-1 pb-0 col-xl-12 col-md-12 col-12">
                            <div class="form-group w-100 text-center px-0 mx-0">
                                <div class="d-flex flex-col justify-content-end">
                                    <button type="button" class="btn btn-primary mr-1" data-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-success">Submit</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>
            </div>



        </div>
    </div>
</div>
