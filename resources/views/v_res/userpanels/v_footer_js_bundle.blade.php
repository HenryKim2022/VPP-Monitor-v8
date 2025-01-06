<!-- BEGIN: Vendor JS-->
<script src="{{ asset('public/theme/vuexy/app-assets/vendors/js/vendors.min.js') }}"></script>
<!-- BEGIN Vendor JS-->

<!-- BEGIN: Page Vendor JS -->
{{-- <script src="{{ asset('public/theme/vuexy/app-assets/vendors/js/charts/apexcharts.min.js') }}"></script> --}}
<script src="{{ asset('public/theme/vuexy/app-assets/vendors/js/extensions/toastr.min.js') }}"></script>
<script src="{{ asset('public/theme/vuexy/app-assets/vendors/js/forms/select/select2.full.min.js') }}"></script>
{{-- <script src="{{ asset('public/theme/vuexy/app-assets/vendors/js/extensions/jstree.min.js') }}"></script> --}}
<script src="{{ asset('public/assets/body.scroll.lock/lib/bodyScrollLock.js') }}"></script>
<script src="{{ asset('public/theme/vuexy/app-assets/vendors/js/extensions/dragula.min.js') }}"></script>
<!-- END: Page Vendor JS-->

<!-- BEGIN: Theme JS-->
<script src="{{ asset('public/theme/vuexy/app-assets/js/core/app-menu.js') }}"></script>
<script src="{{ asset('public/theme/vuexy/app-assets/js/core/app.js') }}"></script>
{{-- <script src="{{ asset('public/theme/vuexy/app-assets/js/core/cs-search.js') }}"></script> --}}
<script src="{{ asset('public/assets/js.tree@3.2.1/jstree.min.js') }}"></script>

<!-- END: Theme JS-->

<!-- BEGIN: CustomSearch JS-->
<script src="{{ asset('public/assets/cs.search/cs-search.js') }}"></script>
<!-- END: CustomSearc JS-->

<!-- BEGIN: Page JS-->
<script src="{{ asset('public/theme/vuexy/app-assets/js/scripts/components/components-modals.js') }}"></script>
<!-- END: Page JS-->


<!-- BEGIN: DataTables Page Vendor JS-->
<script src="{{ asset('public/theme/vuexy/app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js') }}">
</script>
<script src="{{ asset('public/theme/vuexy/app-assets/vendors/js/tables/datatable/datatables.bootstrap4.min.js') }}">
</script>
<script src="{{ asset('public/theme/vuexy/app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js') }}">
</script>
<script src="{{ asset('public/theme/vuexy/app-assets/vendors/js/tables/datatable/responsive.bootstrap4.js') }}">
</script>
<script src="{{ asset('public/theme/vuexy/app-assets/vendors/js/tables/datatable/datatables.checkboxes.min.js') }}">
</script>
<script src="{{ asset('public/theme/vuexy/app-assets/vendors/js/tables/datatable/datatables.buttons.min.js') }}">
</script>
<script src="{{ asset('public/theme/vuexy/app-assets/vendors/js/tables/datatable/jszip.min.js') }}"></script>
<script src="{{ asset('public/theme/vuexy/app-assets/vendors/js/tables/datatable/pdfmake.min.js') }}"></script>
<script src="{{ asset('public/theme/vuexy/app-assets/vendors/js/tables/datatable/vfs_fonts.js') }}"></script>
<script src="{{ asset('public/theme/vuexy/app-assets/vendors/js/tables/datatable/buttons.html5.min.js') }}"></script>
<script src="{{ asset('public/theme/vuexy/app-assets/vendors/js/tables/datatable/buttons.print.min.js') }}"></script>
<script src="{{ asset('public/theme/vuexy/app-assets/vendors/js/tables/datatable/dataTables.rowGroup.min.js') }}">
</script>
<!-- Include Buttons ColVis -->
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.colVis.min.js"></script>
{{-- <script src="https://cdn.datatables.net/buttons/3.1.2/js/buttons.colVis.min.js"></script> --}}

<script src="{{ asset('public/theme/vuexy/app-assets/vendors/js/pickers/pickadate/picker.js') }}"></script>
<script src="{{ asset('public/theme/vuexy/app-assets/vendors/js/pickers/pickadate/picker.date.js') }}"></script>
<script src="{{ asset('public/theme/vuexy/app-assets/vendors/js/pickers/pickadate/picker.time.js') }}"></script>
<script src="{{ asset('public/theme/vuexy/app-assets/vendors/js/pickers/pickadate/legacy.js') }}"></script>
<script src="{{ asset('public/theme/vuexy/app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js') }}"></script>
<!-- END: DataTables Page Vendor JS-->





<script>
    $(document).ready(function() {
        if (feather) {
            feather.replace({
                width: 14,
                height: 14
            });
        }
    });
</script>

<script>
    $(document).ready(function() {
        if ($('.select2').length > 0) { // Check if there are elements with the class 'select2' present
            $('.select2').select2(); // Initialize Select2
        }
    });
</script>


{{-- <script>
    document.addEventListener("DOMContentLoaded", function() {
        var flatpickrTime = flatpickr('.flatpickr-time', {
            enableTime: true,
            noCalendar: true
        });
    });
</script> --}}


<script>
    $(document).ready(function() {
        flatpickr(".flatpickr-range", {
            mode: "range"
        });
    });
</script>

{{--
<script>
    document.addEventListener('DOMContentLoaded', function() {
        flatpickr(".pickadate-birth-date-user", {
            enableTime: false,
            dateFormat: "Y-m-d", // Format for the date and time
            altInput: true,
            altFormat: "j F, Y", // Format for the alternative input display
            allowInput: true, // Allow typing in the input field
            minDate: "1900-01-01", // Set minimum date
            maxDate: "8000-12-31" // Set maximum date
        });
    });
</script> --}}

{{--
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Select all modal elements with a specific class
        var modals = document.querySelectorAll('.modal'); // Adjust this selector to match your modal class

        // Loop through each modal to initialize the date picker
        modals.forEach(function(modal) {
            // Ensure the date picker input exists within the current modal
            var datePickerInput = modal.querySelector(".pickadate-months-year");
            if (datePickerInput) {
                flatpickr(datePickerInput, {
                    enableTime: true,
                    dateFormat: "Y-m-d H:i:S", // Correct date format
                    altInput: true,
                    altFormat: "F j, Y h:i K", // Format for the alternative input display
                    allowInput: true, // Allow typing in the input field
                    minDate: "1900-01-01", // Set minimum date
                    maxDate: "8000-12-31", // Set maximum date
                    onOpen: function(selectedDates, dateStr, instance) {
                        modal.removeAttribute(
                            'tabindex'); // Remove tabindex when the modal opens
                    },
                    onClose: function(selectedDates, dateStr, instance) {
                        modal.setAttribute('tabindex', -
                            1); // Set tabindex when the modal closes
                    }
                });
            } else {
                // console.error("Date picker input not found in modal:", modal);
            }

            // var bdayDatePickerInput = modal.querySelector(".pickadate-birth-date");
            // if (bdayDatePickerInput) {
            //     flatpickr(bdayDatePickerInput, {
            //         enableTime: false,
            //         dateFormat: "Y-m-d", // Format for the date and time
            //         altInput: true,
            //         altFormat: "j F, Y", // Format for the alternative input display
            //         allowInput: true, // Allow typing in the input field
            //         minDate: "1900-01-01", // Set minimum date
            //         maxDate: "8000-12-31" // Set maximum date
            //     });

            // }

        });
    });
</script> --}}

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Check if flatpickr is defined
        if (typeof flatpickr !== 'undefined') {
            // Select all time picker inputs
            var timePickerInputs = document.querySelectorAll('.flatpickr-time');

            // Initialize Flatpickr for each time picker input
            timePickerInputs.forEach(function(timePickerInput) {
                flatpickr(timePickerInput, {
                    enableTime: true, // Enable time selection
                    noCalendar: true, // Disable calendar view
                    dateFormat: "H:i:S", // Format for the input value (24-hour format)
                    altInput: true, // Use an alternative input for display
                    altFormat: "h:i:s K", // Format for the alternative input display (12-hour format with AM/PM)
                    allowInput: true, // Allow typing in the input field
                    enableSeconds: true, // Enable seconds selection
                    time_24hr: false, // Set to false to use 12-hour format
                    onOpen: function(selectedDates, dateStr, instance) {
                        // Actions to perform when the time picker opens
                    },
                    onClose: function(selectedDates, dateStr, instance) {
                        // Actions to perform when the time picker closes
                    }
                });
            });
        } else {
            // console.warn('Flatpickr is not loaded. Please ensure the Flatpickr library is included before this script.');
        }
    });
</script>





<script>
    document.addEventListener('DOMContentLoaded', function() {
        const hoverImages = document.querySelectorAll('.hover-image');
        const imagePopup = document.getElementById('image-popup');
        const popupImage = imagePopup.querySelector('img');
        const closeBtn = imagePopup.querySelector('.close-btn');

        hoverImages.forEach(function(image) {
            image.addEventListener('click', function() {
                const largeImageSrc = this.getAttribute('src');
                popupImage.src = largeImageSrc;
                imagePopup.style.display = 'block';
                centerPopup();
            });
        });

        closeBtn.addEventListener('click', function() {
            imagePopup.style.display = 'none';
        });

        var modalViewImagesPreview = document.getElementById('swiperImagesContainerView');
        if (modalViewImagesPreview) {
            document.getElementById('swiperImagesContainerView').addEventListener('click', function(event) {
                // var modalImagesPreview = document.getElementById('swiperImagesContainerView');
                // var modalViewImage = new bootstrap.Modal(document.getElementById('modalViewLogoPopUp'));
                var modalViewZoomImageContent = document.getElementById('modalViewZoomImageContent');

                var clickedImage = event.target.closest('img');
                if (clickedImage) {
                    const largeImageSrc = clickedImage.getAttribute('src');
                    // var clickedImageUrl = clickedImage.src;
                    popupImage.src = largeImageSrc;
                    imagePopup.style.display = 'block';
                    centerPopup();
                }
            });
        }


        // Center the popup when the window is resized
        window.addEventListener('resize', function() {
            if (imagePopup.style.display === 'block') {
                centerPopup();
            }
        });

        // Function to center the popup
        function centerPopup() {
            const windowWidth = window.innerWidth;
            const windowHeight = window.innerHeight;
            const popupWidth = imagePopup.offsetWidth;
            const popupHeight = imagePopup.offsetHeight;

            const topPosition = (windowHeight - popupHeight) / 2;
            const leftPosition = (windowWidth - popupWidth) / 2;

            imagePopup.style.top = topPosition + 'px';
            imagePopup.style.left = leftPosition + 'px';
        }

        var hover_images = document.querySelectorAll('.hover-image');
        if (hover_images.length > 0) {
            hover_images.forEach(function(hover_img) {
                hover_img.setAttribute('data-bs-toggle', 'tooltip');
                hover_img.setAttribute('data-bs-placement', 'top');
                hover_img.setAttribute('title', 'Click to Enlarge!');
            });
        }
    });
</script>



<script>
    document.addEventListener('DOMContentLoaded', function() {
        const hoverQRImages = document.querySelectorAll('.hover-qr-image');
        const qrPopup = document.getElementById('qr-popup');
        const popupQRImage = qrPopup.querySelector('img');
        const closeQRBtn = qrPopup.querySelector('.close-btn');

        hoverQRImages.forEach(function(image) {
            image.addEventListener('click', function() {
                const largeImageSrc = this.getAttribute('src');
                popupQRImage.src = largeImageSrc;
                qrPopup.style.display = 'block';
                centerQRPopup();
            });
        });

        closeQRBtn.addEventListener('click', function() {
            qrPopup.style.display = 'none';
        });


        // Center the popup when the window is resized
        window.addEventListener('resize', function() {
            if (qrPopup.style.display === 'block') {
                centerQRPopup();
            }
        });

        // Function to center the popup
        function centerQRPopup() {
            const windowWidth = window.innerWidth;
            const windowHeight = window.innerHeight;
            const popupWidth = qrPopup.offsetWidth;
            const popupHeight = qrPopup.offsetHeight;

            const topPosition = (windowHeight - popupHeight) / 2;
            const leftPosition = (windowWidth - popupWidth) / 2;

            qrPopup.style.top = topPosition + 'px';
            qrPopup.style.left = leftPosition + 'px';
        }

        var hover_qr_images = document.querySelectorAll('.hover-qr-image');
        if (hover_qr_images.length > 0) {
            hover_qr_images.forEach(function(hover_img) {
                hover_img.setAttribute('data-bs-toggle', 'tooltip');
                hover_img.setAttribute('data-bs-placement', 'top');
                hover_img.setAttribute('title', 'Click to Enlarge!');
            });
        }
    });
</script>


{{-- <script>
    $(function() {
        $('[data-toggle="tooltip"]').tooltip({
            container: 'body',
            html: true
        });
    });
</script> --}}


{{-- <script>
    function setupModalDetector() {
        const activeModals = new Set();

        function handleModalShown(event) {
            const modalId = event.target.id;
            activeModals.add(modalId);
            console.log(`Modal "${modalId}" shown. Active modals:`, activeModals);
        }

        function handleModalHidden(event) {
            const modalId = event.target.id;
            activeModals.delete(modalId);
            console.log(`Modal "${modalId}" hidden. Active modals:`, activeModals);
        }

        // Attach event listeners to existing modals
        document.querySelectorAll('.modal').forEach(modal => {
            if (modal.id) {
                modal.addEventListener('shown.bs.modal', handleModalShown);
                modal.addEventListener('hidden.bs.modal', handleModalHidden);
            }
        });

        // Use MutationObserver to detect dynamically added modals
        const observer = new MutationObserver(mutations => {
            mutations.forEach(mutation => {
                if (mutation.addedNodes.length > 0) {
                    mutation.addedNodes.forEach(node => {
                        if (node.classList && node.classList.contains('modal') && node.id) {
                            node.addEventListener('shown.bs.modal', handleModalShown);
                            node.addEventListener('hidden.bs.modal', handleModalHidden);
                        }
                    });
                }
            });
        });

        observer.observe(document.body, {
            childList: true,
            subtree: true
        });
    }

    setupModalDetector();

    function openModal(modalId) {
        const modal = document.querySelector(modalId);
        if (modal) {
            const bootstrapModal = new bootstrap.Modal(modal);
            bootstrapModal.show();
        }
    }
</script> --}}




{{-- <script>
    function openModal(modalId) { //disableBodyScroll
        var modal = document.querySelector(modalId);
        const scrollTargetElement = document.querySelector('.modal-dialog');

        $(document).ready(function() {
            if (modal) {
                var bootstrapModal = new bootstrap.Modal(modal);

                function handleModalShown(event) {
                    const modalId = event.target.id;
                    activeModals.add(modalId);
                    console.log(`Modal "${modalId}" shown. Active modals:`, activeModals);
                    // bodyScrollLock.disableBodyScroll(scrollTargetElement);
                    // console.log('— Scroll Locked');
                }

                function handleModalHidden(event) {
                    const modalId = event.target.id;
                    activeModals.delete(modalId);
                    console.log(`Modal "${modalId}" hidden. Active modals:`, activeModals);
                    // bodyScrollLock.disableBodyScroll(scrollTargetElement);
                    // console.log('— Scroll Unlocked');
                }

                // Attach event listeners to existing modals
                document.querySelectorAll('.modal').forEach(modal => {
                    if (modal.id) {
                        modal.addEventListener('shown.bs.modal', handleModalShown);
                        modal.addEventListener('hidden.bs.modal', handleModalHidden);
                    }
                });

                bootstrapModal.show();

            }
        });

    }
</script> --}}


{{--
<script>
    function openModal(modalId) { //disableBodyScroll
        var modal = document.querySelector(modalId);
        $(document).ready(function() {
            if (modal) {
                var bootstrapModal = new bootstrap.Modal(modal);
                bootstrapModal.show();
            }
        });

    }
</script> --}}

<script>
    const scrollTargetElement = document.querySelector('body');

    // Attach event listener to all modals
    $('.modal').on('hide.bs.modal', function() {
        console.log('Modal Closed:', this.id);
        // document.body.style.overflowY = '';

        // if (document.body.classList.contains('wo-y-scroll')) {
        //     document.body.classList.remove('wo-y-scroll');
        //     document.body.classList.add('w-y-scroll');
        // }
    });
    $('.modal').on('show.bs.modal', function() {
        console.log('Modal Shown:', this.id);
    });

    function openModal(modalId) {
        var modal = document.querySelector(modalId);
        if (modal) {
            // document.body.style.overflowY = 'hidden';
            // if (!document.body.classList.contains('wo-y-scroll')) {
            //     document.body.classList.add('wo-y-scroll');
            //     document.body.classList.remove('w-y-scroll');
            // }
            var bootstrapModal = new bootstrap.Modal(modal);
            bootstrapModal.show();
        } else {
            console.error('Modal not found:', modalId);
        }
    }
</script>






<script>
    // Function to save the scroll position
    function saveScrollPosition() {
        localStorage.setItem('scrollPosition', window.scrollY);
    }

    function restoreScrollPosition() { // Function to restore the scroll position
        const scrollPosition = localStorage.getItem('scrollPosition');
        if (scrollPosition) {
            window.scrollTo(0, parseInt(scrollPosition, 10));
        }
    }
    // Event listener to save & load scroll position on scroll
    window.addEventListener('scroll', saveScrollPosition);
    window.addEventListener('load', restoreScrollPosition);
</script>



<!-- JS: Custom Dynamic Left Floating Button  -->
<script>
    function positionFloatingButton() {
        const pageBody = document.querySelector('body');
        const mainMenu = document.querySelector('.main-menu');
        const floatingContainer = document.querySelector('.left-floatingContainer');

        // Check if the required elements are present
        if (!pageBody || !mainMenu || !floatingContainer) {
            return; // Exit the function if any of the required elements are missing
        }

        const mainMenuWidth = mainMenu.offsetWidth;
        const offsetPercentage = mainMenuWidth * 0.1;
        const screenHeight = window.innerHeight;
        const bottomOffset = screenHeight * 0.046;

        // Check if the main menu has the "hide" class
        const isMainMenuHidden = pageBody.classList.contains('menu-hide');

        // Adjust the floating button position based on the "hide" class
        if (isMainMenuHidden) {
            floatingContainer.style.left = '30px';
        } else {
            floatingContainer.style.left = mainMenuWidth + offsetPercentage + 'px';
            floatingContainer.style.bottom = bottomOffset + 'px';
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        positionFloatingButton();

        // If the main menu width changes dynamically, reposition the floating button
        const mainMenuContent = document.querySelector('.main-menu-content');
        if (mainMenuContent) { // Check if mainMenuContent exists before observing
            const resizeObserver = new ResizeObserver(() => {
                positionFloatingButton();
            });

            resizeObserver.observe(mainMenuContent);
        }

        // Listen for changes in the "hide" class on the body and reposition the floating button
        const bodyObserver = new MutationObserver(() => {
            positionFloatingButton();
        });

        const observerConfig = {
            attributes: true,
            attributeFilter: ['class'],
        };

        bodyObserver.observe(document.body, observerConfig);
    });

    // Function to set the bottom position
    function setBottomPosition() {
        const floatingContainer = document.querySelector(
            '.left-floatingContainer'); // Ensure we get the floating container again
        if (!floatingContainer) {
            return; // Exit if the floating container is not present
        }

        const viewportHeight = window.innerHeight; // Get the height of the viewport
        const bottomOffset = viewportHeight * 0.046; // Calculate 4.6% of the viewport height
        floatingContainer.style.bottom = `${bottomOffset}px`; // Set the bottom style
    }

    // Call the function to set the initial position
    setBottomPosition();

    // Optional: Update the position on window resize
    window.addEventListener('resize', setBottomPosition);
</script>
<!-- ./Custom Dynamic Left Floating Button -->



<!-- Custom Remember TAB Active & Keep active during style change -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Define a unique key for the current page
        const pageId = window.location.pathname; // You can customize this as needed
        const lastTabKey = `lastTab_${pageId}`; // Unique key for each page

        function checkLayoutAndRestoreActiveTab() {
            const layoutPreference = localStorage.getItem('layout');
            const lastTab = localStorage.getItem(lastTabKey) ||
                '#emp-vertical-team'; // Default to the first tab

            const currentLayout = document.documentElement.classList.contains('dark-layout') ? 'dark-layout' :
                'light-layout';
            if ((layoutPreference === 'dark-layout' && currentLayout !== 'dark-layout') ||
                (layoutPreference === 'light-layout' && currentLayout !== 'light-layout')) {
                restoreActiveTab(lastTab);
            } else {
                // Restore the last tab if layout is the same
                restoreActiveTab(lastTab);
            }
        }

        function restoreActiveTab(lastTab) {
            console.log('Restoring last tab:', lastTab); // Debugging log
            const activeTab = document.querySelector(`a[href="${lastTab}"]`);
            if (activeTab) {
                document.querySelectorAll('.nav-link').forEach(t => t.classList.remove('active'));
                activeTab.classList.add('active');

                const activeTabPane = document.querySelector(lastTab);
                if (activeTabPane) {
                    document.querySelectorAll('.tab-pane').forEach(pane => {
                        pane.classList.remove('active', 'show');
                    });
                    activeTabPane.classList.add('active', 'show');
                } else {
                    console.error('Active tab pane not found for id:', lastTab); // Log if the pane is not found
                }
            } else {
                console.error('Active tab not found for href:', lastTab); // Log if the tab is not found
            }
        }

        // Attach a single click event listener to the tab container
        const tabContainer = document.querySelector('.nav-tabs');
        if (tabContainer) {
            tabContainer.addEventListener('click', function(event) {
                const target = event.target.closest('.nav-link'); // Find the closest nav-link
                if (target) {
                    const targetPaneId = target.getAttribute('href');
                    console.log('Clicked tab href:', targetPaneId); // Log the href of the clicked tab

                    // Only remove active classes from other tabs and panes
                    const tabs = document.querySelectorAll('.nav-link');
                    tabs.forEach(t => t.classList.remove('active'));
                    document.querySelectorAll('.tab-pane').forEach(pane => {
                        pane.classList.remove('active', 'show');
                    });

                    if (targetPaneId) {
                        target.classList.add('active');
                        const targetPane = document.querySelector(targetPaneId);
                        if (targetPane) {
                            targetPane.classList.add('active', 'show');
                            localStorage.setItem(lastTabKey,
                                targetPaneId
                            ); // Store the active tab in localStorage with page-specific key
                        } else {
                            console.error('Target pane not found for href:', targetPaneId);
                        }
                    } else {
                        console.error('No href found for clicked tab.');
                    }
                }
            });

            try { // Call the function to check layout and restore the active tab on page load
                checkLayoutAndRestoreActiveTab();
            } catch (error) {}

            // Listen for storage changes to restore the active tab if the layout changes
            window.addEventListener('storage', (event) => {
                if (event.key === 'layout') {
                    checkLayoutAndRestoreActiveTab();
                }
            });
        }

    });
</script>
<!-- ./Custom Remember TAB Active & Keep active during style change -->

<!-- BEGIN: CSRF Auto Regen --> @include('v_res.csrf_regen.v_csrf_regen') <!-- END: CSRF Auto Regen -->
