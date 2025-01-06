<div class="modal fade text-left modal-success" id="add_projectModal" data-bs-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="myModalLabel113">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel113">Add Project Informations</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body" style="max-height: 85vh; overflow-y: auto;">
                <form action="{{ route('m.projects.add') }}" method="POST" enctype="multipart/form-data" id="add_projectModalFORM">
                    @csrf
                    {{-- $idKaryawanForAbsen  --}}
                    <!--  <img src="{ Session::get('data')['qr_code_link'] }}" alt="QR Code"> -->

                    <div class="row g-1">
                        <div class="col-xl-12 col-md-12 col-12">
                            <div class="form-group">
                                <label class="form-label" for="project-id">Project-ID</label>
                                <input class="form-control form-control-merge" id="project-id" name="project-id"
                                    placeholder="e.g. PRJ-24-00001" aria-describedby="project-id"
                                    tabindex="4"></input>
                            </div>
                        </div>
                        <div class="col-xl-12 col-md-12 col-12">
                            <div class="form-group">
                                <label class="form-label" for="project-name">ProjectName</label>
                                <input class="form-control form-control-merge" id="project-name" name="project-name"
                                    placeholder="e.g. CONTROL UNIT CU310 - 2DP TYPE 6SL3040..."
                                    aria-describedby="project-name" tabindex="4"></input>
                            </div>
                        </div>

                        <div class="col-xl-12 col-md-12 col-12">
                            <div class="form-group mb-0">
                                <label>Customer</label>
                                <select class="select2 form-control form-control-lg" name="client-id" id="client-id">
                                    ${options}
                                </select>
                            </div>
                        </div>


                        @if ($authUserType == 'Superuser')
                            <div class="col-xl-12 col-md-12 col-12 mt-1">
                                <div class="form-group mb-0">
                                    <label>Project Co</label>
                                    <select class="co-select2-assign form-control" multiple name="co-select2-assign[]" id="co-select2-assign">
                                        {{-- <option value="">Select Co</option> --}}
                                        ${options}
                                    </select>
                                </div>
                            </div>
                        @else
                            <div class="col-xl-12 col-md-12 col-12 mt-1">
                                <div class="form-group mb-0">
                                    <label>Project Co</label>
                                    <select class="co-select2-assign form-control" multiple name="co-select2-assign[]" id="co-select2-assign">
                                        {{-- <option value="">Select Co</option> --}}
                                        ${options}
                                    </select>
                                </div>
                            </div>
                        @endif

{{--
                        <pre style="color: white">{{ print_r($team_list->toArray(), true) }}</pre>
                        <br> --}}

                        <div class="col-xl-6 col-md-6 col-12 form-group mt-1">
                            <div class="form-group mb-0">
                                <label>Team</label>
                                <select class="engteam-select2-assign form-control" multiple name="engteam-select2-assign[]" id="engteam-select2-assign">
                                    ${options}
                                </select>

                            </div>
                        </div>


                        <div class="col-xl-6 col-md-6 col-12 form-group mt-1">
                            <label for="start-deadline">Start - Deadline</label>
                            <input type="text" id="start-deadline" name="start-deadline"
                                class="form-control flatpickr-range" placeholder="YYYY-MM-DD to YYYY-MM-DD" />
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


            <div class="modal-footer d-none">
                <button type="button" class="btn btn-success" data-dismiss="modal">Okay</button>
            </div>
        </div>
    </div>
</div>


{{--
<script>
    document.addEventListener('DOMContentLoaded', function() {
        $('#engteam-select2-assign').select2({
            placeholder: "Assign Team",
            allowClear: false,
            closeOnSelect: true
        });
        $('#co-select2-assign').select2({
            placeholder: "Assign Co",
            allowClear: false,
            closeOnSelect: true
        });
    });
</script> --}}
