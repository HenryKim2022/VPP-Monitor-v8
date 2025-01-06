 <!-- Floating Button -->
 <div class="left-floating-container">
     <div class="d-flex flex-row justify-content-between align-items-center">

         @if (auth()->user()->type == 'Superuser' || auth()->user()->type == 'Engineer')
         @php
         $ws_status = $loadDataWS->status_ws;
         $blinkClass = $ws_status == 'OPEN' ? 'blink-text' : '';
         @endphp
         @if ($ws_status == 'OPEN')
         <!--
                                <div class="d-flex gap-3">
                                    {{-- <form class="me-1 needs-validation" method="POST" action="{{ route('m.ws.status.lock') }}"
                            id="lock_wsFORM" novalidate>
                            @csrf
                            <input type="hidden" id="lock-ws_id" name="lock-ws_id" value="{{ $loadDataWS->id_ws }}" />
                            <button id="confirmSave"
                                class="btn bg-primary auth-role-lock-text border-0 px-1 {{ $blinkClass }}">
                                <a class="cursor-default text-center"><i class="fas fa-user-lock fa-xs"></i></a>
                            </button>

                        </form> --}}

                                    {{-- @if ($modalData['modal_add'])
                            <div class="nav-item" onclick="openModal('{{ $modalData['modal_add'] }}')">
                                <button
                                    class="btn btn-success px-1 dropdown-item d-flex align-items-center border border-success add-new-record"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Add New Record!">
                                    <span><i class="fas fa-plus-circle fa-xs text-white"></i></span>
                                </button>
                            </div>
                        @endif --}}
                                </div>-->
         <div class="d-flex gap-3">
             @if ($reset_btn)
             <div class="nav-item" onclick="openModal('{{ $modalData['modal_reset'] }}')">
                 <button
                     class="btn btn-danger px-1 dropdown-item d-flex align-items-center border border-warning reset-all-record"
                     data-bs-toggle="tooltip" data-bs-placement="top" title="Reset all Records!">
                     <span><i class="fas fa-redo fa-xs text-white" data-feather="refresh-cw"></i></span>

                 </button>
             </div>
             @endif
         </div>
         @else
         {{-- <div class="d-flex gap-3"></div> --}}
         <div class="d-flex gap-3">

             <form class="needs-validation" method="POST" action="{{ route('m.task.printtask') }}"
                 id="print_wsFORM" novalidate>
                 @csrf
                 <input type="hidden" id="print-ws_id" name="print-ws_id"
                     value="{{ $loadDataWS->id_ws }}" />
                 <button id="confirmSave" class="btn bg-primary print-text border-0 px-1">
                     <span class="mt-0 mb-0 cursor-pointer text-center"><i
                             class="fas fa-print fa-xs"></i></span>
                 </button>
             </form>
         </div>
         @endif
         @else
         @if ($ws_status != 'OPEN')
         <div class="d-flex gap-3">
             <form class="needs-validation" method="POST" action="{{ route('m.task.printtask') }}"
                 id="print_wsFORM" novalidate>
                 @csrf
                 <input type="hidden" id="print-ws_id" name="print-ws_id"
                     value="{{ $loadDataWS->id_ws }}" />
                 <button id="confirmSave" class="btn bg-primary print-text border-0 px-1">
                     <span class="mt-0 mb-0 cursor-pointer text-center"><i
                             class="fas fa-print fa-xs"></i></span>
                 </button>
             </form>
         </div>
         @endif
         @endif


         <!-- OTHER ITEM EXAMPLE -->
         {{-- <button class="btn bg-primary btn-icon auth-role-lock-text {{ $blinkClass }}" type="button">
         <i class="fas fa-engine-warning fa-xs"></i>
         </button> --}}

     </div>
 </div>



 <!-- FLOATING BUTTTON: SIMPLE -->
 <!-- Floating Button -->
 <div class="left-floating-container">
     <div class="d-flex flex-row justify-content-between align-items-center">

         @if (auth()->user()->type == 'Superuser')
         <div class="d-flex gap-3">
             @if ($modalData['modal_add'])
             <div class="nav-item">
                 <button onclick="openModal('{{ $modalData['modal_add'] }}')"
                     class="btn btn-success px-1 dropdown-item d-flex align-items-center border border-success add-new-record"
                     data-bs-toggle="tooltip" data-bs-placement="top" title="Add New Record!">
                     <span><i class="fas fa-plus-circle fa-xs text-white"></i></span>
                 </button>
             </div>
             @endif
         </div>
         <div class="d-flex gap-3">
             @if ($reset_btn)
             <div class="nav-item">
                 <button onclick="openModal('{{ $modalData['modal_reset'] }}')"
                     class="btn btn-danger px-1 dropdown-item d-flex align-items-center border border-warning reset-all-record"
                     data-bs-toggle="tooltip" data-bs-placement="top" title="Reset all Records!">
                     <span><i class="fas fa-redo fa-xs text-white"
                             data-feather="refresh-cw"></i></span>

                 </button>
             </div>
             @endif
         </div>
         @endif
         <!-- OTHER ITEM EXAMPLE -->
         {{-- <button class="btn bg-primary btn-icon auth-role-lock-text {{ $blinkClass }}" type="button">
         <i class="fas fa-engine-warning fa-xs"></i>
         </button> --}}
     </div>
 </div>







 <!-- TABLE FOOTER -->
 <tfoot>
     <tr>
         <td colspan="6" class="px-1">
             <strong>
                 REMARK (CATATAN AKHIR)
             </strong>
         </td>
     </tr>
     <tr>
         <td colspan="6" rowspan="1" class="px-1">
             <textarea class="w-100" rows="3"></textarea>
         </td>
     </tr>
     <tr>
         <td colspan="4" rowspan="8" class="px-1">

             <div class="d-flex flex-col justify-content-around">
                 <div class="d-flex flex-column align-items-start">
                     <span>
                         <strong>
                             EXECUTED BY, (DIKERJAKAN OLEH)
                         </strong>
                     </span>
                     <div style="height: 8em;"></div> <!-- Empty div for spacing -->
                     <span class="justify-content-center">
                         <a class="w-100 align-text-bottom">
                             {{ $loadDataWS->karyawan->na_karyawan }}
                         </a>
                     </span>
                     <span class="underline-text">
                         <strong>
                             PT. VERTECH PERDANA
                         </strong>
                     </span>
                 </div>
                 <div class="d-flex flex-column align-items-start">
                     <span>
                         <strong>
                             ACKNOWLEDGED BY, (DIKETAHUI OLEH)
                         </strong>
                     </span>
                     <div style="height: 8em;"></div> <!-- Empty div for spacing -->
                     <span class="justify-content-center">
                         <a class="w-100 align-text-bottom">
                             {{ $loadDataWS->project->client->na_client }}
                         </a>
                     </span>
                     <span class="underline-text">
                         <strong>
                             ( CLIENT )
                             ..................................................................
                         </strong>
                     </span>
                 </div>
             </div>
         </td>
         <td colspan="2" class="px-1 text-center"><strong>Time Stamp</strong></td>
     </tr>
     <tr>
         <td colspan="2" class="px-1">
             <strong>
                 Start Date:
             </strong>
             <br>
             @php

             $workingDate = $loadDataWS->working_date_ws;
             // Set the locale to Indonesian/ usa
             \Carbon\Carbon::setLocale('en');
             $date = \Carbon\Carbon::parse($workingDate);
             $formattedDate = $date->isoFormat('dddd, DD MMMM YYYY [at] hh:mm:ss A');
             echo $formattedDate; // This will output the formatted date
             @endphp
         </td>
         {{-- <td class="border-0"></td> --}}
     </tr>
     <tr>
         <td colspan="2" class="px-1">
             <strong>
                 Closed Date:
             </strong>
             <br>
             @if ($loadDataWS->status_ws == 'OPEN')
             -
             @else
             @php

             $closedDate = $loadDataWS->closed_at_ws;
             // Set the locale to Indonesian/ usa
             \Carbon\Carbon::setLocale('en');
             $date = \Carbon\Carbon::parse($closedDate);
             $formattedDate = $date->isoFormat('dddd, DD MMMM YYYY [at] hh:mm:ss A');
             echo $formattedDate; // This will output the formatted date
             @endphp
             @endif

         </td>
         {{-- <td class="border-0"></td> --}}
     </tr>
     <tr>
         <td colspan="2" class="px-1 text-center align-middle"><strong>Status</strong></td>
     </tr>
     <tr>
         <td colspan="2" class="px-1 text-center">
             <strong>
                 <h2 class="mb-0">
                     @if ($loadDataWS->status_ws == 'OPEN')
                     OPEN
                     @else
                     CLOSED
                     @endif
                 </h2>
             </strong>
         </td>
     </tr>


 </tfoot>
