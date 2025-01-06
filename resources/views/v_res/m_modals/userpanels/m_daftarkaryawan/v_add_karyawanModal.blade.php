<div class="modal fade text-left modal-success" id="add_karyawanModal" tabindex="-1"
    role="dialog" aria-labelledby="myModalLabel113" aria-hidden="false">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel113">Add Employee Informations</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="false">&times;</span>
                </button>
            </div>

            <div class="modal-body" style="max-height: 85vh; overflow-y: auto;">
                <form action="{{ route('m.emp.add') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    {{-- $idKaryawanForAbsen  --}}
                    <!--  <img src="{ Session::get('data')['qr_code_link'] }}" alt="QR Code"> -->

                    <div class="row g-1">
                        {{-- <div class="col-xl-6 col-md-6 col-12 pr-sm-1 pr-md-1 pr-lg-0 pr-xl-0">
                            <div class="form-group mb-0">
                                <label>Employee</label>
                                <select class="select2 form-control form-control-lg" name="role-karyawan-id" id="role-karyawan-id">
                                    <option value="">Select Employee</option>
                                    @foreach ($employee_list as $employee)
                                        <option value="{{ $employee->id_karyawan }}">
                                            {{ $employee->na_karyawan }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div> --}}

                        <div class="col-xl-6 col-md-6 col-12">
                            <div class="form-group">
                                <label class="form-label" for="emp-name">Employee Name</label>
                                <input class="form-control form-control-merge" id="emp-name" name="emp-name"
                                    placeholder="Employee Name" aria-describedby="emp-name" tabindex="1"></input>
                            </div>
                        </div>
                        <div class="col-xl-6 col-md-6 col-12">
                            <div class="form-group">
                                <label>Religion</label>
                                <select class="select2 form-control form-control-lg"
                                    name="emp-religion" id="emp-religion">
                                    @php
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
                                        Konghucu</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-12 col-md-12 col-12">
                            <div class="form-group">
                                <label class="form-label" for="emp-addr">Address</label>
                                <input class="form-control form-control-merge" id="emp-addr" name="emp-addr"
                                    placeholder="Address" aria-describedby="emp-addr" tabindex="2"></input>
                            </div>
                        </div>

                        <div class="col-xl-6 col-md-6 col-12">
                            <div class="form-group">
                                <label class="form-label" for="emp-telp">No. Telp</label>
                                <input class="form-control form-control-merge" id="emp-telp" name="emp-telp"
                                    placeholder="No. Telp" aria-describedby="emp-telp" tabindex="3"></input>
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


                        <div class="col-xl-6 col-md-6 col-12">
                            <div class="form-group">
                                <label class="form-label" for="emp-bday-place">Birth-Place</label>
                                <input class="form-control form-control-merge phone-number-mask" id="emp-bday-place" name="emp-bday-place"
                                    placeholder="Birth Place" aria-describedby="emp-bday-place" tabindex="3"></input>
                            </div>
                        </div>
                        <div class="col-xl-6 col-md-6 col-12">
                            <div class="form-group">
                                <label for="emp-birth-date">Birth-Date</label>
                                <input type="date" class="form-control pickadate-birth-date" id="emp-birth-date"
                                    name="emp-birth-date" placeholder="Date of Birth"
                                    value="1999-01-01" />
                            </div>
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
