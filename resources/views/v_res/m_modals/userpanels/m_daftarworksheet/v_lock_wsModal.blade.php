 <div class="modal fade text-left modal-success" id="lock_wsModal" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel113" aria-hidden="false">
     <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="myModalLabel113">Lock Worksheets?</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
             <div class="modal-body" style="max-height: 85vh; overflow-y: auto;">
                 <form class="row g-2 needs-validation mt-1" method="POST" action="{{ route('m.ws.status.lock') }}"
                     id="lock_wsModalFORM" novalidate>
                     @csrf
                     <div class="container" style="text-align: justify;">
                         <h6 class="text-center info-text h6-dark">
                             {{-- Are you sure want to <a class="text-warning">Lock the worksheet for PRJ- with working date *{{ $loadDataWS->working_date_ws() }} that executed by {{ $loadDataWS->karyawan->na_karyawan }}?</a> This action <a
                                 class="text-danger">cannot be undone</a>.
                             Please confirm by clicking "<a class="text-danger">LOCK</a>" below. --}}
                         </h6>
                     </div>

                     @php
                         $currentTime = now();
                         $formattedTime = $currentTime->format('H:i:s');
                     @endphp
                     <div class="col-xl-12 col-md-12 col-12">
                         <div class="form-group">
                             <label for="lock-ws_finish_time">Finish-Time</label>
                             <input type="time" id="lock-ws_finish_time" name="lock-ws_finish_time"
                                 class="form-control text-left flatpickr-time" value="{{ $formattedTime }}"
                                 placeholder="HH:MM:SS AM/PM" />
                         </div>
                     </div>

                     <input type="hidden" id="lock-ws_id" name="lock-ws_id" value="" />
                     <input type="hidden" id="lock-project_id" name="lock-project_id" value="" />
                     <div class="modal-footer w-100 px-0 py-1">
                         <div class="col-12 text-center">
                             <div class="d-flex flex-col justify-content-end">
                                 <button class="modal-btn btn btn-primary" id="confirmCancel" data-dismiss="modal"
                                     type="button">Cancel</button>
                                 <button class="modal-btn btn btn-danger ml-1" {{-- type="submit" --}}
                                     id="confirmLock">Lock</button>
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
