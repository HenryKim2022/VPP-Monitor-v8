<div class="modal fade text-left modal-success" id="add_moniModal" data-bs-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="myModalLabel113" aria-hidden="false">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel113">Add {{ $project->id_project }} Monitoring Informations
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="false">&times;</span>
                </button>
            </div>

            <div class="modal-body" style="max-height: 85vh; overflow-y: auto;">
                <form action="{{ route('m.mon.add') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    {{-- $idKaryawanForAbsen  --}}
                    <!--  <img src="{ Session::get('data')['qr_code_link'] }}" alt="QR Code"> -->

                    <div class="row g-1">
                        <input type="hidden" class="form-control form-control-merge" id="mon-id_karyawan"
                            name="mon-id_karyawan" placeholder="filled by system" aria-describedby="mon-id_karyawan"
                            tabindex="4" value="{{ $authenticated_user_data->id_karyawan }}"></input>
                        <input type="hidden" class="form-control form-control-merge" id="mon-id_project"
                            name="mon-id_project" placeholder="filled by system" aria-describedby="mon-id_project"
                            tabindex="4" value="{{ $project->id_project }}"></input>

                        <div class="col-xl-12 col-md-12 col-12">
                            <div class="form-group">
                                <label class="form-label" for="mon-category">Category</label>
                                <input class="form-control form-control-merge" id="mon-category" name="mon-category"
                                    placeholder="e.g. Category A" aria-describedby="mon-category"
                                    tabindex="4"></input>
                            </div>
                        </div>
                        <div class="col-xl-6 col-md-6 col-12">
                            <div class="form-group">
                                <label class="form-label" for="mon-qty">Weight%</label>
                                <input class="form-control form-control-merge" id="mon-qty" name="mon-qty"
                                    placeholder="e.g. 8" aria-describedby="mon-qty" tabindex="4" value="{{ old('mon-qty') }}" step="0.01" min="0" max="100"></input>
                            </div>
                        </div>

                        {{-- <div class="col-xl-6 col-md-6 col-12">
                            <div class="form-group">
                                <label for="mon-start_date">Start-Date</label>
                                <input type="date" class="form-control" id="mon-start_date"
                                    name="mon-start_date" placeholder="Date of Prj Started"
                                    value={{ now()->toDateString() }} />
                            </div>
                        </div>
                        <div class="col-xl-6 col-md-6 col-12">
                            <div class="form-group">
                                <label for="mon-end_date">End-Date</label>
                                <input type="date" class="form-control" id="mon-end_date"
                                    name="mon-end_date" placeholder="Date of Prj Ended"
                                    value={{ now()->toDateString() }} />
                            </div>
                        </div> --}}


                        <input type="hidden" class="form-control" id="prj-start_date" name="prj-start_date"
                            placeholder="Date of Prj Started" value="{{ \Carbon\Carbon::parse($project->start_project)->format('Y-m-d') }}" />
                        <input type="hidden" class="form-control" id="prj-deadline_date" name="prj-deadline_date"
                            placeholder="Date of Prj Ended" value="{{ \Carbon\Carbon::parse($project->deadline_project)->format('Y-m-d') }}" />

                        <div class="col-xl-6 col-md-6 col-12 form-group">
                            <label for="mon-start-end-date">Start-Date to End-Date</label>
                            <input type="text" id="mon-start-end-date" name="mon-start-end-date"
                                class="form-control flatpickr-range" placeholder="YYYY-MM-DD to YYYY-MM-DD" />
                        </div>




                        {{-- <div class="col-xl-6 col-md-6 col-12 pr-sm-1 pr-md-1 pr-lg-0 pr-xl-0">
                            <div class="form-group mb-0">
                                <label>Employee</label>
                                <select class="select2 form-control form-control-lg" name="team-karyawan-id" id="team-karyawan-id">
                                    <option value="">Select Employee</option>
                                    @foreach ($employee_list as $employee)
                                        <option value="{{ $employee->id_karyawan }}">
                                            {{ $employee->na_karyawan }}
                                        </option>
                                    @endforeach
                                </select>
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
                    </div>
                </form>
            </div>


            <div class="modal-footer d-none">
                <button type="button" class="btn btn-success" data-dismiss="modal">Okay</button>
            </div>
        </div>
    </div>
</div>
