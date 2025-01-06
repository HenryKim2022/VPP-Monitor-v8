<!-- ABOUTUS MODALS -->
<div class="modal fade text-left modal-success" id="aboutUsModal" tabindex="-1" role="dialog"
    aria-labelledby="myModalLabel112" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel112">AboutUS</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="false">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{-- <p style="text-align: justify;">
                    {{ $aboutus_data->text_setting }}
                </p> --}}
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-1">
                                    <i class="fas fa-suitcase fa-1x"></i>
                                </div>
                                <div class="col-11">
                                    <h5 class="h5-dark">Current Business Unit</h5>
                                    <p class="mb-0">
                                        <ul class="list-unstyled text-justify">
                                            <li><i data-feather="check-circle" class="mr-1"></i><span class="fs-6">Automation & Control</span></li>
                                            <li><i data-feather="check-circle" class="mr-1"></i><span class="fs-6">Industrial Filtration</span></li>
                                            <li><i data-feather="check-circle" class="mr-1"></i><span class="fs-6">Mechanical & Electrical (Fabrication & Erection)</span></li>
                                        </ul>
                                    </p>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-1">
                                    <i class="fas fa-plus fa-1x"></i>
                                </div>
                                <div class="col-11">
                                    <h5 class="h5-dark">Our Dedication</h5>
                                    <p class="mb-0"><ul class="list-unstyled text-justify">Provide products and services which consistently meet or exceed customer expectations at a fair and competitive price</p>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-1">
                                    <i class="fas fa-check-circle fa-1x"></i>
                                </div>
                                <div class="col-11">
                                    <h5 class="h5-dark">Our Values in Bringing Solution</h5>
                                    <p class="mb-0">
                                        <ul class="list-unstyled text-justify">
                                            <li><i data-feather="check-circle" class="mr-1"></i><span class="fs-6">Trustworthy</span></li>
                                            <li><i data-feather="check-circle" class="mr-1"></i><span class="fs-6">Optimism</span></li>
                                            <li><i data-feather="check-circle" class="mr-1"></i><span class="fs-6">Prudence</span></li>
                                            <li><i data-feather="check-circle" class="mr-1"></i><span class="fs-6">Innovate</span></li>
                                        </ul>
                                    </p>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer d-none">
                <button type="button" class="btn btn-success" data-dismiss="modal">Okay</button>
            </div>
        </div>
    </div>
</div>






<?php
// Parse URL untuk mendapatkan protocol dan host
$parsedUrl = parse_url(config('app.url'));
$protocol = $parsedUrl['scheme']; // http atau https
$host = $parsedUrl['host'];

// Pisahkan host untuk mendapatkan domain utama
$hostParts = explode('.', $host);

// Pastikan array memiliki cukup elemen
if (count($hostParts) >= 2) {
    $mainDomain = $hostParts[count($hostParts) - 2] . '.' . $hostParts[count($hostParts) - 1];
} else {
    $mainDomain = $host; // Jika tidak cukup bagian, gunakan host langsung
}

// Gabungkan protocol dengan domain utama
$fullUrl = $protocol . '://' . $mainDomain;

// echo $fullUrl; // Output: http://vertechperdana.com
?>


<!-- CONTACTUS MODALS -->
<div class="modal fade text-left modal-success" id="contactUsModal" tabindex="-1" role="dialog"
    aria-labelledby="myModalLabel113" aria-hidden="false">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel113">ContactUS</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="false">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-1">
                                    <i class="far fa-building fa-1x"></i>
                                </div>
                                <div class="col-11">
                                    <h5 class="h5-dark">Office Address</h5>
                                    <p class="mb-0"><ul class="list-unstyled text-justify">
                                        BIZHUB Serpong (Integrated Commercial Estate) Blok GB No.27 Jl. Serpong Raya, Gunung Sindur 16340 Bogor - Jawa Barat - Indonesia
                                    </p>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-1">
                                    <i class="far fa-envelope fa-1x"></i>
                                </div>
                                <div class="col-11">
                                    <h5 class="h5-dark">Email Address</h5>
                                    <p class="mb-0"><ul class="list-unstyled text-justify">
                                        info@vertechperdana.com
                                    </p>
                                </div>

                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-1">
                                    <i class="fas fa-phone fa-1x"></i>
                                </div>
                                <div class="col-11">
                                    <h5 class="h5-dark">Phone Number</h5>
                                    <p class="mb-0"><ul class="list-unstyled text-justify">
                                        +62 21 29 66666 2
                                    </p>
                                </div>

                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-1">
                                    <i class="fad fa-globe fa-1x"></i>
                                </div>
                                <div class="col-11">
                                    <h5 class="h5-dark">Official Main Website</h5>
                                    <p class="mb-0">
                                        <ul class="list-unstyled text-justify">
                                            <li>
                                                <a href="{{ $fullUrl }}" target="_blank">PT. Vertech Perdana</a>
                                            </li>
                                        </ul>
                                    </p>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer d-none">
                <button type="button" class="btn btn-success" data-dismiss="modal">Okay</button>
            </div>
        </div>
    </div>
</div>
