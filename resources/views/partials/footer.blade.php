    <!-- ============================================================== -->
            <!-- footer -->
            <!-- Modal -->
            <div class="modal fade" id="seeDocument" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Document</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="documentModalBody" style="height: 1000px">
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <footer class="footer text-center text-muted">
                All Rights Reserved by  <a
                    href="https://jarvis-solusi.id/">Jarvis Solusi</a>.
            </footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="/assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <!-- apps -->
    <script src="/assets/js/app-style-switcher.js"></script>
    <script src="/assets/js/feather.min.js"></script>
    <script src="/assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
    <script src="/assets/js/sidebarmenu.js"></script>
    <!--Custom JavaScript -->
    <script src="/assets/js/custom.min.js"></script>
    <!--This page JavaScript -->
    {{-- <script src="/assets/extra-libs/c3/d3.min.js"></script>
    <script src="/assets/extra-libs/c3/c3.min.js"></script>
    <script src="/assets/libs/chartist/dist/chartist.min.js"></script>
    <script src="/assets/libs/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js"></script>
    <script src="/assets/extra-libs/jvector/jquery-jvectormap-2.0.2.min.js"></script>
    <script src="/assets/extra-libs/jvector/jquery-jvectormap-world-mill-en.js"></script> --}}
    {{-- <script src="/assets/js/pages/dashboards/dashboard1.min.js"></script> --}}
    
    {{-- bootstrap-select // plugin bootstrap custom select option --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/js/bootstrap-select.min.js" integrity="sha512-yDlE7vpGDP7o2eftkCiPZ+yuUyEcaBwoJoIhdXv71KZWugFqEphIS3PU60lEkFaz8RxaVsMpSvQxMBaKVwA5xg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        $(document).ready(function() {
            $(document).on('click', '#showDocument', function() {
                $('#documentModalBody').html('')
                $('#imgDocument').attr('src', $(this).data('pathfile'))
                let ifrm = document.createElement("iframe");

                let urldir = $(this).data('baseurl');
                if(urldir === "http://127.0.0.1:8000") {
                    const urldir = $(this).data('baseurl');
                } else {
                    urldir = "https://po.jarvis-solusi.id"
                }

                pathfile = $(this).data('pathfile');
                if(pathfile === "/app/null") {
                    $('#documentModalBody').html(`<small class="text-danger">No uploaded files yet.`)
                } else {
                    ifrm.setAttribute("src", `${urldir}${pathfile}`);
                    ifrm.style.width = "100%";
                    ifrm.style.height = "100%";
                    $('#documentModalBody').append(ifrm)
                }
            })
        })
    </script>
    <script>
        $(document).ready(function() {
            
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('table#example').DataTable();

            let selectPickers = document.getElementsByClassName("btn dropdown-toggle btn-default");
            for(let i = 0; i < selectPickers.length; i++) {
                document.getElementsByClassName("btn dropdown-toggle btn-default")[i].style.borderColor = "#e9ecef";
            }

            $(document).on('click', '#seeTransferProof', function(e) {
                e.preventDefault()
                const path = $(this).data('path')
                Swal.fire({
                    width: 1000,
                    padding: '2em',
                    imageUrl: `${path}`,
                })
            })

            $('#btnAddCategory').on('click', function(e) {
                e.preventDefault()
                $('#formOfAddCategory').removeClass('d-none')
                $('#tableOfCategory').addClass('d-none')
                $('#btnSaveAddCategory').removeClass('d-none')
                $('#btnUpdateReimCategory').addClass('d-none')
                $('#newCategory').val('')
            })
            $('#btnCancelAddCategory').on('click', function(e) {
                e.preventDefault()
                $('#formOfAddCategory').addClass('d-none')
                $('#tableOfCategory').removeClass('d-none')
            })
            $('#btnSaveAddCategory').on('click', function(e) {
                e.preventDefault()
                $('#formOfAddCategory').removeClass('d-none')
                const catValue = $('#newCategory').val()
                const url = `/categories/reimburse?name=${catValue}`
                if(catValue !== "") {
                    const result = controlReimburseCategory(url)
                } else {
                    $('#textDangerCategory').text('this field is required.')
                }
            })

            let catId = 0;
            $(document).on('click', '#btnEditReimCategory', function() {
                $('#formOfAddCategory').removeClass('d-none')
                $('#tableOfCategory').addClass('d-none')
                const catName = $(this).parent().siblings('#catName').text()
                $('#newCategory').val(catName)
                $('#btnUpdateReimCategory').removeClass('d-none')
                $('#btnSaveAddCategory').addClass('d-none')
                catId = $(this).data('catid')
            })
            $(document).on('click', '#btnDeleteReimCategory', function() {
                catId = $(this).data('catid')
                Swal.fire({
                    icon: 'warning',
                    title: 'Delete Data?',
                    showCancelButton: true,
                    confirmButtonText: 'Confirm',
                }).then((result) => {
                    if (result.isConfirmed) {
                        const catValue = $('#newCategory').val()
                        const url = `/categories/reimburse?id=${catId}&deleted=true`
                        const result = controlReimburseCategory(url)
                        $(this).parent().parent().remove()
                    }
                })
            })
            
            $('#btnUpdateReimCategory').on('click', async function(e) {
                e.preventDefault()
                const catValue = $('#newCategory').val()
                const url = `/categories/reimburse?name=${catValue}&id=${catId}`
                const result = controlReimburseCategory(url)
            })

            const controlReimburseCategory = async (url) => {
                const result = await fetch(url).then(res => res.json())
                if(result.status == 200) {
                    $('#alertSuksesNewCategory').removeClass('d-none')
                    $('#formOfAddCategory').addClass('d-none')
                    $('#tableOfCategory').removeClass('d-none')

                    if(result.type === "added") {
                        $('#alertSuksesNewCategory').text('New Reimburse Category Added')
                    } else if(result.type === "updated") {
                        $('#alertSuksesNewCategory').text('Reimburse Category Updated')
                    } else {
                        $('#alertSuksesNewCategory').text('Reimburse Category Deleted')
                    }
                    $('#tbodyOfCategories').html('')
                    getAllReimCats()
                }
            }

            const getAllReimCats = async () => {
                const result = await fetch(`/categories/reimburse/all`).then(res => res.json())
                if(result.data.length > 0) {
                    let rowHTML = ''
                    $.each(result.data, function(i, cat) {
                          rowHTML += `<tr>
                                        <th>${i+1}</th>
                                        <th id="catName">${cat.name}</th>
                                        <td>
                                            <button class="btn btn-sm btn-danger" data-catid="${cat.id}" id="btnDeleteReimCategory"><i class="fas fa-trash"></i></button>
                                            <button class="btn btn-sm btn-primary" data-catid="${cat.id}" id="btnEditReimCategory"><i class="fas fa-pencil"></i></button>
                                        </td>
                                     </tr>`
                    })
                    $('#tbodyOfCategories').html(rowHTML)
                }
            }


            const inputOrderList = $('.inputOrderList')
            const smallOrderList = $('.smallOrderList')
            $('#orderListing').hide()
            $('#btnAddOrder').on('click', function(e) {
                e.preventDefault()

                const inputTitle = $('input[name="orderlistTitle"]')
                const inputQty = $('input[name="quantity"]')
                const inputVolume = $('input[name="volume"]')
                const inputDuration = $('input[name="duration"]');
                const inputUnitPrice = $('input[name="unitPrice"]')
                if(inputTitle.val()=== "" || inputUnitPrice.val() === "") 
                {
                    for(let o = 0; o < inputOrderList.length; o++) {
                        inputOrderList[o].classList.add('is-invalid')
                        smallOrderList[o].innerHTML = "please fill this field"
                    }
                } else {

                    const category = $('#category');
                    let htmlOrderlisting = '';

                    if(category.children(':selected').text().toLowerCase() == 'maintenance'){
                        htmlOrderlisting = `<tr class="row-keranjang">
                                                    <th>
                                                        ${inputTitle.val()}
                                                        <input name="title[]" type="hidden" value="${inputTitle.val()}">
                                                    </th>
                                                    <th>
                                                        ${inputQty.val()}
                                                        <input name="qty[]" type="hidden" value="${inputQty.val()}">
                                                    </th>
                                                    <th>
                                                        ${inputDuration.val()}
                                                        <input name="duration[]" type="hidden" value="${inputDuration.val()}">
                                                    </th>
                                                    <th>
                                                        Rp. ${inputUnitPrice.val()},-
                                                        <input name="unit_price[]" type="hidden" value="${inputUnitPrice.val()}">
                                                    </th>
                                                    <th>
                                                        <a href="" class="btn btn-danger" id="btnDeleteRow">Delete</a>  
                                                    </th>
                                                </tr>`;
                    } else if(category.children(':selected').text().toLowerCase() == 'outsource'){
                        htmlOrderlisting = `<tr class="row-keranjang">
                                                    <th>
                                                        ${inputTitle.val()}
                                                        <input name="title[]" type="hidden" value="${inputTitle.val()}">
                                                    </th>
                                                    <th>
                                                        ${inputDuration.val()}
                                                        <input name="duration[]" type="hidden" value="${inputDuration.val()}">
                                                    </th>
                                                    <th>
                                                        Rp. ${inputUnitPrice.val()},-
                                                        <input name="unit_price[]" type="hidden" value="${inputUnitPrice.val()}">
                                                    </th>
                                                    <th>
                                                        <a href="" class="btn btn-danger" id="btnDeleteRow">Delete</a>  
                                                    </th>
                                                </tr>`;
                    } else{
                        htmlOrderlisting = `<tr class="row-keranjang">
                                                    <th>
                                                        ${inputTitle.val()}
                                                        <input name="title[]" type="hidden" value="${inputTitle.val()}">
                                                    </th>
                                                    <th>
                                                        ${inputQty.val()}
                                                        <input name="qty[]" type="hidden" value="${inputQty.val()}">
                                                    </th>
                                                    <th>
                                                        ${inputVolume.val()}
                                                        <input name="volume[]" type="hidden" value="${inputVolume.val()}">
                                                    </th>
                                                    <th>
                                                        Rp. ${inputUnitPrice.val()},-
                                                        <input name="unit_price[]" type="hidden" value="${inputUnitPrice.val()}">
                                                    </th>
                                                    <th>
                                                        <a href="" class="btn btn-danger" id="btnDeleteRow">Delete</a>  
                                                    </th>
                                                </tr>`;
                    }
                    $('#orderListing').show()
                    $('#tBodyOrderListing').append(htmlOrderlisting);
                    $('trix-editor').text('')
                    inputTitle.val('')
                    inputQty.val('')
                    inputDuration.val('');
                    inputUnitPrice.val('')
                }
            })


            const btnAddToList = $('#btnAddToList')
            const workerListing = $('#workerListing')
            const tBody = $('#tBody')
            const listingInputs = $('.listingInputs')
            const fieldCustomer = $('#fieldCustomer')
            const fieldWorkers = $('#fieldWorkers')
            const selectorTextDanger = $('#selectorTextDanger')

            workerListing.hide()
            fieldCustomer.hide()
            btnAddToList.on('click', function(e) {
                e.preventDefault()
                const workerSelector = $("select[name='worker_name']")

                if(workerSelector.val() === "") {
                    selectorTextDanger.html('Please select worker')
                } else {
                    const url = `/listing?id=${workerSelector.val()}`
                            
                    fetch(url)
                    .then(response => response.text())
                    .then(data => {
                        workerListing.show()
                        fieldCustomer.show()
                        tBody.append(data);

                        workerSelector.val('')
                    })
                }
            })

            $('select[name="category"]').on('change', function(e) {
                if($(this).val() == 2) {
                    fieldCustomer.show()
                    fieldWorkers.hide()
                } else {
                    fieldCustomer.hide()
                    fieldWorkers.show()
                }
            })

            $(document).on('click', '#btnDeleteRow', function(e) {
                e.preventDefault()
                $(this).closest('.row-keranjang').remove();
                if (tBody.children().length == 0) {
                    workerListing.hide()
                    fieldCustomer.hide()
                }
                if ($('#tBodyOrderListing').children().length == 0) {
                    $('#orderListing').hide()
                }
            })


            // SWEET ALERT CONFIRMATION FOR CREATE NEW PURCHASE AND NEW USER
            $(document).on('click', '#btnSubmitted', function(e) {
                e.preventDefault()
                Swal.fire({
                    icon: 'warning',
                    title: 'Save Data?',
                    showCancelButton: true,
                    confirmButtonText: 'Confirm',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $(this).closest('#formSubmitted').submit()
                    }
                })
            })


            // JS EDIT KATEGORI
            const btnEdit = $('#btnEdit')
            const btnCancelEdit = $('#btnCancelEdit')
            const btnConfirmEdit = $('#btnConfirmEdit')
            const btnDelete = $('#btnDelete')
            const inputCategory = $('#inputCategory')

            btnCancelEdit.hide()
            btnConfirmEdit.hide()
            btnEdit.on('click', function(e) {
                e.preventDefault()
                inputCategory.removeAttr('readonly')
                btnCancelEdit.show()
                btnConfirmEdit.show()
                btnDelete.hide()
                btnEdit.hide()
            })

            btnCancelEdit.on('click', function(e) {
                e.preventDefault()
                inputCategory.attr('readonly', true)
                btnCancelEdit.hide()
                btnConfirmEdit.hide()
                btnDelete.show()
                btnEdit.show()
            })

            btnConfirmEdit.on('click', function(e) {
                e.preventDefault()
                Swal.fire({
                    icon: 'warning',
                    title: 'Update Category?',
                    showCancelButton: true,
                    confirmButtonText: 'Confirm',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $(this).closest('#formSubmitted').submit()
                    }
                })
            })

            // BTN DELETE
            $(document).on('click', '#btnDelete', function(e) {
                e.preventDefault()
                Swal.fire({
                    icon: 'warning',
                    title: 'Delete Data?',
                    showCancelButton: true,
                    confirmButtonText: 'Confirm',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $(this).closest('#formDeleteSubmitted').submit()
                    }
                })
            })



            // JS ADD NEW KATEGORI
            const btnNewCat = $('#btnNewCat')
            const btnCancelAdd = $('#btnCancelAdd')
            const btnConfirmAdd = $('#btnConfirmAdd')
            const cardNewCat = $('#cardNewCat')
            const inputNewCat = $('input[name="category"]')
            const textNewCat = document.querySelector('#textNewCat')

            cardNewCat.hide()
            btnCancelAdd.hide()
            btnConfirmAdd.hide()
            btnNewCat.on('click', function(e) {
                e.preventDefault()
                cardNewCat.show()
                btnCancelAdd.show()
                btnConfirmAdd.show()
            })

            btnCancelAdd.on('click', function(e) {
                e.preventDefault()
                cardNewCat.hide()
                btnCancelAdd.hide()
                btnConfirmAdd.hide()
            })

            btnConfirmAdd.on('click', function(e) {
                e.preventDefault()
                if(inputNewCat.val() === "") {
                    textNewCat.innerHTML = "please fill this field";
                } else {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Add New Category?',
                        showCancelButton: true,
                        confirmButtonText: 'Confirm',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $(this).closest('#formSubmitted').submit()
                        }
                    })
                }
            })

            // Confirm Update User
            const btnConfirmUpdateUser = $('#btnConfirmUpdateUser')
            btnConfirmUpdateUser.on('click', function(e) {
                e.preventDefault()
                Swal.fire({
                    icon: 'warning',
                    title: 'Update User?',
                    showCancelButton: true,
                    confirmButtonText: 'Confirm',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $(this).closest('#formSubmitted').submit()
                    }
                })
            })

            const btnConfirmEditWorker = $('#btnConfirmEditWorker')
            btnConfirmEditWorker.on('click', function(e) {
                e.preventDefault()
                Swal.fire({
                    icon: 'warning',
                    title: 'Update Worker?',
                    showCancelButton: true,
                    confirmButtonText: 'Confirm',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $(this).closest('#formSubmitted').submit()
                    }
                })
            })

            const btnSaveWorker = $('#btnSaveWorker')
            btnSaveWorker.on('click', function(e) {
                e.preventDefault()
                Swal.fire({
                    icon: 'warning',
                    title: 'Add New Worker?',
                    showCancelButton: true,
                    confirmButtonText: 'Confirm',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $(this).closest('#formSubmitted').submit()
                    }
                })
            })

            
            $('#btnSaveOrderlist').on('click', function(e) {
                e.preventDefault()
                Swal.fire({
                    icon: 'warning',
                    title: 'Add New Orderlist?',
                    showCancelButton: true,
                    confirmButtonText: 'Confirm',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $(this).closest('#formSubmitted').submit()
                    }
                })
            })

            // $('#btnPrintInvoiceRN').on('click', function(e) {
            //     e.preventDefault()
            //     Swal.fire({
            //         icon: 'warning',
            //         title: 'Print Invoice?',
            //         showCancelButton: true,
            //         confirmButtonText: 'Confirm',
            //     }).then((result) => {
            //         if (result.isConfirmed) {
            //             $(this).closest('#formUpdateApproval').submit()
            //         }
            //     })
            // })

            $(document).on('click', '#sendInfoToTelegram', function(e) {
                e.preventDefault()
                Swal.fire({
                    icon: 'warning',
                    title: 'Send Info to Telegram?',
                    showCancelButton: true,
                    confirmButtonText: 'Confirm',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $(this).closest('#formSendInfoToTelegram').submit()
                    }
                })
            })


        } );
    </script>
    <script>
        document.addEventListener('trix-file-accept', function(e) {
            e.preventDefault()
        })
    </script>
    <script src="/assets/js/jquery.dataTables.min.js"></script>
    <script src="/assets/js/dataTables.bootstrap4.min.js"></script>
    <script src="/assets/js/dataTables.responsive.min.js"></script>
    <script src="/assets/js/responsive.bootstrap4.min.js"></script>
</body>

</html>