 <div class="modal fade text-left modal-success" id="reset_wsModal" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel113" aria-hidden="false">
     <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="myModalLabel113">Reset All Worksheet Records?</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
             <div class="modal-body" style="max-height: 85vh; overflow-y: auto;">
                 <form class="row g-2 needs-validation mt-1" method="POST" action="{{ route('m.ws.reset') }}" novalidate>
                     @csrf
                     <div class="container" style="text-align: justify;">
                         <h6 class="text-center">
                             Are you sure want to <a class="text-warning">reset all of worksheet records?</a> This action <a
                                 class="text-danger">cannot be undone</a>.
                             Please confirm by clicking "<a class="text-danger">RESET</a>" below.
                         </h6>
                     </div>

                     <div class="modal-footer w-100 px-0 py-1">
                         <div class="col-12 text-center">
                             <div class="d-flex flex-col justify-content-end">
                                 <button class="modal-btn btn btn-primary"
                                     id="confirmCancel" data-dismiss="modal"
                                     type="button">Cancel</button>
                                 <button class="modal-btn btn btn-danger ml-1" type="submit"
                                     id="confirmReset">Reset</button>
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
